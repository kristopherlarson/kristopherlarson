'use strict';
module.exports = function (grunt) {
    // time
    require('time-grunt')(grunt);
    require("load-grunt-tasks")(grunt);

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        sass: {
            options: {
                // If you can't get source maps to work, run the following command in your terminal:
                // $ sass scss/foundation.scss:css/foundation.css --sourcemap
                // (see this link for details: http://thesassway.com/intermediate/using-source-maps-with-sass )
                sourceMap: true,
                includePaths: [
                    'bower_components/foundation-sites/scss',
                    'bower_components/motion-ui/src'
                ]
            },
            dist: {
                options: {
                    outputStyle: 'nested'
                    //outputStyle: 'compressed'
                },
                files: {
                    'assets/css/app.css': 'assets/scss/app.scss'
                }
            }
        },

        postcss: {
            options: {
                map: false,
                processors: [
                    require('autoprefixer')({browsers: ['last 3 versions', 'ie 9']}),
                    require('cssnano')()
                ]
            },
            dist: {
                files: {
                    'assets/css/app.css': 'assets/css/app.css'
                }
            }
        },

        combine_mq: {
            dist: {
                files: {
                    'assets/css/app.css': 'assets/css/app.css'
                }
            }
        },

        copy: {
            scripts: {
                expand: true,
                cwd: 'bower_components/foundation/js/vendor/',
                src: '**',
                flatten: 'true',
                dest: 'assets/js/vendor/'
            }

        },
        concat: {
            options: {
                separator: ';'
            },
            dist: {
                src: [

                    // LAZY SIZES
                    'bower_components/lazysizes/plugins/parent-fit/ls.parent-fit.js',
                    'bower_components/lazysizes/plugins/respimg/ls.respimg.js',
                    'bower_components/lazysizes/plugins/bgset/ls.bgset.js',
                    'bower_components/lazysizes/plugins/unload/ls.unload.js',
                    'bower_components/lazysizes/lazysizes.js',

                    // FOUNDATION CORE
                    'bower_components/foundation-sites/js/foundation.core.js',
                    'bower_components/what-input/what-input.min.js',

                    // FOUNDATION PLUGINS
                    'bower_components/foundation-sites/js/foundation.util.*.js',
                    // 'bower_components/foundation-sites/js/foundation.equalizer.js',
                    // 'bower_components/foundation-sites/js/foundation.interchange.js',

                    // VENDOR PLUGINS


                    //'assets/js/raw/vendor/*.js',
                    'assets/js/raw/custom/*.js'

                ],
                // MERGE AND CONCAT ALL FILES
                dest: 'assets/js/dist/app.js'
            }
        },

        "babel": {
            dist: {
                options: {
                    sourceMap: true
                },
                files: {
                    'assets/js/dist/app.js': 'assets/js/dist/app.js'
                }
            }
        },

        uglify: {
            dist: {
                options: {
                    sourceMap: true,
                    compress : {
                      drop_console: true
                    }
                },
                files: {
                    'assets/js/dist/app.js': 'assets/js/dist/app.js'
                }
            }
        },

        watch: {
            grunt: {
                files: ['Gruntfile.js'],
                tasks: ['concat']
            },

            sass: {
                files: 'assets/scss/**/*.scss',
                tasks: ['sass']
            },

            js: {
                files: 'assets/js/raw/**/*.js',
                tasks: ['concat']
            },

            all: {
                files: '**/*.php'
            }
        },

        browserSync: {
            dev: {
                bsFiles: {
                    src: [
                        'assets/js/raw/**/*.js',
                        'assets/scss/**/*.scss',
                        '**/*.php'
                    ]
                },
                options: {
                    watchTask: true,
                    proxy: 'base.dev'
                    //tunnel: 'base'
                }
            }
        }

    }); // End Grunt config

    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-string-replace');
    grunt.loadNpmTasks('grunt-browser-sync');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-combine-mq');
    grunt.loadNpmTasks('grunt-postcss');

    grunt.registerTask('build', ['copy', 'sass', 'concat', 'babel', 'uglify']);
    grunt.registerTask('dev', ['watch']);
    grunt.registerTask('test', ['browserSync', 'watch']);
    grunt.registerTask('dist', ['combine_mq', 'sass', 'concat', 'babel', 'uglify', 'postcss']);
};