const   theme = 'tunit',
        gulp = require('gulp'),
        sass = require('gulp-sass')(require('sass')),
        cssmin = require('gulp-cssmin'),
        plumber = require('gulp-plumber'),
        header = require('gulp-header'),
        replace = require('gulp-replace'),
        uglify = require('gulp-uglify');

sass.compiler = require('sass');

/* Task to compile and minify prebuilt styles */

gulp.task('styles:prebuild', function(){
    return gulp.src(`wp-content/themes/${theme}/assets/scss/*/*.scss`)
        .pipe(header('@use "core/core";'))
        .pipe(replace(/\$/g, 'core.$'))
        .pipe(replace(/@include /g, '@include core.'))
        .pipe(gulp.dest(`wp-content/themes/${theme}/assets/css/prebuild`))
});

/* Task to compile and minify core styles */
gulp.task('styles:main:build', function(){
    return gulp.src(`wp-content/themes/${theme}/assets/scss/*.scss`)
        .pipe(plumber())
        .pipe(sass({ errLogToConsole: true }))
        .on('error', catchErr)
        .pipe(gulp.dest(`wp-content/themes/${theme}/assets/css`))
        .pipe(cssmin())
        .pipe(gulp.dest(`wp-content/themes/${theme}/assets/css`))
});

/* Task to compile and minify block styles */
gulp.task('styles:blocks:build', function(){
    return gulp.src(`wp-content/themes/${theme}/assets/scss/blocks/*.scss`)
        .pipe(header('@use "../core/core";'))
        .pipe(replace(/\$/g, 'core.$'))
        .pipe(replace(/@include /g, '@include core.'))
        .pipe(plumber())
        .pipe(sass({ errLogToConsole: true }))
        .on('error', catchErr)
        .pipe(gulp.dest(`wp-content/themes/${theme}/assets/css`))
        .pipe(cssmin())
        .pipe(gulp.dest(`wp-content/themes/${theme}/assets/css`))
});

function catchErr(e) {
    console.log(e);
    this.emit('end');
}

gulp.task('js:build', function() {
    return gulp.src(`wp-content/themes/${theme}/assets/js/src/**/*.js`)
        .pipe(uglify())
        .pipe(gulp.dest(`wp-content/themes/${theme}/assets/js/dist/`));
});

/* Task to watch changes */
gulp.task('watch', function() {
    gulp.watch(`wp-content/themes/${theme}/assets/scss/**/*.scss`, gulp.series(
            'styles:prebuild',
            'styles:blocks:build',
            'styles:main:build'
        )
    );
    gulp.watch(`wp-content/themes/${theme}/assets/js/src/**/*.js`, gulp.series(
            'js:build'
        )
    );
});