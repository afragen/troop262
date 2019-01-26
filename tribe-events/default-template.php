<?php
/**
 * Default Events Template
 * This file is the basic wrapper template for all the views if 'Default Events Template'
 * is selected in Events -> Settings -> Template -> Events Template.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/default-template.php
 *
 * @package TribeEventsCalendar
 * @since  3.0
 * @author Modern Tribe Inc.
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' ); } ?>

<?php get_header(); ?>
<div id="tribe-events-pg-template">
	<?php tribe_events_before_html(); ?>

<div id="maintop"></div>
<div id="wrapper">
	<div id="content" >
		<div id="main-blog" style="width:auto;padding-right:3em;">
			<div class="clear">&nbsp;</div>

	<?php tribe_get_view(); ?>
	<?php tribe_events_after_html(); ?>


		</div><!-- #main blog -->
		<div class="clear"></div>
	</div><!-- #content -->
</div><!-- #wrapper -->

</div> <!-- #tribe-events-pg-template -->
<?php get_footer(); ?>
