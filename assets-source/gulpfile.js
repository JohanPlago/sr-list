var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat');

gulp.task('css', function() {
    return sass('source/scss/main.scss', { style: 'expanded' })
        .pipe(autoprefixer('last 2 version'))
        .pipe(gulp.dest('build/css'))
        .pipe(gulp.dest('../web/assets/css'))
        .pipe(rename({suffix: '.min'}))
        .pipe(minifycss())
        .pipe(gulp.dest('build/css'))
        .pipe(gulp.dest('../web/assets/css'));
});

gulp.task('js', function() {
    return gulp.src('source/js/enabled/**/*.js')
        .pipe(concat('app.js'))
        .pipe(gulp.dest('build/js'))
        .pipe(gulp.dest('../web/assets/js'))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest('build/js'))
        .pipe(gulp.dest('../web/assets/js'));
});

gulp.task('watch', function() {
    gulp.watch(['source/js/enabled/**/*.js'], ['js']);
    gulp.watch(['source/scss/**/*.scss'], ['css']);
});
