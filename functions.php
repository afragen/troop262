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


add_action( 'register_form', 't262_username' );
add_action( 'register_form', 't262_add_warning' );
add_action( 'user_register', 't262_register_extra_fields', 10 );

function t262_username() {
	$html = '<label>First Name<br />
		<input type="text" name="first_name" id="first_name" class="input" value="" size="25" tabindex="20" /></label>
		<label>Last Name<br />
		<input type="text" name="last_name" id="last_name" class="input" value="" size="25" tabindex="20" /></label>';
	echo $html;
}

function t262_add_warning() {
	echo '<br /><br /><p class="message">You must fill out <strong>ALL</strong> fields or your registration will be denied.</p><br />';
}

function t262_register_extra_fields ( $user_id ) {
	global $wpdb;
	update_user_meta( $user_id, 'first_name', $_POST['first_name'] );
	update_user_meta( $user_id, 'last_name', $_POST['last_name'] );
	}
