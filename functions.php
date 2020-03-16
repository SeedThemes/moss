<?php
/* KIRKI SETTINGS */
if( class_exists('Kirki') ) { include_once( dirname( __FILE__ ) . '/inc/kirki.php' );}

/* SEEDTHEMES SETTINGS */
if (!isset($GLOBALS['s_wp_comments']))  {$GLOBALS['s_wp_comments']	= 'disable';}       // disable, enable
if (!isset($GLOBALS['s_style_css']))    {$GLOBALS['s_style_css']    = 'disable';}       // disable, enable
if (!isset($GLOBALS['s_blog_profile'])) {$GLOBALS['s_blog_profile'] = 'enable';}        // disable, enable


/* WORDPRESS SETTINGS */
if ( ! function_exists( 'moss_setup' ) ) :
	function moss_setup() {
		load_theme_textdomain( 'moss', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size(400, 210, true);
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'custom-background', apply_filters( 'moss_custom_background_args', array(
			'default-color' => 'f2f3f4',
			'default-image' => '',
		) ) );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'custom-logo', array(
			'height'      => 120,
			'width'       => 120,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'moss_setup' );

/* Content Width */
function moss_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'moss_content_width', 400 );
}
add_action( 'after_setup_theme', 'moss_content_width', 0 );

/* Enqueue scripts and styles. */
function moss_scripts() {
	
	wp_enqueue_style('s-mobile', get_theme_file_uri('/css/mobile.css'), array(), '20200316');
    wp_enqueue_style('s-desktop', get_theme_file_uri('/css/tablet.css'), array(), '20200316', '(min-width: 768px)');
	
	if ($GLOBALS['s_style_css'] == 'enable') {
        wp_enqueue_style('s-style', get_stylesheet_uri());
    }

	wp_enqueue_script( 's-feather', get_template_directory_uri() . '/js/feather.min.js', array(), '4.24.1', true );
	wp_enqueue_script( 's-scripts', get_template_directory_uri() . '/js/scripts.js', array(), '20200316', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'moss_scripts' );


/* Admin CSS */
function moss_admin_style() {
    wp_enqueue_style('s-admin-style', get_template_directory_uri() . '/css/wp-admin.css');
}
add_action('admin_enqueue_scripts', 'moss_admin_style');

/* Classic Editor CSS */
function moss_add_editor_styles() {
    add_editor_style( 'css/wp-editor-style.css' );
}
add_action( 'admin_init', 'moss_add_editor_styles' );

/* Gutenberg Editor CSS */
add_action('admin_enqueue_scripts', 'moss_add_gutenberg_assets');
function moss_add_gutenberg_assets() {
    wp_enqueue_style('s-gutenberg', get_theme_file_uri('/css/wp-gutenberg.css'), false);
}

/* Add Category Name to body_class */
add_filter('body_class','moss_add_category_to_single');
function moss_add_category_to_single($classes) {
if (is_single() ) {
	global $post;
	foreach((get_the_category($post->ID)) as $category) {
		$classes[] = 'category-' . $category->category_nicename;
	}
}
return $classes;
}

/* Custom template tags */
require get_template_directory() . '/inc/template-tags.php';

/* Customizer additions */
require get_template_directory() . '/inc/customizer.php';

/* Load Jetpack */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/* TGMPA - Recommended Plugin */
require_once get_template_directory() . '/inc/TGMPA/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'moss_register_required_plugins' );
function moss_register_required_plugins() {
	$plugins = array(
		array(
			'name'      => 'Kirki Customizer Framework',
			'slug'      => 'kirki',
			'required'  => false,
		),
	);
	$config = array(
		'id'           => 'moss',                 
		'default_path' => '',                      
		'menu'         => 'tgmpa-install-plugins', 
		'parent_slug'  => 'themes.php',            
		'capability'   => 'edit_theme_options',   
		'has_notices'  => true,                    
		'dismissable'  => true,                    
		'dismiss_msg'  => '',                      
		'is_automatic' => true,                   
		'message'      => '',                      
	);
	tgmpa( $plugins, $config );
}