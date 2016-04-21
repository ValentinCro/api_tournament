(function () {
    'use strict';

    angular
        .module('app')
        .controller('AppController', AppController);

    AppController.$inject = ['$rootScope', '$anchorScroll'];

    /* @ngInject */
    function AppController($rootScope, $anchorScroll) {
        var vm = this;

        activate();

        ////////////////

        function activate() {
            /* ------------------------- *\
                Set default yOffset for $anchorScroll
                because of topbar offset
            \* ------------------------- */
            $anchorScroll.yOffset = 60;

            init();
            $rootScope.$on('initView', init);
        }

        function init (e, params) {
            
        }
    }

})();

