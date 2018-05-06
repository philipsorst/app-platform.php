import {Injectable} from "@angular/core";

@Injectable()
export class InitService
{
    constructor()
    {
    }

    /**
     * Performs necessary operations to initialize the App (espc. fetching data). Be aware that authentication is not
     * available yet.
     *
     * @returns {Promise} Promise that will be resolved after everything has been initialized
     * and the app can continue.
     */
    public initialize(): Promise<any>
    {
        return Promise.resolve(true);
    }
}
