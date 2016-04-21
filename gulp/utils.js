module.exports = function (gulp, plugins){
    return {
        /*
            Messages
        */
        logMessage : function (message, type){
            var log = plugins.util.log,
                colors = plugins.util.colors;

            switch (type) {

                case 'success':
                    log(colors.black.bgGreen(message));
                    break;

                case 'warning':
                    log(colors.black.bgYellow(message));
                    break;

                case 'error':
                    log(colors.white.bgRed(message));
                    break;

                default:
                    log(colors.black.bgWhite(message));

            }

        },

        /*
            Errors
        */
        onError : function (error) {
            plugins.util.beep();
            plugins.util.log(plugins.util.colors.white.bgRed(' ' + error.name + ' in plugin "' + error.plugin + '" ', 'error'));
            plugins.util.log(plugins.util.colors.white.bgRed(' ' + error.message + ' ', 'error'));
            this.emit('end');
        },

        /*
            Function to convert 1-9 to 01-09
        */
        twodigits : function (n){
            return n > 9 ? "" + n: "0" + n;
        }
    };
};