<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cw2019
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('archive-item archive-item-post'); ?>>
	<a href="<?php echo the_permalink();?>"><?php the_post_thumbnail( 'thumbnail' );?></a>
	<header class="entry-header">
		<?php
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>
			<div class="entry-meta">
				<?php
				cw_posted_on();
				cw_posted_by($post->ID);
				?>
			</div><!-- .entry-meta -->
		
	</header><!-- .entry-header -->

	<?php //cw_post_thumbnail(); ?>

</article><!-- #post-<?php the_ID(); ?> -->
