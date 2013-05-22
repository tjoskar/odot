module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    bower: {
      all: {
        dest: 'public/js/build/_bower.js',
        dependencies: {
          'backbone': 'underscore',
          'underscore': 'jquery'
        }
      }
    },

    concat: {
      options: {
        separator: ';'
      },
      dist: {
        src: [
        'public/js/build/_bower.js',
        'public/js/libs/picker.js',
        'public/js/libs/picker.date.js',
        'public/js/libs/jquery.sortable.js',
        'public/js/app.js',
        'public/js/models/*.js',
        'public/js/views/*.js',
        'public/js/routes.js',
        'public/js/home.js'
        ],
        dest: 'public/js/build/built.js'
      }
    },

    uglify: {
      my_target: {
        files: {
          'public/js/build/built.min.js': ['public/js/build/built.js']
        }
      }
    },

    phpunit: {
      classes: {
        dir: 'app/tests/'
      },
      options: {
        colors: true
      }
    }

  });


  grunt.loadNpmTasks('grunt-bower-concat');   // https://npmjs.org/package/grunt-bower-concat
  grunt.loadNpmTasks('grunt-contrib-concat'); // https://npmjs.org/package/grunt-contrib-concat
  grunt.loadNpmTasks('grunt-contrib-uglify'); // https://npmjs.org/package/grunt-contrib-uglify
  grunt.loadNpmTasks('grunt-phpunit');        // https://npmjs.org/package/grunt-phpunit

  // Default task(s).
  grunt.registerTask('default', ['bower', 'concat', 'uglify', 'phpunit']);

};
