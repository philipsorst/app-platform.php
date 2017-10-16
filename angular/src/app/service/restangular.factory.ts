import {apiConfig} from "../../environments/api-config";
import {CollectionResult} from "../../model/collection-result";
import {Pagination} from "../../model/pagination";

export function RestangularConfigFactory(RestangularProvider) {

    RestangularProvider.setBaseUrl(apiConfig.baseUrl);
    RestangularProvider.setRestangularFields({
        selfLink: '_links.self.href'
    });

    RestangularProvider.addResponseInterceptor((data, operation, what, url, response: Response) => {
        if ('getList' === operation) {
            let collectionResult: CollectionResult<any> = new CollectionResult();
            for (let datum of data) {
                collectionResult.push(datum);
            }

            if (response.headers.has('x-pagination-current-page')) {
                let pagination = new Pagination();
                pagination.currentPage = +response.headers.get('x-pagination-current-page');
                pagination.perPage = +response.headers.get('x-pagination-per-page');
                pagination.total = +response.headers.get('x-pagination-total');
                pagination.totalPages = +response.headers.get('x-pagination-total-pages');
                collectionResult.pagination = pagination;
            }

            return collectionResult;
        }

        return data;
    });
}
