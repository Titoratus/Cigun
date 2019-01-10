<?php
/**
 * cigun functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package cigun
 */

if ( ! function_exists( 'cigun_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function cigun_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on cigun, use a find and replace
		 * to change 'cigun' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'cigun', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'cigun' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'cigun_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'cigun_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cigun_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'cigun_content_width', 640 );
}
add_action( 'after_setup_theme', 'cigun_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function cigun_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'cigun' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'cigun' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'cigun_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function cigun_scripts() {
	wp_enqueue_style( 'cigun-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cigun_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

remove_action( 'wp_head', 'wp_resource_hints', 1);
remove_action( 'wp_head', 'feed_links',2);
remove_action( 'wp_head', 'feed_links_extra',3);
remove_action( 'wp_head', 'rsd_link');
remove_action( 'wp_head', 'wlwmanifest_link');
remove_action( 'wp_head', 'wp_shortlink_wp_head');
remove_action( 'wp_head', 'wp_generator');
remove_action( 'wp_head', 'print_emoji_detection_script', 7);
remove_action( 'wp_print_styles', 'print_emoji_styles');
remove_action( 'wp_head', 'rest_output_link_wp_head');
remove_action( 'wp_head', 'rel_canonical' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

add_filter( 'wp_default_scripts', 'change_default_jquery' );

function change_default_jquery( &$scripts){
	if ( !is_admin() ) $scripts->remove( 'jquery');
}

function remove_all_theme_styles() {
  global $wp_styles;
  $wp_styles->queue = array();
}
add_action('wp_print_styles', 'remove_all_theme_styles', 100);

add_action( 'widgets_init', 'sheensay_remove_recent_comments_style' );
 
function sheensay_remove_recent_comments_style() {
  global $wp_widget_factory;
  remove_action( 'wp_head', array( $wp_widget_factory -> widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}

// Custom Post Type
function create_post_type() {
  register_post_type( 'feedback',
    array(
      'labels' => array(
        'name' => __( 'Отзывы' ),
        'singular_name' => __( 'Отзывы' ),
        'add_new' => 'Добавить новый'
      ),
      'public' => true,
      'has_archive' => true,
      'menu_icon' => 'dashicons-format-status',
      'supports' => array('title', 'custom-fields')
    )
  );
}
add_action( 'init', 'create_post_type' );

// Custom columns for custom post
add_filter( 'manage_feedback_posts_columns', 'set_custom_edit_feedback_columns' );
function set_custom_edit_feedback_columns($columns) {
    $columns['fb_text'] = __( 'Отзыв', 'fb_text' );
    $columns['fb_author'] = __( 'Автор', 'fb_author' );
    return $columns;
}

// Custom columns
add_action( 'manage_feedback_posts_custom_column' , 'custom_feedback_column', 10, 2 );
function custom_feedback_column( $column, $post_id ) {
    switch ( $column ) {
        case 'fb_text' :
						echo get_post_meta( $post_id , 'fb_text' , true ); 
            break;
        case 'fb_author' :
						echo get_post_meta( $post_id , 'fb_author' , true ); 
            break;                    
    }
}

// Занятия
function post_type_classes() {
  register_post_type( 'classes',
    array(
      'labels' => array(
        'name' => __( 'Занятия' ),
        'singular_name' => __( 'Занятия' ),
        'add_new' => 'Добавить'
      ),
      'public' => true,
      'has_archive' => true,
      'menu_icon' => 'dashicons-groups',
      'supports' => array('title', 'custom-fields')
    )
  );
}
add_action( 'init', 'post_type_classes' );

// Custom columns for custom post
add_filter( 'manage_classes_posts_columns', 'set_custom_edit_classes_columns' );
function set_custom_edit_classes_columns($columns) {
    $columns['class_type'] = __( 'Вид занятия', 'class_type' );
    $columns['class_when'] = __( 'Когда', 'class_when' );
    $columns['class_where'] = __( 'Где', 'class_where' );
    return $columns;
}

// Custom columns
add_action( 'manage_classes_posts_custom_column' , 'custom_classes_column', 10, 2 );
function custom_classes_column( $column, $post_id ) {
    switch ( $column ) {
        case 'class_type' :
						echo get_post_meta( $post_id , 'class_type' , true ); 
            break;
        case 'class_when' :
						echo get_post_meta( $post_id , 'class_when' , true ); 
            break;             
        case 'class_where' :
						echo get_post_meta( $post_id , 'class_where' , true ); 
            break;        
    }
}

// Записи
function post_type_records() {
  register_post_type( 'records',
    array(
			/*'capability_type' => 'post',
			'capabilities' => array(
				'create_posts' => false
			),*/  	
      'labels' => array(
        'name' => __( 'Записи на занятия' ),
        'singular_name' => __( 'Записи' ),
      ),
      'public' => true,
      'has_archive' => true,
      'menu_icon' => 'dashicons-editor-ul',
      'supports' => array('title', 'custom-fields')
    )
  );
}
add_action( 'init', 'post_type_records' );

// Custom columns for custom post
add_filter( 'manage_records_posts_columns', 'set_custom_edit_records_columns' );
function set_custom_edit_records_columns($columns) {
    $columns['c_name'] = __( 'Имя', 'c_name' );
    $columns['c_phone'] = __( 'Телефон', 'c_phone' );
    $columns['c_email'] = __( 'Email', 'c_email' );
    return $columns;
}

// Custom columns
add_action( 'manage_records_posts_custom_column' , 'custom_records_column', 10, 2 );
function custom_records_column( $column, $post_id ) {
    switch ( $column ) {
        case 'c_name' :
						echo get_post_meta( $post_id , 'c_name' , true ); 
            break;
        case 'c_phone' :
						echo get_post_meta( $post_id , 'c_phone' , true ); 
            break;             
        case 'c_email' :
						echo get_post_meta( $post_id , 'c_email' , true ); 
            break;        
    }
}

// Произвольные поля
function my_more_options() {
	add_settings_field('phone', 'Телефон', 'display_phone', 'general');
	register_setting('general', 'phone');
	add_settings_field('vk', 'ВКонтакте', 'display_vk', 'general');
	register_setting('general', 'vk');
	add_settings_field('whatsapp', 'WhatsApp', 'display_whatsapp', 'general');
	register_setting('general', 'whatsapp');	
	add_settings_field('facebook', 'Facebook', 'display_facebook', 'general');
	register_setting('general', 'facebook');	
	add_settings_field('viber', 'Viber', 'display_viber', 'general');
	register_setting('general', 'viber');	
}
add_action('admin_init', 'my_more_options');

function display_phone() {
	echo "<input type='text' name='phone' autocomplete='off' value='".esc_attr(get_option('phone'))."'>";
}

function display_vk() {
	echo "<input type='text' name='vk' autocomplete='off' value='".esc_attr(get_option('vk'))."'>";
}

function display_facebook() {
	echo "<input type='text' name='facebook' autocomplete='off' value='".esc_attr(get_option('facebook'))."'>";
}

function display_viber() {
	echo "<input type='text' name='viber' autocomplete='off' value='".esc_attr(get_option('viber'))."'>";
}

function display_whatsapp() {
	echo "<input type='text' name='whatsapp' autocomplete='off' value='".esc_attr(get_option('whatsapp'))."'>";
}


add_action('wp_head', 'myplugin_ajaxurl');

function myplugin_ajaxurl() {

   echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}

add_action('wp_footer', 'my_action_javascript', 99); // для фронта
function my_action_javascript() {
	?>
	<script type="text/javascript" >

		$(document).on( 'submit', '#class_sign_up', function(e) {
			e.preventDefault();
	    $.ajax({
	        url : ajaxurl,
	        type : 'post',
	        data : {
	            action : 'record',
	            sem_name: $(this).children("h3").text().replace('Запись на', ''),
	            where: $(this).children(".class_where").text().replace('Где:', ''),
	            when: $(this).children(".class_when").text().replace('Когда:', ''),
	            c_name: $(this).find("input[name='c_name']").val(),
	            c_phone: $(this).find("input[name='c_phone']").val(),
	            c_email: $(this).find("input[name='c_email']").val()
	        },
	        success : function( response ) {
	            alert(response);
	        }
	    });
	});
	</script>
	<?php
}

add_action('wp_ajax_record', 'record_callback');
add_action('wp_ajax_nopriv_record', 'record_callback');
function record_callback() {

	// Добавление post-запись на занятие
	$post_id = wp_insert_post(array (
		'post_type' => 'records',
		'post_title' => $_POST["sem_name"]." ".$_POST["when"],
		'post_status' => 'publish',
		'comment_status' => 'closed'
	));

	update_field("field_5c29daca3e48e", $_POST["c_name"], $post_id);
	update_field("field_5c29dadd3e48f", $_POST["c_phone"], $post_id);
	update_field("field_5c29dae63e490", $_POST["c_email"], $post_id);

	// выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
	wp_die();
}