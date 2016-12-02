// Requis
var gulp = require('gulp');

// Include plugins
var plugins = require('gulp-load-plugins')(); // tous les plugins de package.json
var concat = require('gulp-concat');
var minify = require('gulp-minify');

// Variables de chemins
var source = './assets/src';        // dossier de travail
var sourceJS = source +'/js/optimizme';
var destination = './assets/dist';  // dossier à livrer
var bower = './bower_components';  // dossier à livrer


// Tâche "minifycss" = concatenation + minify => dossier source OPTIMIZ.ME
gulp.task('minifycss', function () {
    return gulp.src(source + '/css/*.css')
        .pipe(concat('optimizme.css'))
        .pipe(plugins.csso())
        .pipe(plugins.rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest(destination + '/css/'));
});


// Tâche "minifycss-vendor" = concatenation + minify => bibilothèques bower
gulp.task('minifycss-vendor', function () {
    return gulp.src([
        bower +'/bootstrap/dist/css/bootstrap.min.css',
        bower +'/font-awesome/css/font-awesome.min.css',
        bower +'/jquery-loading/dist/jquery.loading.min.css',
        bower +'/grid-editor/dist/grideditor.css',
        bower +'/sweetalert/dist/sweetalert.css',
        bower +'/bootstrap-select/dist/css/bootstrap-select.css'
    ])
    .pipe(concat('vendor.css'))
    .pipe(plugins.csso())
    .pipe(plugins.rename({
        suffix: '.min'
    }))
    .pipe(gulp.dest(destination + '/css/'));
});

// Tâche "minifyjs" = concatenation + minify => dossier source OPTIMIZ.ME
gulp.task('minifyjs', function () {
    return gulp.src([
        sourceJS +'/utils.js',
        sourceJS +'/easycontenteditor.js',
        sourceJS +'/passerelle.js',
        sourceJS +'/easycontenteditor-trigger.js',
        sourceJS +'/redirections.js',
        sourceJS +'/create_post_page.js',
        sourceJS +'/site_options.js'
    ])
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


// Tâche "minifyjss" = concatenation + minify => bibliothèques Bower
gulp.task('minifyjs-vendor', function () {
    return gulp.src([
        bower +'/jquery/dist/jquery.min.js',
        bower +'/jquery-ui/jquery-ui.min.js',
        bower +'/bootstrap/dist/js/bootstrap.min.js',
        //bower +'/tinymce/tinymce.min.js',
        //bower +'/tinymce/jquery.tinymce.min.js',
        //bower +'/tinymce/plugins/**/plugin.min.js',
        bower +'/jquery-loading/dist/jquery.loading.min.js',
        bower +'/grid-editor/dist/jquery.grideditor.min.js',
        bower +'/jquery-tmpl/jquery.tmpl.min.js',
        bower +'/sweetalert/dist/sweetalert.min.js',
        bower +'/bootstrap-select/dist/js/bootstrap-select.js'
    ])
    .pipe(concat('vendor.js'))
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


// Copie des fonts bootstrap + font awesome dans le dossier dist
gulp.task('fonts', function() {
    return gulp.src([
        bower +'/bootstrap/fonts/*.*',
        bower +'/font-awesome/fonts/*.*'

    ])
    .pipe(gulp.dest(destination +'/fonts/'));
});




// Tâche "all" = do all actions
gulp.task('all', ['minifycss', 'minifycss-vendor', 'minifyjs', 'minifyjs-vendor', 'fonts']);
gulp.task('optimizme_repack', ['minifycss', 'minifyjs']);



/////////////////////////
// Tâche par défaut
/////////////////////////

gulp.task('default', ['all'], function(){
    // watch pour des changements dans le dossier source (js + css)
    gulp.watch(source + '/**/*', ['optimizme_repack']);
});