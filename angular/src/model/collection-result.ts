import {Pagination} from "./pagination";

export class CollectionResult<T> extends Array<T> {
    pagination: Pagination;
}
