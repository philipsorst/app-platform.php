import {Component, OnInit} from "@angular/core";
import {Restangular} from "ngx-restangular";
import {User} from "../model/user";
import {UserService} from "../service/user.service";

@Component({
    templateUrl: './user.component.html'
})
export class UserComponent implements OnInit {

    public user: User;

    constructor(private restangular: Restangular, private userService: UserService) {
    }

    public ngOnInit() {
        this.loadUser();
    }

    public loadUser() {
        this.userService.assertAuthenticated()
            .then(() => {
                this.restangular.one('users', 'me').get().toPromise().then((user: User) => {
                    this.user = user;
                })
            });
    }
}
