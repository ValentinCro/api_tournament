(function () {
    'use strict';

    angular
        .module('app')
        .controller('DashboardController', DashboardController);

    DashboardController.$inject = ['$http'];

    /* @ngInject */
    function DashboardController($http) {
        var vm = this;

        activate();

        ////////////////

        function activate() {
            $http.get('/api/products')
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (response) {
                    console.log(response);
                });
        }
    }

})();