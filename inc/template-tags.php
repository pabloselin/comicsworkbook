<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package cw2019
 */

if ( ! function_exists( 'cw_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function cw_posted_on() {
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
			esc_html_x( 'Posted on %s', 'post date', 'cw' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'cw_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function cw_posted_by( $post_id = null, $prefix = 'by') {
		if($post_id != null) {
			global $post;
			$post_id = $post->ID;
		}
		if(get_post_meta($post_id, '_cw_contributor', true)) {
			$contributor = get_post_meta( $post_id, '_cw_contributor', true);
			$byline = sprintf(esc_html_x( $prefix .' %s', 'post author', 'cw' ), '<span class="author-vcard"><a href="' . get_permalink($contributor). '" class="url fn n">' . get_the_title($contributor) . '</a></span>');
		} elseif(has_term( '', 'creator', $post_id )) {
			$creators = get_the_terms( $post_id, 'creator' );
			$outputcreators = '';
			foreach($creators as $creator) {
				$outputcreators .= '<a href="' . get_term_link($creator->term_id, 'creator'). '"">' . $creator->name . '</a>';
			}
			$byline = sprintf(esc_html_x( $prefix . ' %s', 'post author', 'cw' ), '<span class="author-vcard">' . $outputcreators . '</span>');
		}
		 else {
			$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( $prefix . ' %s', 'post author', 'cw' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
			);

		}
		

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

function cw_plain_posted_by( $post_id, $prefix = 'by') {
	if(get_post_meta($post_id, '_cw_contributor', true)) {
			$contributor = get_post_meta( $post_id, '_cw_contributor', true);
			$byline = sprintf(esc_html_x( $prefix .' %s', 'post author', 'cw' ), '<span class="author-vcard">' . get_the_title($contributor) . '</span>');
		} elseif(has_term( '', 'creator', $post_id )) {
			$creators = get_the_terms( $post_id, 'creator' );
			$outputcreators = '';
			foreach($creators as $creator) {
				$outputcreators .= $creator->name;
			}
			$byline = sprintf(esc_html_x( $prefix . ' %s', 'post author', 'cw' ), '<span class="author-vcard">' . $outputcreators . '</span>');
		}
		 else {
			$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( $prefix . ' %s', 'post author', 'cw' ),
			'<span class="author vcard">' . esc_html( get_the_author() ) . '</span>'
			);

		}

		echo '<span class="byline"> ' . $byline . '</span>';
}

if ( ! function_exists( 'cw_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function cw_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'cw' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'cw' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'cw' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'cw' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'cw' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'cw' ),
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

if ( ! function_exists( 'cw_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function cw_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;
