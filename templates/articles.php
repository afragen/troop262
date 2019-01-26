<?php
/**
 * Template Name: Articles Template
 *
 * Description: Twenty Twelve loves the no-sidebar look as much as
 * you do. Use this page template to remove the sidebar from any page.
 *
 * Tip: to remove the sidebar from all posts and pages simply remove
 * any active widgets from the Main Sidebar area, and the sidebar will
 * disappear everywhere.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

$args = array( 'post_type' => 't262_articles' );

get_header(); ?>

<div id="maintop"></div>
<div id="wrapper">
	<div id="content" >
		<div id="main-blog">
			<div class="clear">&nbsp;</div>

			<h2>Articles</h2>
			<p>Here are some posts that I think should be easier to find and reference.</p>

			<?php

			$my_query = new WP_Query( $args );
			while ( $my_query->have_posts() ) :
				$my_query->the_post();

				echo '<div class="entry-content">';
				echo '<a href="' . $my_query->post->guid . '">' . $my_query->post->post_title . '</a>';
				echo '</div>';

				// get_template_part( 'content', 'page' );
				// global $withcomments;
				// $withcomments = true;
				// comments_template();
			endwhile; // end of the loop.

			?>


		</div><!-- #main blog -->
		<?php get_sidebar(); ?>

		<div class="clear"></div>
	</div><!-- #content -->
</div><!-- #wrapper -->

<?php wp_reset_query(); ?>
<?php get_footer(); ?>
