// Requis
var gulp = require('gulp');

// Include plugins
var plugins = require('gulp-load-plugins')(); // tous les plugins de package.json
var concat = require('gulp-concat');
var minify = require('gulp-minify');

// Variables de chemins
var source = './assets/src';        // dossier de travail
var destination = './assets/dist';  // dossier à livrer


// Tâche "minifycss" = concatenation + minify => dossier source
gulp.task('minifycss', function () {
    return gulp.src(source + '/css/*.css')
        .pipe(concat('optimizme.css'))
        .pipe(plugins.csso())
        .pipe(plugins.rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest(destination + '/css/'));
});

// Tâche "minifyjss" = concatenation + minify => dossier source
gulp.task('minifyjs', function () {
    return gulp.src([source+'/js/optimizme/utils.js', source+'/js/optimizme/passerelle.js', source+'/js/optimizme/editor.js', source+'/js/optimizme/editor-trigger.js'])
        .pipe(concat('optimizme.js'))
        .pipe(minify({
            ext:{
                src:'-debug.js',
                min:'.js'
            },
            exclude: ['tasks']
        }))
        .pipe(plugins.rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest(destination + '/js/'));
});


// Tâche "prod" = minifycss + minifyjs
gulp.task('prod', ['minifycss', 'minifyjs']);


// Tâche par défaut
gulp.task('default', ['prod'], function(){
    // watch pour des changements dans le dossier source (js + css)
    gulp.watch(source + '/**/*', ['prod']);
});