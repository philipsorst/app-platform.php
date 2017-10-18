import {BrowserModule} from '@angular/platform-browser';
import {APP_INITIALIZER, NgModule} from '@angular/core';

import {AppRoutingModule} from './app-routing.module';
import {AppComponent} from "../component/app.component";
import {UserComponent} from "../component/user.component";
import {BrowserAnimationsModule} from "@angular/platform-browser/animations";
import {
    MatButtonModule,
    MatFormFieldModule,
    MatIconModule,
    MatInputModule,
    MatListModule,
    MatSidenavModule,
    MatToolbarModule
} from "@angular/material";
import {RestangularConfigFactory} from "../service/restangular.factory";
import {RestangularModule} from "ngx-restangular";
import {LoginComponent} from "../component/login.component";
import {UserService} from "../service/user.service";
import {FormsModule} from "@angular/forms";
import {LoggedinAuthGuardService} from "../service/auth/loggedin-auth-guard.service";
import {InitService} from "../service/init.service";

export function initServiceFactory(initService: InitService): Function {
    return () => initService.initialize();
}

@NgModule({
    declarations: [
        AppComponent,
        UserComponent,
        LoginComponent
    ],
    imports: [
        BrowserModule,
        BrowserAnimationsModule,
        AppRoutingModule,
        FormsModule,
        RestangularModule.forRoot(RestangularConfigFactory),
        MatIconModule,
        MatToolbarModule,
        MatSidenavModule,
        MatButtonModule,
        MatListModule,
        MatFormFieldModule,
        MatInputModule
    ],
    providers: [
        UserService,
        LoggedinAuthGuardService,
        InitService,
        {
            provide: APP_INITIALIZER,
            useFactory: initServiceFactory,
            deps: [InitService],
            multi: true
        }
    ],
    bootstrap: [AppComponent]
})
export class AppModule {
}
