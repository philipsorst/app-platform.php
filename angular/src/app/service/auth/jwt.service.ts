import {Injectable} from "@angular/core";
import jwt_decode from 'jwt-decode';

@Injectable()
export class JwtService {

    private token;

    private tokenExpiry;

    public setTokens(token: string, refreshToken: string) {
        this.setToken(token);
        localStorage.setItem('jwt_refresh_token', refreshToken);
    }

    public setToken(token: string) {
        this.token = token;
        let decodedToken = jwt_decode(token);
        this.tokenExpiry = decodedToken.exp * 1000;
        console.log('Token expiry', new Date(this.tokenExpiry));
    }

    public getToken() {
        return this.token;
    }

    public getRefreshToken() {
        return localStorage.getItem('jwt_refresh_token');
    }

    public isExpired(): boolean {
        let now = new Date().getTime();
        return null == this.tokenExpiry || this.tokenExpiry - 10000 < now;
    }
}
