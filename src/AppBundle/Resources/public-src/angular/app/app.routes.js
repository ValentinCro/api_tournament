(function () {
    'use strict';

    angular
        .module('app')
        .config(configRoutes)
        .run(init);

    /* ------------------------- *\
        Init
    \* ------------------------- */
    init.$inject = ['$rootScope', '$cookies', '$state', 'AuthenticationService'];

    function init ($rootScope, $cookies, $state, AuthenticationService) {
        // keep user logged in after page refresh
        var user = $rootScope.user || $cookies.getObject('user') || {};
        if (user.username && user.token) {
            AuthenticationService.SetCredentials(user.username, user.token);
        }
        
        $rootScope.$on("$stateChangeSuccess", function() {
            // redirect to login page if not logged in and trying to access a restricted page
            var isLoginPage = $state.is('login');
            user = $rootScope.user || $cookies.getObject('user') || {};

            if (!isLoginPage && !user.token) {
                $state.go('login');
            }
        });
    }

    /* ------------------------- *\
        Routing
    \* ------------------------- */
    configRoutes.$inject = ['$stateProvider', '$urlRouterProvider'];

    function configRoutes ($stateProvider, $urlRouterProvider) {

        $urlRouterProvider.otherwise("/dashboard");

        $stateProvider
            .state('login', {
                url: "/login",
                templateUrl: "/bundles/app/html/app/login/login.html",
                controller: 'LoginController',
                controllerAs: 'vm'
            })
            .state('dashboard', {
                url: "/dashboard",
                templateUrl: "/bundles/app/html/app/dashboard/dashboard.html",
                controller: 'DashboardController',
                controllerAs: 'vm'
            })
            .state('products', {
                url: "/products",
                templateUrl: "/bundles/app/html/app/products/products.html",
                controller: 'ProductsController',
                controllerAs: 'vm'
            })
            .state('settings', {
                url: "/settings",
                templateUrl: "/bundles/app/html/app/settings/settings.html",
                controller: 'SettingsController',
                controllerAs: 'vm'
            });

    }
    

})();