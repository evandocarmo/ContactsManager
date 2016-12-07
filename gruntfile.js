module.exports = function (grunt)
{
    grunt.initConfig({
        bower_concat: {
            all: {
                dest: {
                    js: 'browser/js/bower.js',
                    css: 'browser/css/bower.css'
                },
                mainFiles: {
                    'decouple': 'dist/decouple.js'
                }
            }
        },
        concat: {
            md: {
                src: 'browser/css/mode-md/*.css',
                dest: 'browser/css/mode-md.css'
            },
            sm: {
                src: 'browser/css/mode-sm/*.css',
                dest: 'browser/css/mode-sm.css'
            },
            xs: {
                src: 'browser/css/mode-xs/*.css',
                dest: 'browser/css/mode-xs.css'
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-bower-concat');
    
    grunt.registerTask('default', ['bower_concat', 'concat']);
};