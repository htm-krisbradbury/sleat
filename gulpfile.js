var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');


gulp.task('styles', function () {
    gulp.src('scss/main.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('./style/'));
});

//Watch task
gulp.task('styles-watch', function () {
    gulp.watch('scss/**/*.scss', ['styles']);
});