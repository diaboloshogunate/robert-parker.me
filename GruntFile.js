module.exports = function (grunt) {
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-connect');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-open');
    
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        connect: {
            server: {
                options: {
                    port: 8181
                }
            }
        },
        imagemin: {
            options: {
                optimizationLevel: 7,
                progressive: true,
                interlaced: true
            },
            dynamic: {
                files: [{
                    expand: true,
                    cwd: 'web/img/original',
                    src: ['**/*.{png,jpg,gif}'],
                    dest: 'web/img/compressed/'
                }]
            }  
        },
        uglify: {
            options: {
                compress: true,
            },
            my_target: {
                files: {
                    'web/js/app.min.js': [
                        'web/bower_components/foundation/js/vendor/modernizr.js',
                        'web/bower_components/foundation/js/vendor/jquery.js',
                        'web/bower_components/foundation/js/foundation.min.js',
                        'web/js/app.js'
                    ]
                }
            }
        },
        compass: {
            dist: {
                options: {
                    basePath: 'web',
                    config: 'web/config.rb',
                    sassDir: 'scss',
                    cssDir: 'stylesheets',
                    outputStyle: 'compressed',
                }
            }
        },
        watch: {
            uglify: {
                files: 'web/js/app.js',
                tasks: 'uglify',
                options: {
                    livereload: true,
                }
            },
            imagemin: {
                files: 'web/img/original/**',
                tasks: 'imagemin',
                options: {
                    livereload: true,
                }
            },
            compass: {
                files: 'web/scss/**.scss',
                tasks: 'compass',
                options: {
                    livereload: true,
                }
            },
            app: {
                files: 'app/**.twig',
                options: {
                    livereload: true,
                }
            }
        },
        open: {
            dev: {
                path: 'http://localhost:80/robert-parker.me/web/'
            }
        }
    });

    grunt.registerTask('default', ['imagemin', 'uglify','compass', 'connect', 'open', 'watch']);
};
