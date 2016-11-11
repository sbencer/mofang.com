// Load the dependencies 
var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    imagemin = require('gulp-imagemin'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    livereload = require('gulp-livereload'),
    del = require('del');

// Public 
gulp.task('styles-public', function() {
  return gulp.src( ['public/assets/css/src/dashboard.scss', 'public/assets/css/src/store.scss'] )
    .pipe(sass({'sourcemap=none': true, style: 'compact' }))
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(gulp.dest('public/assets/css'))
    .pipe(rename({suffix: '.min'}))
    .pipe(minifycss())
    .pipe(gulp.dest('public/assets/css')); 
});

gulp.task('js-public', function() {
  return gulp.src('public/assets/js/src/*.js')
    .pipe(uglify())
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest('public/assets/js/'));
});


// Admin  
gulp.task('styles-admin', function() {
    return gulp.src( ['public/assets/css/src/dashboard.scss', 'public/assets/css/src/store.scss'] )
    .pipe(sass({'sourcemap=none': true, style: 'compact' }))
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(gulp.dest('public/assets/css')); 
});

gulp.task('js-admin', function() {
  return gulp.src('admin/assets/js/src/*.js')
    .pipe(uglify())
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest('admin/assets/js/'));
});


// Includes 
gulp.task('styles-include', function() {
  return gulp.src( ['includes/assets/lib/select2/src/css/select2.scss'] )
    .pipe(sass({'sourcemap=none': true, style: 'compact' }))
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(gulp.dest('includes/assets/css'))
    .pipe(rename({suffix: '.min'}))
    .pipe(minifycss())
    .pipe(gulp.dest('includes/assets/css')); 
});
 
gulp.task('js-include', function() {
  return gulp.src('includes/assets/lib/select2/src/js/*.js')
    .pipe(uglify())
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest('includes/assets/js/'));
});



gulp.task('default', ['styles-public', 'js-public', 'styles-admin', 'js-admin', 'styles-include', 'js-include']);
