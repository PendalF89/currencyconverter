
module.exports = function(grunt) {

  var configBridge = grunt.file.readJSON('bower_components/bootstrap/grunt/configBridge.json', { encoding: 'utf8' });

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    // CSS
    less: {
      frontendWidgets: {
        options: {
          strictMath: true,
          sourceMap: true,
          outputSourceFiles: true,
          sourceMapURL: 'widgets.css.map',
          sourceMapFilename: 'out/styles/widgets/widgets.css.map'
        },
        src: 'styles/widgets/main.less',
        dest: 'out/styles/widgets/main.css'
      }
    },

    // Vendor prefixes for CSS
    autoprefixer: {
      options: {
        browsers: configBridge.config.autoprefixerBrowsers
      },
      frontendWidgets: {
        options: {
          map: true
        },
        src: 'out/styles/widgets/main.css'
      }
    },

    // Copy
    copy: {
      composer: {
        expand: true,
        src: 'vendor/**',
        dest: 'plugin/'
      },
      libs: {
        files: [
          {
            expand: true,
            cwd: 'bower_components/flags/flags/flags-iso/',
            src: '**',
            dest: 'plugin/libs/flags/flags-iso/'
          }
        ]
      },
      styles: {
        files: [
          {
            expand: true,
            cwd: 'styles/',
            src: '**',
            dest: 'plugin/styles/'
          }
        ]
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-copy');

  grunt.registerTask('default', [
    'copy:composer',
    'copy:libs',
    'styles'
  ]);

  grunt.registerTask('styles', [
    'stylesFrontendWidgets',
    'copy:styles'
  ]);

  grunt.registerTask('stylesFrontendWidgets', [
    'less:frontendWidgets',
    'autoprefixer:frontendWidgets'
  ]);
};