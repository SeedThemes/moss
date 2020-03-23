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
		add_image_size( 'catalog', 300, 300, true );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'custom-logo', array(
			'height'      => 120,
			'width'       => 120,
			'flex-width'  => true,
			'flex-height' => true,
		) );
		add_theme_support('align-wide');
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
	
	wp_enqueue_style('m-mobile', get_theme_file_uri('/css/mobile.css'), array(), '20200316');
    wp_enqueue_style('m-desktop', get_theme_file_uri('/css/tablet.css'), array(), '20200316', '(min-width: 768px)');
	
	if ($GLOBALS['s_style_css'] == 'enable') {
        wp_enqueue_style('m-style', get_stylesheet_uri());
    }

	wp_enqueue_script( 'm-feather', get_template_directory_uri() . '/js/feather.min.js', array(), '4.24.1', true );
	if (get_theme_mod( 'enable_swup', false ) ) {
		wp_enqueue_script( 'm-swup', get_template_directory_uri() . '/js/swup.min.js', array(), '2.0.9', true );
	}
	wp_enqueue_script( 'm-vanillaqr', get_template_directory_uri() . '/js/vanillaqr.min.js', array(), '20190527', true );
	wp_enqueue_script( 'm-scripts', get_template_directory_uri() . '/js/scripts.js', array(), '20200316', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'moss_scripts' );


/* Admin CSS */
function moss_admin_scripts() {
    wp_enqueue_style('m-admin-style', get_template_directory_uri() . '/css/wp-admin.css');
}
add_action('admin_enqueue_scripts', 'moss_admin_scripts');

/* Classic Editor CSS */
function moss_add_editor_styles() {
    add_editor_style( 'css/wp-editor-style.css' );
}
add_action( 'admin_init', 'moss_add_editor_styles' );

/* Gutenberg Editor CSS */
add_action('admin_enqueue_scripts', 'moss_add_gutenberg_assets');
function moss_add_gutenberg_assets() {
    wp_enqueue_style('m-gutenberg', get_theme_file_uri('/css/wp-gutenberg.css'), false);
}

/* Add Ancestor Page ID to body_class */
function moss_body_class($classes) {  
    global $post;  
    if (is_page()) {  
        if ($post->post_parent) {  
			$ancestors = get_post_ancestors($post->ID);
            $parent  = end($ancestors);  
        } else {  
            $parent = $post->ID;  
        }  
        $classes[] = 'root-id-' . $parent;  
    }
	$classes[] = get_theme_mod( 'color_mode', 'light' ) . '-mode';
    return $classes;  
}  
add_filter('body_class','moss_body_class'); 

/* Remove "Category: ", "Tag: ", "Taxonomy: " from archive title */
add_filter('get_the_archive_title', 'moss_get_the_archive_title');
function moss_get_the_archive_title($title) {
    if (is_category()) {
        $title = single_cat_title('<i data-feather="folder"></i> ', false);
    } elseif (is_tag()) {
        $title = single_tag_title('<i data-feather="tag"></i> ', false);
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    } elseif (is_author()) {
        $title = '<i data-feather="user"></i> <span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_tax()) {
        $title = single_term_title('', false);
    }
    return $title;
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
		array(
			'name'      => 'Advanced Custom Fields',
			'slug'      => 'advanced-custom-fields',
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