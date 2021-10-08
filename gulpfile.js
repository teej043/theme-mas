'use strict';

const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');

function buildStyles() {
  return gulp.src('./source/**/*.scss', {base: 'source/sass'})
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./assets/css/') );
};

exports.buildStyles = buildStyles;

exports.watch = function () {
  gulp.watch('./sass/**/*.scss', ['sass']);
};