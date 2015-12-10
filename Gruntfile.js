
module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    // Copy
    copy: {
      composer: {
        expand: true,
        src: 'vendor/**',
        dest: 'plugin/'
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-copy');

  grunt.registerTask('default', [
    'copy:composer'
  ]);
};