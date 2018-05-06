import {BrowserModule} from '@angular/platform-browser';
import {APP_INITIALIZER, NgModule} from '@angular/core';

import {AppRoutingModule} from './app-routing.module';
import {AppComponent} from './app.component';
import {ServiceWorkerModule} from '@angular/service-worker';
import {environment} from '../environments/environment';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {LayoutModule} from '@angular/cdk/layout';
import {MatButtonModule, MatIconModule, MatListModule, MatSidenavModule, MatToolbarModule} from '@angular/material';
import {InitService} from "./init.service";
import {HomeComponent} from './example/home.component';
import {UserComponent} from './example/user.component';
import {LoginComponent} from './security/login.component';

export function initServiceFactory(initService: InitService): Function
{
    return () => initService.initialize();
}

@NgModule({
    declarations: [
        AppComponent,
        LoginComponent,
        HomeComponent,
        UserComponent
    ],
    imports: [
        BrowserModule,
        AppRoutingModule,
        ServiceWorkerModule.register('/ngsw-worker.js', {enabled: environment.production}),
        BrowserAnimationsModule,
        LayoutModule,
        MatToolbarModule,
        MatButtonModule,
        MatSidenavModule,
        MatIconModule,
        MatListModule
    ],
    providers: [
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
export class AppModule
{
}
