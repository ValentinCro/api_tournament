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
            
        }
    }

})();