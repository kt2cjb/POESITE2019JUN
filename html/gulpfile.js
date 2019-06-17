'use strict'

const browserSync = require('browser-sync').create()
const gulp = require('gulp')
const autoPrefixer = require('gulp-autoprefixer')
const changed = require('gulp-changed')
const cleanCss = require('gulp-clean-css')
const concat = require('gulp-concat')
const cssComb = require('gulp-csscomb')
const csslint = require('gulp-csslint')
const notify = require('gulp-notify')
const plumber = require('gulp-plumber')
const pug = require('gulp-pug')
const rename = require('gulp-rename')
const sass = require('gulp-sass')
const image = require('gulp-image')
const del = require('del')
const webpack = require('webpack')
const webpackStream = require('webpack-stream')
const webpackConfig = require('./webpack.config')

const SRC_PATH = 'src/'
const DIST_PATH = 'dist/'

gulp.task('sass', () => {
  gulp.src([SRC_PATH + 'css/main.sass'])
    .pipe(plumber({
      handleError: err => {
        console.log(err)
        this.emit('end')
      }
    }))
    .pipe(sass())
    .pipe(autoPrefixer())
    .pipe(cssComb())
    .pipe(csslint({
      'order-alphabetical': false,
      'important': false,
      'ids': false,
      'box-sizing': false,
      'compatible-vendor-prefixes': false
    }))
    .pipe(csslint.formatter())
    .pipe(concat('main.css'))
    .pipe(gulp.dest(DIST_PATH + 'css'))
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(cleanCss())
    .pipe(gulp.dest('dist/css'))
    .pipe(browserSync.stream())
    .pipe(notify('css task finished'))
})

gulp.task('pug', () => {
  gulp.src([SRC_PATH + '**/[^_]*.pug'])
    .pipe(plumber({
      handleError: err => {
        console.log(err)
        this.emit('end')
      }
    }))
    .pipe(pug({ pretty: true }))
    .pipe(gulp.dest(DIST_PATH))
    .pipe(browserSync.stream())
    .pipe(notify('html task finished'))
})

gulp.task('js', () => {
  return webpackStream(webpackConfig, webpack)
    .pipe(plumber({
      handleError: err => {
        console.log(err)
        this.emit('end')
      }
    }))
    .pipe(gulp.dest(DIST_PATH + 'js'))
    .pipe(browserSync.stream())
    .pipe(notify('js task finished'))
})

gulp.task('image', () => {
  gulp.src([SRC_PATH + 'images/**/*'])
    .pipe(changed(DIST_PATH + 'images'))
    .pipe(image({
      pngquant: true,
      optipng: false,
      zopflipng: false,
      jpegRecompress: false,
      mozjpeg: true,
      guetzli: false,
      gifsicle: true,
      svgo: true,
      concurrent: 10,
      quiet: true
    }))
    .pipe(gulp.dest(DIST_PATH + 'images'))
    .pipe(browserSync.stream())
    .pipe(notify({
      onLast: true,
      message: 'image optimize task finished'
    }))
})

gulp.task('clean', () => {
  del.sync(['dist/'])
})

gulp.task('build', ['clean'], () => {
  gulp.start(['sass', 'pug', 'image', 'js'])
})

gulp.task('default', ['build'], () => {
  browserSync.init({
    server: 'dist'
  })
  gulp.watch(SRC_PATH + 'css/**/*.sass', ['sass'])
  gulp.watch(SRC_PATH + 'js/**/*.js', ['js'])
  gulp.watch(SRC_PATH + '**/*.pug', ['pug'])
  gulp.watch(SRC_PATH + 'images/**/*', ['image'])
})
