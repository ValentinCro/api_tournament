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

            element.on('click', function () {
                var modalInstance = $uibModal.open({
                    animation: true,
                    templateUrl: '/bundles/app/html/saagie-ui/components/click-confirm.directive.html',
                    size: 'sm',
                    scope: scope,
                    windowClass: 'c-click-confirm-modal ' + scope.vm.extraClass
                });

                // Confirm when "enter" key is pressed
                // -------------------------
                modalInstance.opened.then(function () {
                    $document.on('keypress.uiClickConfirm', function(e) {
                        if (e.which === 13) {
                            modalInstance.close();
                            $document.off('keypress.uiClickConfirm');
                        }
                    });
                });

                modalInstance.result
                    .then(function () {
                        scope.vm.uiClickConfirm();
                    }, function () {
                        // Cancel
                    });
            });
        }
    }

    /* ------------------------- *\
        Directive controller
    \* ------------------------- */
    uiClickConfirmController.$inject = ['$scope'];

    /* @ngInject */
    function uiClickConfirmController($scope) {
        var vm = this;

        vm.options = {
            type: '',
            title: 'Are you sure?',
            message: '',
            cancel: 'Cancel',
            confirm: 'OK'
        };

        activate();

        function activate () {

            $scope.$watch('vm.uiClickConfirmOptions', function () {
                initOptions();
            });

            initOptions();
        }

        function initOptions () {
            angular.merge(vm.options, vm.uiClickConfirmOptions);

            vm.extraClass = '';

            vm.title = vm.options.title;
            vm.message = vm.options.message;

            vm.btnCancelText = vm.options.cancel;
            vm.btnCancelExtraClass = 'as--soft';
            vm.btnConfirmText = vm.options.confirm;
            vm.btnConfirmExtraClass = '';

            switch (vm.options.type) {
                case 'danger':
                    vm.extraClass = 'as--danger';
                    vm.btnConfirmExtraClass = 'as--danger';
                    break;
                case 'remove':
                    vm.extraClass = 'as--danger';
                    vm.btnConfirmExtraClass = 'as--danger as--remove';
                    break;
                case 'success':
                    vm.extraClass = 'as--success';
                    vm.btnConfirmExtraClass = 'as--success';
                    break;
            }

        }
    }

})();

