(function () {
    'use strict';

    angular
        .module('app')
        .controller('AppController', AppController);

    AppController.$inject = ['$rootScope'];

    /* @ngInject */
    function AppController($rootScope) {
        var vm = this;

        vm.stateLoading = false;

        activate();

        ////////////////

        function activate() {
            $rootScope.$on("$stateChangeStart", function() {
                vm.stateLoading = true;
            });

            $rootScope.$on("$stateChangeSuccess", function() {
                vm.stateLoading = false;
            });
            $rootScope.$on("$stateChangeError", function() {
                vm.stateLoading = false;
            });
            $rootScope.$on("$stateNotFound", function() {
                vm.stateLoading = false;
            });
        }
    }

})();

