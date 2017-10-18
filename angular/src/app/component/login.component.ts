import {Component, OnInit} from "@angular/core";
import {UserService} from "../service/user.service";
import {ActivatedRoute, Router} from "@angular/router";
import {Credentials} from "../model/credentials";
import {MatSnackBar} from "@angular/material";

@Component({
    templateUrl: './login.component.html'
})
export class LoginComponent implements OnInit {

    public credentials: Credentials = new Credentials();

    public loggingin: boolean = false;

    private returnUrl: string;

    constructor(private userService: UserService,
                private router: Router,
                private route: ActivatedRoute,
                private snackBar: MatSnackBar) {
    }

    ngOnInit() {
        this.returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/';
    }

    public login() {
        this.loggingin = true;
        this.userService.login(this.credentials)
            .then(() => this.router.navigateByUrl(this.returnUrl))
            .catch((reason) => this.snackBar.open(reason.data.message))
            .then(() => this.loggingin = false)
    }
}
