'use strict';

const config = require('./config.json');

const gulp = require('gulp');
const replace = require('gulp-string-replace');
const sass = require('gulp-sass')(require('sass'));
const uglify = require('gulp-uglify');
const sourcemaps = require('gulp-sourcemaps');
const postcss = require('gulp-postcss');
const cleanCSS = require('gulp-clean-css');
const mergeCSS = require('gulp-merge-css');
const autoprefixer = require('gulp-autoprefixer');
const postcssCriticalSplit = require('postcss-critical-split');

//const argv = require('minimist')(process.argv.slice(2));
const yargs = require('yargs/yargs');
const { hideBin } = require('yargs/helpers');
const argv = yargs(hideBin(process.argv)).argv;

const rename = require('gulp-rename');

const browserSync = require('browser-sync').create();
const reload = browserSync.reload;

/******************************************************
 * PATTERN LAB  NODE WRAPPER TASKS with core library
 ******************************************************/
const pl_config = require('./patternlab-config.json');
const patternlab = require('@pattern-lab/core')(pl_config);



function build() {
  return patternlab
    .build({
      watch: argv.watch,
      cleanPublic: pl_config.cleanPublic,
    })
    .then(() => {
      // do something else when this promise resolves
    });
}

function serve() {
  return patternlab.server
    .serve({
      cleanPublic: pl_config.cleanPublic,
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
  patternlab.patternsonly(pl_config.cleanPublic);
}

function patternlabListStarterKits() {
  patternlab.liststarterkits();
}

function patternlabLoadStartKit() {
  patternlab.loadstarterkit(argv.kit, argv.clean);
}

function patternlabBuild() {

  return build().then(() => {
    browserSync.reload();
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
    .pipe(gulp.dest('./source/css/')) // for Patternlab
    .pipe(gulp.dest('./assets/css/')) // for Wordpress
};

function buildPatternlabStyles() {
  return gulp.src('./public/styleguide/sass/*.scss')
    //.pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    //.pipe(sourcemaps.write())
    .pipe(rename({suffix: ".min"}))
    .pipe(gulp.dest('./public/styleguide/css/')); // for Patternlab UI only
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



/**
 * CRITICAL CSS
 */


 function critical() {
  return gulp.src(['./assets/css/**/*.css','!**/*-critical.css','!**/critical.css'])
  //.pipe(replace(/url\(\.\./g, 'url('+ config.local.site.stylesheet_uri +''))
  .pipe(replace(/url*\(.../g, "url("+ config.local.site.stylesheet_uri + "assets"))
	.pipe(postcss([
    postcssCriticalSplit({
    })
  ]))
  .pipe(mergeCSS({ name: 'critical.css' }))
  .pipe( autoprefixer( {
    cascade: true
  }))
  .pipe(cleanCSS())
  .pipe(gulp.dest('./assets/css/critical'));
}

function criticalSplit() {
  return gulp.src(['./assets/css/**/*.css','!./assets/css/critical','!**/*-critical.css','!**/critical.css'])
	.pipe(postcss([
    postcssCriticalSplit({
      'output' : 'rest'
    })
  ]))
  .pipe(gulp.dest('./assets/css'));
}



exports.buildStyles = buildStyles;
exports.buildPatternlabStyles = buildPatternlabStyles;
exports.buildScripts = buildScripts;

exports.patternlabVer = patternlabVer;
exports.patternlabPatternsOnly= patternlabPatternsOnly;
exports.patternlabListStarterKits = patternlabListStarterKits;
exports.patternlabLoadStartKit = patternlabLoadStartKit;
exports.patternlabBuild = patternlabBuild;
exports.patternlabServe = patternlabServe;

exports.critical = critical;
exports.criticalSplit = criticalSplit;
exports.criticalCSS = gulp.series(buildStyles, critical, criticalSplit);

exports.watch = function () {

  browserSync.init({
    server: {
      baseDir: './public/'
    },
    open: true,
    ghostMode: false
  });

  gulp.watch('./source/sass/**/*.scss', buildStyles).on("change", browserSync.reload);
  gulp.watch('./source/js/**/*.js', buildScripts).on("change", browserSync.reload);
  gulp.watch('./views/**/*.twig', patternlabBuild);
};







