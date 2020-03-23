<?php
/**
 * Template Name: Subpage Grid
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

		endwhile; // End of the loop.
		?>

        <?php
			$args = array(
				'post_type'      => 'page',
				'posts_per_page' => -1,
				'post_parent'    => $post->ID,
				'order'          => 'ASC',
				'orderby'        => 'menu_order'
			);

			$parent = new WP_Query( $args );

			if ( $parent->have_posts() ) : 
		?>

        <div class="subpage-catalog">

            <?php while ( $parent->have_posts() ) : $parent->the_post(); ?>
            <div id="page-<?php the_ID(); ?>" class="catalog-item">
                <div class="pic">
                    <a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark">
                        <?php moss_post_thumbnail('catalog'); ?>
                    </a>
                </div>

                <div class="info">
                    <h2 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                    <?php moss_page_meta(); ?>
                </div>
            </div>
            <?php endwhile; ?>

        </div>

        <?php endif; wp_reset_postdata(); ?>


    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();