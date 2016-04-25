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
        vm.openMobileNav = openMobileNav;
        vm.closeMobileNav = closeMobileNav;
        vm.toggleMobileNav = toggleMobileNav;

        activate();

        function activate () {
            initUser();
            $rootScope.$on('userUpdated', initUser);
            $rootScope.$on('$stateChangeStart', closeMobileNav);
        }

        function initUser () {
            vm.loggedIn = false;
            vm.user = UserService.getCurrentUser();

            if (vm.user.token) {
                vm.loggedIn = true;
            }
        }

        function openMobileNav () {
            vm.isMobileNavOpen = true;
        }

        function closeMobileNav () {
            vm.isMobileNavOpen = false;
        }

        function toggleMobileNav () {
            vm.isMobileNavOpen = !vm.isMobileNavOpen;
        }
    }

})();

