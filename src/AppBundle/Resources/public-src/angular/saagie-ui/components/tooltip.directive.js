(function () {
    'use strict';

    angular
        .module('ui.saagie')
        .directive('uiTooltip', uiTooltip);

    uiTooltip.$inject = ['$document'];

    /* @ngInject */
    function uiTooltip($document) {
        var directive = {
            bindToController: true,
            controller:       uiTooltipController,
            controllerAs:     'vm',
            link:             link,
            restrict:         'A',
            scope:            {
                uiTooltip: '@',
                uiTooltipOptions: '='
            }
        };
        return directive;

        function link(scope, element, attrs) {
            scope.vm.target = element[0];

            // Create
            // -------------------------
            scope.vm.create();

            // Close on click
            // -------------------------
            $document.on('click.uiTooltip', function () {
                scope.vm.close();
            });
        }
    }

    /* ------------------------- *\
        Directive controller
    \* ------------------------- */
    uiTooltipController.$inject = ['$scope'];

    /* @ngInject */
    function uiTooltipController($scope) {
        var vm = this;
        var isTouchDevice = 'ontouchstart' in window || navigator.msMaxTouchPoints;

        vm.create = create;
        vm.close = close;
        vm.destroy = destroy;
        vm.reload = reload;

        activate();

        function activate () {
            $scope.$watchGroup(['vm.uiTooltip', 'vm.uiTooltipOptions'], function () {
                vm.reload();
            });
        }

        function create () {
            if(isTouchDevice) {
                return;
            }

            var _DropTooltip = Drop.createContext({
                classPrefix: 'c-tooltip'
            });

            var options = {
                position: 'right middle',
                style:    'default'
            }

            if (vm.uiTooltipOptions) {
                angular.merge(options, vm.uiTooltipOptions);
            }

            vm.tooltip = new _DropTooltip({
                target: vm.target,
                content: vm.uiTooltip,
                classes: 'as--' + options.style.toLowerCase(),
                position: options.position,
                openOn: 'hover',
                remove: true
            });
        }

        function close () {
            if(isTouchDevice) {
                return;
            }

            vm.tooltip.close();
        }

        function destroy () {
            if(isTouchDevice) {
                return;
            }

            vm.tooltip.destroy();
        }

        function reload () {
            vm.destroy();
            vm.create();
        }
    }

})();

