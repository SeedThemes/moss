<article id="post-<?php the_ID(); ?>" <?php post_class('content-item'); ?>>
    <div class="pic">
        <a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark">
            <?php moss_post_thumbnail(); ?>
        </a>
    </div>
    <div class="info">
        <?php moss_post_cat(); ?>
        <header class="entry-header">
            <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
            <?php if ('post' === get_post_type()) : ?>
            <div class="entry-meta">
                <?php 
				moss_posted_on();
				moss_posted_by(); 
				?>
            </div>
            <?php endif; ?>
        </header>

        <div class="entry-summary">
            <?php if( has_excerpt()) {the_excerpt();}?>
        </div>
    </div>
</article>