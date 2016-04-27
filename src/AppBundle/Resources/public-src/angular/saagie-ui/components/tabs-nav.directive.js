(function () {
    'use strict';

    angular
        .module('ui.saagie')
        .directive('uiTabsNav', uiTabsNav);

    uiTabsNav.$inject = [];

    /* @ngInject */
    function uiTabsNav() {
        var directive = {
            bindToController: true,
            controller:       uiTabsNavController,
            controllerAs:     'vm',
            link:             link,
            restrict:         'A',
            scope:            {}
        };
        return directive;

        function link(scope, element, attrs) {
            var links = element.find('a'),
                current = {};

            // Init
            // -------------------------
            links.each(function () {
                var link = angular.element(this);

                if (link.hasClass('as--active')) {
                    current = scope.vm.updateCurrent(link);
                    current.panel.addClass('as--active');
                }
            });

            // On click
            // -------------------------
            links.on('click', function (e) {
                e.preventDefault();

                var clicked = {};

                clicked.link = angular.element(this);
                clicked.panel = angular.element(clicked.link.attr('href'));

                // If there is no panel
                // -------------------------
                if (clicked.panel.length < 1) {
                    return;
                }

                // If this tab is already active
                // -------------------------
                if (clicked.link.hasClass('as--active')) {
                    return;
                }
                
                // Add  as--active class on clicked tab
                // -------------------------
                clicked.link.addClass('as--active');
                clicked.panel.addClass('as--active');


                // Remove as--active class on current tab
                // -------------------------
                if (current.link && current.panel) {
                    current.link.removeClass('as--active');
                    current.panel.removeClass('as--active');
                }


                // Update current
                // -------------------------
                current = scope.vm.updateCurrent(clicked.link);
            });
        }
    }

    uiTabsNavController.$inject = [];

    /* @ngInject */
    function uiTabsNavController() {
        var vm = this;

        vm.updateCurrent = updateCurrent;

        activate();

        function activate () {

        }

        function updateCurrent (link) {
            var current = {};

            current.link = link;
            current.panel = angular.element(link.attr('href'));

            return current;
        }
    }

})();

