import {Injectable} from "@angular/core";
import {Restangular} from "ngx-restangular";
import {Credentials} from "../model/credentials";
import {User} from "../model/user";
import {BehaviorSubject} from "rxjs/BehaviorSubject";
import {JwtService} from "./auth/jwt.service";


@Injectable()
export class UserService {

    private currentUser: BehaviorSubject<User> = new BehaviorSubject<User>(null);

    private refreshPromise: Promise<any>;

    constructor(private restangular: Restangular, private jwtService: JwtService) {
    }

    public isLoggedIn() {
        return this.currentUser.getValue() != null;
    }

    public login(credentials: Credentials): Promise<User> {
        return this.restangular.all('login_check').post(credentials).toPromise()
            .then((response) => {
                return this.processTokenResponse(response);
            });
    }

    public loginRemembered(): Promise<User> {
        let refreshToken = this.jwtService.getRefreshToken();
        if (null != refreshToken) {
            return this.restangular.all('token').all('refresh').post({refresh_token: refreshToken}).toPromise()
                .then((response) => {
                    return this.processTokenResponse(response);
                });
        }

        return Promise.reject('No refresh token found');
    }

    public assertAuthenticated(): Promise<any> {
        if (!this.jwtService.isExpired()) {
            return Promise.resolve(true);
        }

        if (null != this.refreshPromise) {
            return this.refreshPromise;
        }

        let refreshToken = this.jwtService.getRefreshToken();
        if (null != refreshToken) {
            this.refreshPromise = this.restangular.all('token').all('refresh').post({refresh_token: refreshToken}).toPromise()
                .then((response) => {
                    this.jwtService.setTokens(response.token, response.refresh_token);
                    this.restangular.configuration.defaultHeaders.Authorization = 'Bearer ' + response.token;
                    this.refreshPromise = null;

                    return response.token;
                });

            return this.refreshPromise;
        }

        return Promise.reject('No refresh token found');
    }

    private processTokenResponse(response): Promise<User> {
        this.jwtService.setTokens(response.token, response.refresh_token);
        this.restangular.configuration.defaultHeaders.Authorization = 'Bearer ' + response.token;
        return this.restangular.one('users', 'me').get().toPromise()
            .then((user: User) => {
                this.currentUser.next(user);

                return user;
            });
    }
}
