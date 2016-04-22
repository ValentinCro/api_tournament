(function () {
    'use strict';

    angular
        .module('app')
        .directive('topbar', topbar);

    topbar.$inject = [];

    /* @ngInject */
    function topbar() {
        var directive = {
            replace:          true,
            templateUrl:      'bundles/app/html/app/layout/topbar.directive.html',
            bindToController: true,
            controller:       TopbarController,
            controllerAs:     'vm',
            link:             link,
            restrict:         'E',
            scope:            {}
        };
        return directive;

        function link(scope, element, attrs) {

        }
    }

    TopbarController.$inject = ['$rootScope', 'UserService'];

    /* @ngInject */
    function TopbarController($rootScope, UserService) {
        var vm = this;

        vm.user = {};
        vm.loggedIn = false;

        activate();

        function activate () {
            initUser();
            $rootScope.$on('userUpdated', initUser);
        }

        function initUser () {
            vm.loggedIn = false;
            vm.user = UserService.getCurrentUser();

            if (vm.user.token) {
                vm.loggedIn = true;
            }
        }
    }

})();

