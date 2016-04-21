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
            scope:            {
                view: '@'
            }
        };
        return directive;

        function link(scope, element, attrs) {

        }
    }

    TopbarController.$inject = [];

    /* @ngInject */
    function TopbarController() {
        var vm = this;

        activate();

        function activate () {
        }
    }

})();

