'use strict';

const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const uglify = require('gulp-uglify');
const sourcemaps = require('gulp-sourcemaps');

const argv = require('minimist')(process.argv.slice(2));

const rename = require('gulp-rename');

/******************************************************
 * PATTERN LAB  NODE WRAPPER TASKS with core library
 ******************************************************/
const config = require('./patternlab-config.json');
const patternlab = require('@pattern-lab/core')(config);


function build() {
  return patternlab
    .build({
      watch: argv.watch,
      cleanPublic: config.cleanPublic,
    })
    .then(() => {
      // do something else when this promise resolves
    });
}

function serve() {
  return patternlab.server
    .serve({
      cleanPublic: config.cleanPublic,
      watch: true,
    })
    .then(() => {
      // do something else when this promise resolves
    });
}

function patternlabVer() {
  console.log(patternlab.version());
}

function patternlabPatternsOnly() {
  patternlab.patternsonly(config.cleanPublic);
}

function patternlabListStarterKits() {
  patternlab.liststarterkits();
}

function patternlabLoadStartKit() {
  patternlab.loadstarterkit(argv.kit, argv.clean);
}

function patternlabBuild() {
  return build().then(() => {
    // do something else when this promise resolves
  });
}

function patternlabServe() {
  serve().then(() => {
    // do something else when this promise resolves
  });
}


/** SASS AND JS */

function buildStyles() {
  return gulp.src('./source/**/*.scss', {base: 'source/sass'})
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(sourcemaps.write())
    .pipe(rename({suffix: ".min"}))
    .pipe(gulp.dest('./assets/css/')) // for Wordpress
    .pipe(gulp.dest('./source/css/')); // for Patternlab
};

function buildPatternlabStyles() {
  return gulp.src('./public/styleguide/sass/*.scss')
    //.pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    //.pipe(sourcemaps.write())
    .pipe(rename({suffix: ".min"}))
    .pipe(gulp.dest('./public/styleguide/css/')); // for Patternlab
};

function buildScripts() {
  return gulp.src(['./source/js/**/*.js','!./source/js/**/*.min.js'], {base: 'source/js'})
    .pipe( uglify() )
    .pipe(rename({suffix: ".min"}))
    .pipe( gulp.dest('./assets/js/')) // for Wordpress
    .pipe( gulp.dest('./source/js/'))
    //.pipe( browserSync.reload( {stream:true} ) )
    // .pipe(notify({ message: 'Sass task complete' }));
};



exports.buildStyles = buildStyles;
exports.buildPatternlabStyles = buildPatternlabStyles;
exports.buildScripts = buildScripts;

exports.patternlabVer = patternlabVer;
exports.patternlabPatternsOnly= patternlabPatternsOnly;
exports.patternlabListStarterKits = patternlabListStarterKits;
exports.patternlabLoadStartKit = patternlabLoadStartKit;
exports.patternlabBuild = patternlabBuild;
exports.patternlabServe = patternlabServe;

exports.watch = function () {
  gulp.watch('./source/sass/**/*.scss', buildStyles);
  gulp.watch('./source/js/**/*.js', buildScripts);
};