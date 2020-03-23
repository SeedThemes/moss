<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Moss
 */

if ( ! function_exists( 'moss_post_cat' ) ) :
	/**
	 * Prints Category Link.
	 */
	function moss_post_cat() {
		if ( 'post' === get_post_type() ) {
			$category = get_the_category();
			if ( count($category) > 0 ) {
				echo '<p class="cat-link _heading"><a href="' . get_category_link( $category[0]->term_id ) . '">' . $category[0]->cat_name . '</a></p>';
			}
		}
	}
endif;

if ( ! function_exists( 'moss_post_cats' ) ) :
	/**
	 * Prints Category Links.
	 */
	function moss_post_cats() {
		if ( 'post' === get_post_type() ) {
			$categories_list = get_the_category_list( esc_html__( ', ', 'moss' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links"><i data-feather="folder"></i>' . esc_html__( '%1$s', 'moss' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}
		}
	}
endif;

if ( ! function_exists( 'moss_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function moss_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( '%s', 'post date', 'moss' ),
			'<i data-feather="calendar"></i><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'moss_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function moss_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( '%s', 'post author', 'moss' ),
			'<span class="author vcard"><i data-feather="user"></i><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'moss_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function moss_entry_footer() {
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'moss' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links"><i data-feather="tag"></i>' . esc_html__( '%1$s', 'moss' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'moss' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'moss_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function moss_post_thumbnail($size = 'post-thumbnail') {
		if (has_post_thumbnail()) {
			the_post_thumbnail( $size, array(
				'alt' => the_title_attribute( array(
				'echo' => false,
				) ),
			) );
		} else {
			echo '<img class="wp-post-image -default" src="' . esc_url(get_template_directory_uri()) .'/img/thumb.png" alt="'. get_the_title() .'" />';
		}
	}
endif;

if ( ! function_exists( 'moss_featured_image_class' ) ) :
	/**
	 * Displays Class for Featured Image
	 */
	function moss_featured_image_class() {
		if( class_exists('acf') ) { 
			if( NULL === get_field('m_featured_image') || get_field('m_featured_image')) {
				echo '_show';
			} else {
				echo '_hide';
			}
		}
	}
endif;

if ( ! function_exists( 'moss_title_class' ) ) :
	/**
	 * Displays Class for .site-top
	 */
	function moss_title_class() {
		if( class_exists('acf') ) { 
			if( NULL === get_field('m_title') || get_field('m_title')) {
				echo '_show';
			} else {
				echo '_hide';
			}
		}
	}
endif;

if ( ! function_exists( 'moss_page_meta' ) ) :
	/**
	 * Displays meta field from ACF
	 */
	function moss_page_meta() {
		if( class_exists('acf') ) { 
			if(get_field('m_meta_text')) {
				echo '<div class="page-meta">' . get_field('m_meta_text') . '</div>';
			}
		}
	}
endif;


if ( ! function_exists( 'moss_menus' ) ) :
	/**
	 * Displays menus with icons from Kirki.
	 */
	function moss_menus() {
		$defaults = [
			[
				'menu_icon' => 'home',
				'menu_label'  => esc_html__( 'Home', 'moss' ),
				'menu_page_id'  => 0,
			],
			[
				'menu_icon' => 'info',
				'menu_label'  => esc_html__( 'About', 'moss' ),
				'menu_page_id'  => 2,
			],
		];
		$settings = get_theme_mod( 'moss_menu_page', $defaults );

		echo '<nav id="site-navigation" class="main-navigation -i' . count($settings) . '">';

		foreach( $settings as $setting ) {
			$nav_class = 'm-item';
			$active_class = array();

			if ($setting['menu_page_id'] == 0) {
				$nav_path = get_home_url();
				$active_class[] = 'home';
			} else {
				$nav_path = get_permalink( $setting['menu_page_id'] );
				if ($setting['menu_page_id'] == get_option( 'page_for_posts' )) {
					$active_class = array('blog', 'single', 'category' , 'tag', 'author');
				} else {
					$active_class[] = 'root-id-' . $setting['menu_page_id'];
				}
			}
			
			/* Check if $active_class is in Body Class */
			if(count(array_intersect($active_class, get_body_class())) > 0){
				$nav_class .= ' active';
 			}

			echo '<a href="' . $nav_path . '" class="' . $nav_class .'">';
			echo '<i data-feather="'. $setting['menu_icon'] . '"></i>';
			if (true != get_theme_mod( 'menu_hide_text', false ) ) {
				echo '<span>' . $setting['menu_label'] . '</span>';
			}
			echo '</a>';
		}

		echo '</nav>';
	}
endif;

if ( ! function_exists( 'moss_site_brand' ) ) :
	/**
	 * Displays Site Title with Logo.
	 */
	function moss_site_brand() {
		$classes = '';
		if ( true == get_theme_mod( 'title_hide', false ) ) {
			$classes = '-hide-title';
		}
		if ( true == get_theme_mod( 'title_align_center', false ) ) {
			$classes .= ' -center';
		}
		echo '<header id="top" class="site-top ';
		moss_title_class();
		echo ' ' .$classes . '">';
		echo '<div class="brand">';
		the_custom_logo();
		echo '<h1 class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '"  rel="home">' . get_bloginfo( 'name' ) . '</a></h1>';
		echo '</div>';
		echo '</header>';
	}
endif;


if ( ! function_exists( 'moss_site_header' ) ) :
	/**
	 * Displays Title or Brand on Page
	 */
	function moss_site_header() {
		if (is_front_page()) {
			moss_site_brand();
		} else {
			echo '<header id="top" class="site-top entry-header ';
			moss_title_class();
			echo '">';
			the_title( '<h1 class="entry-title">', '</h1>' );
			echo '</header>';
		}
	}
endif;