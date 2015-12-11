
module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

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
            cwd: 'bower_components/flags/flags/',
            src: '**',
            dest: 'plugin/libs/flags/'
          }
        ]
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-copy');

  grunt.registerTask('default', [
    'copy:composer',
    'copy:libs'
  ]);
};