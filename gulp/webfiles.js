module.exports = function (uniqkey){

  var webfiles = {};

  /* ------------------------- *\
      Paths
  \* ------------------------- */
  webfiles.roots = {
    web: '/bundles/app'
  };

  /* ------------------------- *\
      App
  \* ------------------------- */
  webfiles.app = {
    css: [
      webfiles.roots.web + '/css/app.' + uniqkey + '.css'
    ],
    js: [
      webfiles.roots.web + '/js/bower.' + uniqkey + '.js',
      webfiles.roots.web + '/js/saagie-ui.' + uniqkey + '.js',
      webfiles.roots.web + '/js/app.' + uniqkey + '.js'
    ]
  };

  /* ------------------------- *\
      Styleguide
  \* ------------------------- */
  webfiles.styleguide = {
    css: [
      webfiles.roots.web + '/css/app.' + uniqkey + '.css',
      webfiles.roots.web + '/css/styleguide.' + uniqkey + '.css'
    ],
    js: [
      webfiles.roots.web + '/js/bower.' + uniqkey + '.js',
      webfiles.roots.web + '/js/saagie-ui.' + uniqkey + '.js'
    ]
  };

  // -------------------------

  return webfiles;
};
