
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
      },
      backendWidgets: {
        options: {
          strictMath: true,
          sourceMap: true,
          outputSourceFiles: true,
          sourceMapURL: 'widgets.css.map',
          sourceMapFilename: 'out/styles/widgets-backend/widgets.css.map'
        },
        src: 'styles/widgets-backend/main.less',
        dest: 'out/styles/widgets-backend/main.css'
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
      },
      backendWidgets: {
        options: {
          map: true
        },
        src: 'out/styles/widgets-backend/main.css'
      }
    },

    uglify: {
      widgets: {
        options: {
          sourceMap: true,
          preserveComments: 'some'
        },
        files: {
          'scripts/widgets/CurrencyMinimalistic/settings.min.js': [
              'scripts/widgets/CurrencyMinimalistic/settings.js'
          ]
        }
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
            cwd: 'out/styles/',
            src: '**',
            dest: 'plugin/styles/'
          }
        ]
      },
      scripts: {
        files: [
          {
            expand: true,
            cwd: 'scripts/',
            src: '**',
            dest: 'plugin/scripts/'
          }
        ]
      }
    },
    
    compress: {
      plugin: {
        options: {
          archive: 'out/currencyconverter.zip'
        },
        files: [
          {
            expand: true,
            cwd: 'plugin/',
            src: ['**'],
            dest: 'currencyconverter/',
            dot: false
          }
        ]
      }
    }
  });

  //grunt.loadNpmTasks('grunt-contrib-copy');
  require('load-grunt-tasks')(grunt, { scope: 'devDependencies' });

  grunt.registerTask('stylesFrontendWidgets', [
    'less:frontendWidgets',
    'autoprefixer:frontendWidgets'
  ]);

  grunt.registerTask('stylesBackendWidgets', [
     'less:backendWidgets',
      'autoprefixer:backendWidgets'
  ]);

  grunt.registerTask('styles', [
    'stylesFrontendWidgets',
    'stylesBackendWidgets',
    'copy:styles'
  ]);

  grunt.registerTask('scripts', [
      'uglify',
      'copy:scripts'
  ]);

  grunt.registerTask('default', [
    'copy:composer',
    'copy:libs',
    'styles',
    'scripts'
  ]);
};