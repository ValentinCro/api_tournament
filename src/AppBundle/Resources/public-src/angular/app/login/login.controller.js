(function () {
    'use strict';

    angular
        .module('app')
        .controller('LoginController', LoginController);

    LoginController.$inject = ['$location', 'AuthenticationService', 'growl'];

    /* @ngInject */
    function LoginController($location, AuthenticationService, growl) {
        var vm = this;

        vm.login = login;

        activate();

        ////////////////

        function activate() {
            AuthenticationService.ClearCredentials();
        }

        function login(form) {
            form.$setValidity('badCredentials', true);

            vm.isLoading = true;

            AuthenticationService.Login(vm.username, vm.password, function (response) {
                vm.isLoading = false;

                // Success
                if (response.success) {
                    $location.path('/');
                    return;
                }

                form.$setValidity('badCredentials', false);
            });
        };
    }

})();