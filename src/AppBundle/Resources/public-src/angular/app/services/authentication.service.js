(function () {
    'use strict';

    angular
        .module('app')
        .factory('AuthenticationService', AuthenticationService);

    AuthenticationService.$inject = ['$http', '$cookies', '$rootScope', '$timeout'];
    function AuthenticationService($http, $cookies, $rootScope, $timeout) {
        var service = {};

        service.Login = Login;
        service.SetCredentials = SetCredentials;
        service.ClearCredentials = ClearCredentials;

        return service;

        function Login(username, password, callback) {

            $http.post('/api/login_check', '_username=' + username + '&_password=' + password, {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
                .then(function (response) {
                    response.success = true;
                    service.SetCredentials(username, response.data.token);
                    callback(response);
                })
                .catch(function (response) {
                    response.success = false;
                    callback(response);
                });
        }

        function SetCredentials(username, token) {
            $rootScope.user = {
                username: username,
                token: token
            };

            $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            $cookies.putObject('user', $rootScope.user);
            $rootScope.$broadcast('userUpdated');
        }

        function ClearCredentials() {
            $rootScope.user = {};
            $cookies.remove('user');
            $http.defaults.headers.common.Authorization = 'Bearer';
            $rootScope.$broadcast('userUpdated');
        }
    }
})();