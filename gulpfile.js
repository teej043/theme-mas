'use strict';

const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const uglify = require('gulp-uglify');
const sourcemaps = require('gulp-sourcemaps');

const rename = require('gulp-rename');

function buildStyles() {
  return gulp.src('./source/**/*.scss', {base: 'source/sass'})
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./assets/css/')) // for Wordpress
    .pipe(gulp.dest('./source/css/')); // for Patternlab
};

function buildScripts() {
  return gulp.src('./source/js/**/*.js', {base: 'source/js'})
    .pipe( uglify() )
    .pipe(rename({suffix: ".min"}))
    .pipe( gulp.dest('./assets/js/')) // for Wordpress
    
    //.pipe( browserSync.reload( {stream:true} ) )
    // .pipe(notify({ message: 'Sass task complete' }));
};

exports.buildStyles = buildStyles;
exports.buildScripts = buildScripts;

exports.watch = function () {
  gulp.watch('./source/sass/**/*.scss', buildStyles);
  gulp.watch('./source/js/**/*.js', buildScripts);
};