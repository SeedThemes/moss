<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Moss
 */

?>

</div><!-- #content -->
</div><!-- .site-mobile -->
<div class="site-info">
    <?php 
    if(get_site_icon_url()) {
        echo '<div class="icon"><img src="' . get_site_icon_url() . '" alt="Site Icon"></div>';
    }
    ?>
    <h2 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
    <?php 
        $s_description = get_bloginfo( 'description', 'display' );
		if ( $s_description || is_customize_preview() ) {
            echo '<p class="site-description">' . $s_description . '</p>';
        }
    ?>
    <div class="site-credit">
        <?php _e('Powered by', 'moss'); ?>
        <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'moss' ) ); ?>" target="_blank">
            <?php _e('WordPress', 'moss'); ?>
        </a>
        <?php _e('and', 'moss'); ?>
        <a href="<?php echo esc_url( __( 'https://seedthemes.com/', 'moss' ) ); ?>" target="_blank">
            <?php _e('SeedThemes', 'moss'); ?>
        </a>
    </div>
</div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>