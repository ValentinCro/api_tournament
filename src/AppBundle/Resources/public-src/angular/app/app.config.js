(function () {
    'use strict';


    angular
        .module('app')
        .config(configGrowl);
    
    /* ------------------------- *\
        Growl
    \* ------------------------- */

    configGrowl.$inject = ['growlProvider'];

    function configGrowl (growlProvider) {
        growlProvider.globalTimeToLive({success: 3000, error: -1, warning: 4000, info: 3000});
        growlProvider.globalDisableCountDown(true);
        growlProvider.globalPosition('top-center');
    }


})();