(function () {
    'use strict';

    angular
        .module('ui.saagie')
        .directive('uiDropdown', uiDropdown);

    uiDropdown.$inject = [];

    /* @ngInject */
    function uiDropdown() {
        var directive = {
            replace:          true,
            bindToController: true,
            controller:       uiDropdownController,
            controllerAs:     'vm',
            link:             link,
            restrict:         'E',
            transclude:       {
                button: 'uiDropdownButton',
                menu:   'uiDropdownMenu'
            },
            scope:            {
                options: '=',
                disabled: '=ngDisabled'
            },
            templateUrl:      '/bundles/app/html/saagie-ui/components/dropdown.directive.html'

        };
        return directive;

        function link(scope, element, attrs) {
            scope.vm.element = element;
            scope.vm.target = element.find('.o-dropdown__button')[0];
            scope.vm.content = element.find('.o-dropdown__menu')[0];

            scope.vm.create();

            angular.element('body').on('click.ui.dropdown.in', '.o-dropdown__drop .o-dropdown__menu a:not([ui-click-confirm]), .o-dropdown__drop .o-dropdown__menu button:not([ui-click-confirm])', function () {
                scope.vm.close();
            });
        }
    }

    uiDropdownController.$inject = ['$rootScope', '$scope'];

    /* @ngInject */
    function uiDropdownController($rootScope, $scope) {
        var vm = this;

        vm.create = create;
        vm.close = close;
        vm.destroy = destroy;
        vm.reload = reload;

        activate();

        function activate () {
            $scope.$watch('vm.disabled', function () {
                if (vm.disabled) {
                    vm.destroy();
                    return;
                }

                vm.create();
            });

            $scope.$watch('vm.options', function () {
                vm.reload();
            });

            // Close when global event 'ui.dropdown.closeAll' is called
            // -------------------------
            $rootScope.$on('ui.dropdown.closeAll', function () {
                vm.close();
            });
        }

        function create () {
            var _DropDropdown = Drop.createContext({
                classPrefix: 'o-dropdown__drop'
            });

            var options = {
                position: 'bottom left',
                style:    'default'
            }

            if (vm.options) {
                angular.merge(options, vm.options);
            }

            vm.dropdown = new _DropDropdown({
                target: vm.target,
                content: vm.content,
                classes: '',
                position: options.position,
                constrainToWindow: true,
                openOn: 'click',
                remove: true,
                constrainToScrollParent: false
            });

            vm.dropdown.on('open', function () {
                $rootScope.$broadcast('ui.dropdown.open');
                // Add min-width to match button
                // -------------------------
                angular.element('.o-dropdown__drop-content').css('min-width', vm.element.find('.o-dropdown__button').outerWidth());
                vm.dropdown.position();
            });

            vm.dropdown.on('close', function () {
                $rootScope.$broadcast('ui.dropdown.close');
            });
        }
        function close () {
            vm.dropdown.close();
        }

        function destroy () {
            vm.dropdown.destroy();
        }

        function reload () {
            vm.destroy();
            vm.create();
        }
    }

})();

