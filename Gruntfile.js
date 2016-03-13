
module.exports = function(grunt) {

  var configBridge = grunt.file.readJSON('bower_components/bootstrap/grunt/configBridge.json', { encoding: 'utf8' });

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    // CSS
    less: {
      frontend: {
        options: {
          strictMath: true,
          sourceMap: true,
          outputSourceFiles: true,
          sourceMapURL: 'frontend.css.map',
          sourceMapFilename: 'out/styles/frontend/frontend.css.map'
        },
        src: 'styles/frontend/main.less',
        dest: 'out/styles/frontend/frontend.css'
      },
      backend: {
        options: {
          strictMath: true,
          sourceMap: true,
          outputSourceFiles: true,
          sourceMapURL: 'backend.css.map',
          sourceMapFilename: 'out/styles/backend/backend.css.map'
        },
        src: 'styles/backend/main.less',
        dest: 'out/styles/backend/backend.css'
      }
    },

    // Vendor prefixes for CSS
    autoprefixer: {
      options: {
        browsers: configBridge.config.autoprefixerBrowsers
      },
      frontend: {
        options: {
          map: true
        },
        src: 'out/styles/frontend/frontend.css'
      },
      backend: {
        options: {
          map: true
        },
        src: 'out/styles/backend/backend.css'
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

  grunt.registerTask('stylesFrontend', [
    'less:frontend',
    'autoprefixer:frontend'
  ]);

  grunt.registerTask('stylesBackend', [
     'less:backend',
      'autoprefixer:backend'
  ]);

  grunt.registerTask('styles', [
    'stylesFrontend',
    'stylesBackend',
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