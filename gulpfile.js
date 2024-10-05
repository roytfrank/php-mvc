var elixir = require('laravel-elixir');
elixir.config.sourcemaps = false;

var gulp = require('gulp');

elixir(function(mix){ 

   mix.sass([
    'sass/app.scss',
    ], 'resources/Assets/css/app.css', 'resources/Assets');

   var bowerPath = 'bower/vendor';
   mix.styles([
   	    'css/app.css',
   	    bowerPath+'/bootstrap/dist/css/bootstrap.min.css',
   	], 'public/css/style.css', 'resources/Assets');
  
  mix.scripts([
  	     bowerPath+'/jquery/dist/jquery.min.js',
         bowerPath+'/axios/dist/axios.min.js',
         bowerPath+'/chart.js/dist/Chart.bundle.js',
         'js/rejoy.js',
         'js/global.js',
         'js/admin/*.js',
         'js/store/*.js',
         'js/init.js'
  	], 'public/js/script.js', 'resources/Assets');

});