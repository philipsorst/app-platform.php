import {Component} from '@angular/core';
import {BreakpointObserver, Breakpoints, BreakpointState} from '@angular/cdk/layout';
import {Observable} from 'rxjs';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss']
})
export class AppComponent
{
    public isHandset: Observable<BreakpointState> = this.breakpointObserver.observe(Breakpoints.Handset);

    constructor(private breakpointObserver: BreakpointObserver)
    {
    }
}
