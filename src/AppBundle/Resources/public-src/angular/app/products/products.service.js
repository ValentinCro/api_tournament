(function () {
    'use strict';

    angular
        .module('app')
        .service('ProductsService', ProductsService);

    ProductsService.$inject = ['$http', '$q'];

    /* @ngInject */
    function ProductsService($http, $q) {
        var service = this;

        service.getProducts = getProducts;

        ////////////////

        function getProducts() {
            var defer = $q.defer();

            $http.get('/api/products')
                .then(function (response) {
                    defer.resolve(response.data);
                })
                .catch(function (response) {
                    defer.reject(response);
                });

            return defer.promise;
        }
    }

})();

