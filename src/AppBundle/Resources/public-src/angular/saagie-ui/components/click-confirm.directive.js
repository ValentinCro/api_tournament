(function () {
    'use strict';

    angular
        .module('ui.saagie')
        .directive('uiClickConfirm', uiClickConfirm);

    uiClickConfirm.$inject = ['$document', '$uibModal'];

    /* @ngInject */
    function uiClickConfirm($document, $uibModal) {
        var directive = {
            bindToController: true,
            controller:       uiClickConfirmController,
            controllerAs:     'vm',
            link:             link,
            restrict:         'A',
            scope:            {
                uiClickConfirm: '&',
                uiClickConfirmOptions: '='
            }
        };
        return directive;

        function link(scope, element, attrs) {
            scope.vm.element = element;
            scope.vm.target = element[0];

            // Create
            // -------------------------
            scope.vm.create();


        }
    }

    /* ------------------------- *\
        Directive controller
    \* ------------------------- */
    uiClickConfirmController.$inject = ['$scope', '$document'];

    /* @ngInject */
    function uiClickConfirmController($scope, $document) {
        var vm = this;
        var isTouchDevice = 'ontouchstart' in window || navigator.msMaxTouchPoints;
        var uniqkey = new Date().getTime();
        
        vm.create = create;
        vm.close = close;
        vm.destroy = destroy;
        vm.reload = reload;

        activate();

        function activate () {
            $scope.$watch('vm.uiClickConfirm', function () {
                vm.reload();
            });

            $scope.$watch('vm.uiClickConfirmOptions', function () {
                vm.reload();
            });
        }

        function create () {
            if(isTouchDevice) {
                return;
            }

            var _DropClickConfirm = Drop.createContext({
                classPrefix: 'c-click-confirm'
            });

            var options = {
                position: 'bottom left',
                type: '',
                title: 'Are you sure?',
                message: '',
                cancel: 'Cancel',
                cancelClass: 'as--soft',
                confirm: 'OK',
                confirmClass: ''
            }

            if (vm.uiClickConfirmOptions) {
                angular.merge(options, vm.uiClickConfirmOptions);
            }

            switch (options.type) {
                case 'danger':
                    options.confirmClass = 'as--danger';
                    break;
                case 'remove':
                    options.confirmClass = 'as--danger as--remove';
                    break;
                case 'success':
                    options.confirmClass = 'as--success';
                    break;
            }

            vm.clickConfirm = new _DropClickConfirm({
                target: vm.target,
                content: '<div class="c-click-confirm__title">' + options.title + '</div>' +
                         '<div class="c-click-confirm__message">' + options.message + '</div>' +
                         '<div class="c-click-confirm__buttons">' +
                         '<button type="button" class="o-button as--sm c-click-confirm__button-cancel ' + options.cancelClass + '">'+
                         options.cancel +
                         '</button>' +
                         '<button type="button" class="o-button as--sm c-click-confirm__button-confirm ' + options.confirmClass + '">'+
                         options.confirm +
                         '</button>' +
                         '</div>',
                classes: '',
                position: options.position,
                openOn: 'click',
                remove: true
            });

            vm.clickConfirm.on('open', function () {
                // Click button cancel
                // -------------------------
                $document.on('click.uiClickConfirm.cancel.' + uniqkey, '.c-click-confirm__button-cancel', function () {
                    vm.close();
                });

                // Click button confirm
                // -------------------------
                $document.on('click.uiClickConfirm.confirm.' + uniqkey, '.c-click-confirm__button-confirm', function () {
                    vm.uiClickConfirm();
                    vm.close();
                });

                // Press enter key or escape key
                // -------------------------
                $document.on('keydown.uiClickConfirm.' + uniqkey, function(e) {
                    // Enter
                    if (e.which === 13) {
                        vm.uiClickConfirm();
                    }

                    // Escape
                    if (e.which === 27) {
                        vm.close();
                    }
                });
            });

            vm.clickConfirm.on('close', function () {
                $document.off('click.uiClickConfirm.cancel.' + uniqkey);
                $document.off('click.uiClickConfirm.confirm.' + uniqkey);
                $document.off('keypress.uiClickConfirm.' + uniqkey);
            });
        }

        function close () {
            if(isTouchDevice) {
                return;
            }

            vm.clickConfirm.close();
        }

        function destroy () {
            if(isTouchDevice) {
                return;
            }

            try {
                vm.clickConfirm.off('open');
                vm.clickConfirm.off('close');
                vm.clickConfirm.destroy();
            }
            catch (e) {}
        }

        function reload () {
            vm.destroy();
            vm.create();
        }
    }

})();

