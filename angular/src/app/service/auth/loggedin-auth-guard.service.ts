import {Injectable} from "@angular/core";
import {UserService} from "../user.service";
import {ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot} from "@angular/router";
import {Observable} from "rxjs/Observable";

@Injectable()
export class LoggedinAuthGuardService implements CanActivate {

    constructor(private userService: UserService, private router: Router) {
    }

    canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean | Observable<boolean> | Promise<boolean> {
        if (this.userService.isLoggedIn()) {
            return true;
        }

        this.router.navigate(['/login'], {queryParams: {returnUrl: state.url}});
        return false;
    }
}
