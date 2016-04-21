(function () {
    'use strict';

    angular
        .module('app')
        .config(configRoutes)
        .run(runAfterRouteChange);

    /* ------------------------- *\
        After each route change
    \* ------------------------- */
    runAfterRouteChange.$inject = ['$rootScope', '$stateParams'];

    function runAfterRouteChange ($rootScope, $stateParams) {
        $rootScope.$on( "$stateChangeSuccess", function(event, next, current) {
            $rootScope.$broadcast('initView', $stateParams);
        });
    }

    /* ------------------------- *\
        Routing
    \* ------------------------- */
    configRoutes.$inject = ['$stateProvider', '$urlRouterProvider'];

    function configRoutes ($stateProvider, $urlRouterProvider) {

        $urlRouterProvider.otherwise("/dashboard");

        $stateProvider
            .state('dashboard', {
                url: "/dashboard",
                templateUrl: "/bundles/app/html/app/dashboard/dashboard.html",
                controller: 'DashboardController',
                controllerAs: 'vm'
            });

    }
    

})();