<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Moss
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php moss_site_header(); ?>

    <div class="entry-content">
        <div class="featured-image <?php moss_featured_image_class(); ?>">
            <?php
				/* Find Root Page ID */
				global $post;
				if ($post->post_parent) {  
					$ancestors = get_post_ancestors($post->ID);
					$parent  = end($ancestors);
					/* Check if using Catalog Page Template */
					if( 'page-templates/subpage-grid.php' == get_page_template_slug($parent) ) {
						the_post_thumbnail('full');
					}
				} else {
					the_post_thumbnail();
				}
			?>
        </div>

        <div class="_accent"><?php moss_page_meta(); ?></div>

        <?php 
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'moss' ),
			'after'  => '</div>',
		) );
		?>
    </div><!-- .entry-content -->

    <?php if ( get_edit_post_link() ) : ?>
    <footer class="entry-footer">
        <?php
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
			?>
    </footer><!-- .entry-footer -->
    <?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->