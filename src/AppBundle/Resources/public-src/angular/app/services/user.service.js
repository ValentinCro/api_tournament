(function () {
    'use strict';

    angular
        .module('app')
        .service('UserService', UserService);

    UserService.$inject = ['$rootScope', '$cookies'];

    /* @ngInject */
    function UserService($rootScope, $cookies) {
        var service = this;

        service.getCurrentUser = getCurrentUser;

        ////////////////

        function getCurrentUser() {
            var user = $rootScope.user || $cookies.getObject('user') || {};
            return user;
        }
    }

})();

