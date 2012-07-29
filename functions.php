<?php

function dmm_nav_menu() { 
  if ( function_exists( 'wp_nav_menu' ) )
    if ( is_home() || is_front_page() ) {
      wp_nav_menu( array( 
        'menu_class' => 'nav-menu', 
        'theme_location' => 'top-menu', 
        'fallback_cb' => 'dmm_list_pages'
         ) );
    } else {
      wp_nav_menu( array( 
        'menu_class' => 'nav-menu', 
        'theme_location' => 'secondary-menu', 
        'fallback_cb' => 'dmm_list_pages' 
        ) );
    }
  else
    dmm_list_pages();
}

add_action( 'init', 'register_dmm_menu' );
function register_dmm_menu() {
  register_nav_menus(
    array(
      'top-menu' => __( 'Top Menu' ),
      'secondary-menu' => __( 'Secondary Menu' )
    )
  );
}

add_action('wp_meta', 'add_rss_feed');
function add_rss_feed() {
  $content = '<li><span class="rss"><a href="' . get_bloginfo('rss2_url') . '" title="Syndicate this site using RSS"><abbr title="Really Simple Syndication">Subscribe</abbr></a></span></li>';
  echo $content;
}

add_action('wp_footer', 'ciec_disclaimer');
function ciec_disclaimer() {
  $content = "";
  if ( is_home() ) {
    $content = '<div id="ciec_disclaimer">This website is not maintained by and does not represent the California Inland Empire Council or the Boy Scouts of America.</div>';
  }
  echo $content;
}


//add_filter( 'tribe_ical_properties', 'tribe_ical_outlook_modify', 10, 2 );
function tribe_ical_outlook_modify( $content ) {
	$properties = preg_split ( '/$\R?^/m', $content );
	$searchValue = "X-WR-CALNAME";
	$fl_array = preg_grep('/^' . "$searchValue" . '.*/', $properties);
	$key = array_values($fl_array);
	$keynum = key($fl_array);
	unset($properties[$keynum]);
	$content = implode( "\n", $properties );
	return $content;
}


?>