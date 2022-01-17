const sass = require( 'node-sass' );

module.exports = function( grunt ) {

  grunt.initConfig( {
    jshint: {
      all: [ 'library/js/*.js' ]
    },
    sass: {
      options: {
        implementation: sass,
        sourceMap: false
      },
      dist: {
        files: {
          './library/css/style.css': './library/scss/style.scss'
        }
      }
    },
    watch: {
      js: {
        files: [ 'library/js/*.js' ],
        tasks: [ 'jshint' ]
      },
      scss: {
        files: [ 'library/scss/*.scss' ],
        tasks: [ 'sass' ]
      }
    }
  } );

  require( 'matchdep' ).filterDev( 'grunt-*' ).forEach( grunt.loadNpmTasks );

  grunt.registerTask( 'default', [ 'sass' ] );

};
