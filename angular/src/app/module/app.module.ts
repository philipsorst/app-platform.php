import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {AppRoutingModule} from './app-routing.module';
import {AppComponent} from "../component/app.component";
import {UserComponent} from "../component/user.component";
import {BrowserAnimationsModule} from "@angular/platform-browser/animations";
import {MatButtonModule, MatIconModule, MatSidenavModule, MatToolbarModule} from "@angular/material";
import {RestangularConfigFactory} from "../service/restangular.factory";
import {RestangularModule} from "ngx-restangular";

@NgModule({
    declarations: [
        AppComponent,
        UserComponent
    ],
    imports: [
        BrowserModule,
        BrowserAnimationsModule,
        AppRoutingModule,
        RestangularModule.forRoot(RestangularConfigFactory),
        MatIconModule,
        MatToolbarModule,
        MatSidenavModule,
        MatButtonModule
    ],
    providers: [],
    bootstrap: [AppComponent]
})
export class AppModule {
}
