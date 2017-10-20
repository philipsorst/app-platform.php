import {apiConfig} from "../../environments/api-config";
import {CollectionResult} from "../model/collection-result";
import {UrlInfo} from "../model/url-info";
import {PartialCollectionView} from "../model/partial-collection-view";

export function RestangularConfigFactory(RestangularProvider) {

    let baseUrl = UrlInfo.parse(apiConfig.baseUrl);

    /**
     * Make URL absolute, so Restangular can handle it properly.
     */
    function absolutizeUrl(url: string): string | null {
        if (null == url) {
            return url;
        }

        return baseUrl.getRoot() + url;
    }

    RestangularProvider.setBaseUrl(apiConfig.baseUrl);
    RestangularProvider.setSelfLinkAbsoluteUrl(true);

    /* Hydra collections support */
    RestangularProvider.addResponseInterceptor((data, operation) => {

        /* Rewrite the href so restangular can handle it */
        function setHref(data) {
            if (null != data && data['@id']) {
                data['href'] = absolutizeUrl(data['@id']);
            }
        }

        /* Populate href property for the collection */
        setHref(data);

        if ('getList' === operation) {

            let collectionResult = new CollectionResult();
            for (let result of data['hydra:member']) {
                setHref(result);
                collectionResult.push(result);
            }
            collectionResult.totalItems = data['hydra:totalItems'];
            if (data.hasOwnProperty('hydra:view')) {
                let viewData = data['hydra:view'];
                let partialCollectionView = new PartialCollectionView();
                partialCollectionView.first = absolutizeUrl(viewData['hydra:first']);
                partialCollectionView.next = absolutizeUrl(viewData['hydra:next']);
                partialCollectionView.previous = absolutizeUrl(viewData['hydra:previous']);
                partialCollectionView.last = absolutizeUrl(viewData['hydra:last']);
                collectionResult.partialCollectionView = partialCollectionView;
            }

            return collectionResult;
        }

        return data;
    });
}
