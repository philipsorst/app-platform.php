import {Injectable} from "@angular/core";
import {UserService} from "../user.service";
import {ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot} from "@angular/router";
import {Observable} from "rxjs/Observable";
import {User} from "../../model/user";

@Injectable()
export class LoggedinAuthGuardService implements CanActivate {

    constructor(private userService: UserService, private router: Router) {
    }

    canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean | Observable<boolean> | Promise<boolean> {
        if (this.userService.isLoggedIn()) {
            return true;
        }

        return this.userService.loginRemembered()
            .then((user: User) => {
                return true
            })
            .catch(() => {
                this.router.navigate(['/login'], {queryParams: {returnUrl: state.url}});
                return false;
            });
    }
}
