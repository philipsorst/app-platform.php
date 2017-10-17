import {Injectable} from "@angular/core";
import {Restangular} from "ngx-restangular";
import {Credentials} from "../model/credentials";
import {User} from "../model/user";
import {BehaviorSubject} from "rxjs/BehaviorSubject";

@Injectable()
export class UserService {

    private currentUser: BehaviorSubject<User> = new BehaviorSubject<User>(null);

    constructor(private restangular: Restangular) {
    }

    public isLoggedIn() {
        return this.currentUser.getValue() != null;
    }

    public login(credentials: Credentials): Promise<User> {
        return this.restangular.all('login_check').post(credentials).toPromise().then((response) => {
            this.restangular.configuration.defaultHeaders.Authorization = 'Bearer ' + response.token;
            // this.cookieService.set('token', response.token);
            return this.restangular.one('users', 'me').get().toPromise().then((response) => {
                this.currentUser.next(response);

                return response;
            });
        });
    }
}
