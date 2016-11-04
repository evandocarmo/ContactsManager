module.exports = function (grunt)
{
    grunt.initConfig({
        bower_concat: {
            all: {
                dest: {
                    js: 'browser/js/_bower.js',
                    css: 'browser/css/_bower.css'
                },
                mainFiles: {
                    'decouple': 'dist/decouple.js'
                }
            }
        }
    });
    grunt.loadNpmTasks('grunt-bower-concat');
    grunt.registerTask('default', ['bower_concat']);
};