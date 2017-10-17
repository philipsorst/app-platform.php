import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {UserComponent} from "../component/user.component";
import {LoginComponent} from "../component/login.component";
import {LoggedinAuthGuardService} from "../service/auth/loggedin-auth-guard.service";

const routes: Routes = [
    {
        path: '',
        children: []
    },
    {path: 'user', component: UserComponent, canActivate: [LoggedinAuthGuardService]},
    {path: 'login', component: LoginComponent}
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule]
})
export class AppRoutingModule {
}
