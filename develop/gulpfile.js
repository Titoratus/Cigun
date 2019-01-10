var gulp         = require('gulp'),
		sass         = require('gulp-sass'),
		browserSync  = require('browser-sync').create(),
		uglify       = require('gulp-uglify'),
		concat       = require('gulp-concat'),
		rename       = require('gulp-rename'),
		cssnano      = require('gulp-cssnano'),
		imagemin     = require('gulp-imagemin'),
		pngquant     = require('imagemin-pngquant'),
		autoprefixer = require('gulp-autoprefixer'),
		cache        = require('gulp-cache'),
		cssfont64    = require('gulp-cssfont64'),
		concatCss    = require('gulp-concat-css');

gulp.task('sass', function(){
	return gulp.src('sass/**/*.sass')
	.pipe(sass())
	.pipe(autoprefixer(['last 15 versions', '> 1%', 'ie 8', 'ie 7'], {cascade: true}))
	.pipe(cssnano())
	.pipe(rename({ suffix: '.min' }))
	.pipe(gulp.dest('../css'))
	.pipe(browserSync.stream())
});

gulp.task('browser-sync', function(){
	browserSync.init({
	    proxy: "localhost/cigun/"
	 });
});

gulp.task('scripts', function(){
	return gulp.src([
		'libs/jquery/dist/jquery.min.js',
		'libs/owl.carousel/dist/owl.carousel.min.js',
		'libs/magnific-popup/dist/jquery.magnific-popup.min.js',
		'js/scripts.js'
	])
	.pipe(concat('scripts.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('../js'));
});

gulp.task('css-libs', function(){
	return gulp.src([
		'libs/bootstrap/bootstrap-grid.min.css',
		'libs/owl.carousel/dist/assets/owl.carousel.min.css',
		'libs/owl.carousel/dist/assets/owl.theme.default.min.css',
		'libs/magnific-popup/dist/magnific-popup.css'
	])
	.pipe(concat('libs.css'))
	.pipe(cssnano({ zindex: false }))
	.pipe(autoprefixer(['last 15 versions', '> 1%', 'ie 8', 'ie 7'], {cascade: true}))
	.pipe(rename({ suffix: '.min' }))
	.pipe(gulp.dest('../css'));
});

gulp.task('watch', function(){
	gulp.watch('sass/**/*.sass', gulp.parallel('sass'));
	gulp.watch('../*.php').on("change", browserSync.reload);
	gulp.watch('js/**/*.js', gulp.parallel('scripts'));
});

gulp.task('img', function(){
	return gulp.src('../img/**/*')
	.pipe(cache(imagemin({
		interplaced: true,
		progressive: true,
		svgoPlugins: [{removeViewBox: false}],
		use: [pngquant()]
	})))
	.pipe(gulp.dest('../img'));
});

gulp.task('fontsConvert', function () {
	return gulp.src(['fonts/*.woff', 'fonts/*.woff2'])
		.pipe(cssfont64())
		.pipe(gulp.dest('../css'))
		.pipe(browserSync.stream());
});

gulp.task('default', gulp.parallel('watch', 'sass', 'img', 'css-libs', 'fontsConvert', 'browser-sync', 'scripts'));