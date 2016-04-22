var sources = {};

/* ------------------------- *\
    Paths
\* ------------------------- */
sources.roots = {
  bower: 'src/AppBundle/Resources/public-src/bower_components',
  src: 'src/AppBundle/Resources/public-src',
  dist: 'src/AppBundle/Resources/public',
  views: 'src/AppBundle/Resources/views'
};

/* ------------------------- *\
    Header HTML
\* ------------------------- */
sources.views = {
  src: [
    sources.roots.views + '/**/*.html.twig'
  ],
  dest: sources.roots.views  + '/'
};

/* ------------------------- *\
    Clean
\* ------------------------- */
sources.clean = [
  sources.roots.dist + '/assets/',
  sources.roots.dist + '/css/',
  sources.roots.dist + '/js/',
  sources.roots.dist + '/html/'
];

/* ------------------------- *\
    Less
\* ------------------------- */
sources.less = {
  src: {
    app: {
      main: sources.roots.src + '/less/app/app.less',
      watch: sources.roots.src + '/less/app/**/*.less'
    },
    styleguide: {
      main: sources.roots.src + '/less/styleguide/styleguide.less',
      watch: sources.roots.src + '/less/styleguide/**/*.less'
    }
  },
  dest: sources.roots.dist + '/css'
};

/* ------------------------- *\
    JS
\* ------------------------- */
sources.js = {
  src: {
    bower: [
      sources.roots.bower + '/fastclick/lib/fastclick.js',
      sources.roots.bower + '/jquery/dist/jquery.min.js',
      sources.roots.bower + '/moment/min/moment.min.js',
      sources.roots.bower + '/angular/angular.min.js',
      sources.roots.bower + '/angular-cookies/angular-cookies.min.js',
      sources.roots.bower + '/angular-ui-router/release/angular-ui-router.min.js',
      sources.roots.bower + '/angular-ui-validate/dist/validate.js',
      sources.roots.bower + '/angular-animate/angular-animate.min.js',
      sources.roots.bower + '/angular-mocks/angular-mocks.js',
      sources.roots.bower + '/angular-growl-v2/build/angular-growl.min.js',
      sources.roots.bower + '/angular-bootstrap/ui-bootstrap-tpls.min.js',
      sources.roots.bower + '/tether/dist/js/tether.min.js',
      sources.roots.bower + '/tether-drop/dist/js/drop.min.js'
    ],
    'saagie-ui': [
      sources.roots.src + '/angular/saagie-ui/**/*.module.js',
      sources.roots.src + '/angular/saagie-ui/**/*.js'
    ],
    app: [
      sources.roots.src + '/angular/app/**/*.module.js',
      sources.roots.src + '/angular/app/**/*.js'
    ]
  },
  dest: sources.roots.dist + '/js'
};

/* ------------------------- *\
    Angular HTML
\* ------------------------- */
sources.angularHtml = {
  src: sources.roots.src + '/angular/**/*.html',
  dest: sources.roots.dist + '/html'
};

/* ------------------------- *\
    Assets
\* ------------------------- */
sources.assets = {
  src: {
    bower: {
      fontawesome: [
        sources.roots.bower + '/font-awesome/fonts/**/*'
      ]
    },
    app: sources.roots.src + '/assets/app/**/*.*',
    styleguide: sources.roots.src + '/assets/styleguide/**/*.*'
  },
  dest: sources.roots.dist + '/assets'
};

// -------------------------

module.exports = sources;