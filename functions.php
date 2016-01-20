<?php

add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', 99 );
function enqueue_child_theme_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_uri(), array('parent-style')  );
}

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


add_action( 'register_form', 't262_username' );
add_action( 'register_form', 't262_add_warning' );
add_action( 'register_post', 't262_registration_errors', 10, 3 );
add_action( 'user_register', 't262_register_extra_fields' );

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
	update_user_meta( $user_id, 'first_name', t262_ucname( $_POST['first_name'] ) );
	update_user_meta( $user_id, 'last_name', t262_ucname( $_POST['last_name'] ) );
}

function t262_registration_errors( $sanitized_user_login, $user_email, $errors  ) {
	if( preg_match( '/[^-\.\w]/', $sanitized_user_login) )
		$errors->add( 'user_name', '<strong>ERROR</strong>: Your username contains one or more invalid characters.' );
	if( empty( $_POST['first_name'] ) )
        $errors->add( 'first_name_error', '<strong>ERROR</strong>: You must include a first name.' );
	if( empty( $_POST['last_name'] ) )
		$errors->add( 'last_name_error', '<strong>ERROR</strong>: You must include a last name.' );
	return $errors;
}

function t262_ucname( $string ) {
	$string =ucwords( strtolower( $string ) );
	foreach( array( '-', '\'' ) as $delimiter) {
		if( strpos( $string, $delimiter ) !== false )
			$string = implode( $delimiter, array_map( 'ucfirst', explode( $delimiter, $string ) ) );
	}
	return $string;
}

add_action( 'init', 't262_create_post_type' );
function t262_create_post_type() {
	register_post_type( 't262_articles',
		array(
			'labels'        => array(
			'name'          => __( 'Articles' ),
			'singular_name' => __( 'Article' ),
			),
		'public' => true,
		'menu_position' => 5,
		'rewrite' => array('slug' => 'articles'),
		'taxonomies' => array( '' ),
		'supports' => array('title', 'editor', 'comments', 'post-formats'),
		'has_archive' => true,
		)
	);
}

add_action( 'tribe_events_after_the_title', 'my_category_description' );
function my_category_description() {
	global $wp_query;
	if( !isset( $wp_query->query_vars['post_type'] ) or !isset( $wp_query->query_vars['eventDisplay'] ) or !isset( $wp_query->queried_object ) ) return;
	if( $wp_query->query_vars['post_type'] === 'tribe_events' and $wp_query->query_vars['eventDisplay'] === 'upcoming' )
		echo '<div style="text-align:center">' . $wp_query->queried_object->description . '</div>';
}
