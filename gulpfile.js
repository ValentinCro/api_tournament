// Imports
// -------------------------
var gulp = require('gulp'),
    $ = require('gulp-load-plugins')({
        pattern: '*',
        rename: {}
    }),
    params = {
        isProd : true,
        pkg : require('./package.json'),
    },
    uniqkey = params.pkg.version,
    sources = require('./gulp/sources.js'),
    webfiles = require('./gulp/webfiles.js')(uniqkey),
    utils = require('./gulp/utils.js')(gulp, $);

// Set environment param
// -------------------------
params.isProd = ($.util.env.dev === undefined);

/* ------------------------- *\
    Generate css files from less
\* ------------------------- */
var lessTasks = [],
    lessWatchTasks = [];
for (var key in sources.less.src) {
    (function(key) {

        // Regular task
        // -------------------------
        lessTasks.push('less:' + key);
        gulp.task('less:' + key, function () {
            return gulp.src(sources.less.src[key].main)
                .pipe($.if(!params.isProd, $.sourcemaps.init()))
                .pipe($.plumber({
                    errorHandler: utils.onError
                }))
                .pipe($.less())
                .pipe($.if(params.isProd, $.cssnano({
                    safe: true
                })))
                .pipe($.concat(key + '.' + uniqkey + '.css'))
                .pipe($.autoprefixer())
                .pipe($.if(!params.isProd, $.sourcemaps.write()))
                .pipe(gulp.dest(sources.less.dest));
        });

        // Watch task
        // -------------------------
        lessWatchTasks.push('watch:less:' + key);
        gulp.task('watch:less:' + key, function () {
            $.watch(sources.less.src[key].watch, function() {
                gulp.start('less:' + key);
            });
        });
    })(key);
}
gulp.task('less', lessTasks);
gulp.task('watch:less', lessWatchTasks);

/* ------------------------- *\
    Generate js files
\* ------------------------- */
var jsTasks = [],
    jsWatchTasks = [];
for (var key in sources.js.src) {
    (function(key) {

        // Regular task
        // -------------------------
        jsTasks.push('js:' + key);
        gulp.task('js:' + key, function () {
            return gulp.src(sources.js.src[key])
                .pipe($.if(!params.isProd, $.sourcemaps.init()))
                .pipe($.plumber({
                    errorHandler: utils.onError
                }))
                .pipe($.concat(key + '.' + uniqkey + '.js'))
                .pipe($.if(params.isProd, $.uglify()))
                .pipe($.if(!params.isProd, $.sourcemaps.write()))
                .pipe(gulp.dest(sources.js.dest));
        });

        // Watch task
        // -------------------------
        jsWatchTasks.push('watch:js:' + key);
        gulp.task('watch:js:' + key, function () {
            $.watch(sources.js.src[key], function() {
                gulp.start('js:' + key);
            });
        });
    })(key);
}
gulp.task('js', jsTasks);
gulp.task('watch:js', jsWatchTasks);

/* ------------------------- *\
    Copy angular html
\* ------------------------- */
gulp.task('angular-html', function () {
    return gulp.src(sources.angularHtml.src)
        .pipe(gulp.dest(sources.angularHtml.dest));
});
gulp.task('watch:angular-html', function () {
    $.watch(sources.angularHtml.src, function() {
        gulp.start('angular-html');
    });
});

/* ------------------------- *\
    Copy assets files
\* ------------------------- */
var assetsTasks = [],
    assetsWatchTasks = [];
for (var key in sources.assets.src) {
    (function(key) {

        // Bower packages
        if (key == 'bower') {
            for (var package in sources.assets.src[key]) {
                (function(package) {
                    assetsTasks.push('assets:' + key + ':' + package);
                    gulp.task('assets:' + key + ':' + package, function () {
                        return gulp.src(sources.assets.src[key][package])
                            .pipe(gulp.dest(sources.assets.dest + '/' + key + '/' + package));
                    });

                    // Watch task
                    // -------------------------
                    assetsWatchTasks.push('watch:assets:' + key + ':' + package);
                    gulp.task('watch:assets:' + key + ':' + package, function () {
                        $.watch(sources.assets.src[key][package], function() {
                            gulp.start('assets:' + key + ':' + package);
                        });
                    });
                })(package);
            }
            return;
        }

        // Other
        assetsTasks.push('assets:' + key);
        gulp.task('assets:' + key, function () {
            return gulp.src(sources.assets.src[key])
                .pipe(gulp.dest(sources.assets.dest + '/' + key));
        });

        // Watch task
        // -------------------------
        assetsWatchTasks.push('watch:assets:' + key);
        gulp.task('watch:assets:' + key, function () {
            $.watch(sources.assets.src[key], function() {
                gulp.start('assets:' + key);
            });
        });

    })(key);
}
gulp.task('assets', assetsTasks);
gulp.task('watch:assets', assetsWatchTasks);

/* ------------------------- *\
    Inject web filenames
\* ------------------------- */
gulp.task('inject-webfiles', function () {
    return gulp.src(sources.views.src)
        .pipe($.htmlReplace({
            'app-css': webfiles.app.css,
            'app-js': webfiles.app.js,
            'styleguide-css': webfiles.styleguide.css,
            'styleguide-js': webfiles.styleguide.js
        },
        {
            keepUnassigned: true,
            keepBlockTags: true,
            resolvePaths: false
        }))
        .pipe(gulp.dest(sources.views.dest));
});


/* ------------------------- *\
    Clean task
\* ------------------------- */
gulp.task('clean', function () {
    return $.del(sources.clean);
});

/* ------------------------- *\
    Build
\* ------------------------- */
gulp.task('build:ui', ['less', 'js', 'angular-html', 'assets', 'inject-webfiles']);
gulp.task('default', ['clean'], function () {
    $.runSequence('build:ui', function () {
        var message = ' Successfully generated : ' + params.pkg.name + ' [v' + params.pkg.version + '] | High Five ! ';

        if (params.isProd) {
            utils.logMessage(message, 'success');
        } else {
            utils.logMessage(message, 'warning');
        }
    });
});

/* ------------------------- *\
    Watch
\* ------------------------- */
gulp.task('watch', ['build:ui', 'watch:less', 'watch:js', 'watch:angular-html', 'watch:assets']);
