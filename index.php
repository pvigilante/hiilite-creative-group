<?php
/*
Plugin Name: Hiilite Admin
Plugin URI: http://hiilite.com
Description: This plugin customizes the WordPress login screen to Hiilite branding.
Version: 1.0.1
Author: Peter Singh-Vigilante
Author URI: http://hiilite.com/team/
License: GPLv2
*/

// add a new logo to the login page
function hiilite_login_logo() { ?>
    <style type="text/css">
        .login #login h1 a {
            background-image: url( <?php echo plugins_url( 'images/hiilite-logo-combomark.png' , __FILE__ ); ?> );
			background-size: contain;
			  width: auto;
			  background-repeat: no-repeat;
        }
		.login #nav a, .login #backtoblog a {
            color: #f05023 !important;
        }
        .login #nav a:hover, .login #backtoblog a:hover {
            color: #f05023 !important;
			border-bottom:1px dotted #f05023;
		}
		
		.login .button-primary {
            background: transparent; /* Old browsers */
			border:1px solid #f05023;
			color:#f05023 !important;
			border-radius:0;
			box-shadow:none;
			
        }
        .login .button-primary:hover, .login .button-primary:active, .login .button-primary:focus {
            background: #f05023; /* Old browsers */
			color:white !important;
			border:1px solid #f05023;
			box-shadow:none;
        }
    </style>
    <script>
	/*window.onload = function(){
		var hilogo = document.querySelector('#login');
		var hilink = document.querySelector('#login h1 a');
		var node = document.createElement("a");  
		var textnode = document.createTextNode("Water"); 
		node.appendChild(textnode);
		document.querySelector('#login h1 a').setAttribute('href', 'http://hiilite.com');
		hilogo.insertBefore(node, hilogo.firstChild);
	};*/
	};*/
		
	</script>
<?php }
add_action( 'login_enqueue_scripts', 'hiilite_login_logo' );

// add new dashboard widgets
function hiilite_add_dashboard_widgets() {
    wp_add_dashboard_widget( 'hiilite_dashboard_welcome', 'Welcome', 'hiilite_add_welcome_widget' );
}
function hiilite_add_welcome_widget(){ ?>
 
	<h3>This Site is Managed by Hiilite Creative Group</h3>
<p>Hiilite works with a mix of local, regional, provincial and international clients. We are equally happy working face-to-face and working remotely. We serve BC, Western Canada and beyond from a little corner of paradise - Kelowna, BC.<br><br>

115-1690 Water Street<br>
Kelowna, BC, V1Y 8T8, Canada<br>
<a href="tel:+18883033444">1.888.303.3444</a><br>
</p><div id="social-icons">
<a href="https://www.facebook.com/hiilite" target="_blank"><img src="http://www.hiilite.com/wordpress/wp-content/uploads/2014/11/Facebook-32.png" width="32" height="32" alt="Facebook" scale="0"></a><a href="https://twitter.com/hiilite" target="_blank"><img src="http://www.hiilite.com/wordpress/wp-content/uploads/2014/11/Twitter-Bird-32.png" width="32" height="32" alt="Twitter" scale="0"></a><a href="https://plus.google.com/u/0/b/107657092449987968512/107657092449987968512" target="_blank"><img src="http://www.hiilite.com/wordpress/wp-content/uploads/2014/11/Google-Plus-32.png" width="32" height="32" alt="Google" scale="0"></a>
</div>
 
 
<?php }
add_action( 'wp_dashboard_setup', 'hiilite_add_dashboard_widgets' );

// remove unwanted dashboard widgets for relevant users
function hiilite_remove_dashboard_widgets() {
    $user = wp_get_current_user();
   // if ( ! $user->has_cap( 'manage_options' ) ) {
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
   // }
}
add_action( 'wp_dashboard_setup', 'hiilite_remove_dashboard_widgets' );

// Move the 'Right Now' dashboard widget to the right hand side
function hiilite_move_dashboard_widget() {
    $user = wp_get_current_user();
    //if ( ! $user->has_cap( 'manage_options' ) ) {
        global $wp_meta_boxes;
        $widget = $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'];
        unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
        $wp_meta_boxes['dashboard']['side']['core']['dashboard_right_now'] = $widget;
	
		$widget2 = $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'];
        unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'] );
        $wp_meta_boxes['dashboard']['side']['core']['dashboard_activity'] = $widget2;
    //}
}
add_action( 'wp_dashboard_setup', 'hiilite_move_dashboard_widget' );

// let's start by enqueuing our styles correctly
function hiilite_admin_styles() {
    wp_register_style( 'hiilite_admin_stylesheet', plugins_url( '/css/style.css', __FILE__ ) );
    wp_enqueue_style( 'hiilite_admin_stylesheet' );
}
add_action( 'admin_enqueue_scripts', 'hiilite_admin_styles' );

//change the footer text
function hiilite_admin_footer_text () {
    echo '<a href="http://www.hiilite.com/marketing-strategy/"><img src="' . plugins_url( 'images/hiilite-logo-lettermark.png' , __FILE__ ) . '"> Marketing</a>, <a href="http://www.hiilite.com/seo-social-media/">SEO</a>, <a href="http://www.hiilite.com/website-design/">Web Design </a> by <a href="http://www.hiilite.com/">Hiilite Marketing + Web Design in Kelowna</a>';
}
add_filter( 'admin_footer_text', 'hiilite_admin_footer_text' );


add_action( 'admin_bar_menu', 'modify_admin_bar', 999 );

function modify_admin_bar( $wp_admin_bar ){
  // do something with $wp_admin_bar;
	$wp_admin_bar->remove_node( 'wporg' );
	$wp_admin_bar->remove_node( 'about' );
	$wp_admin_bar->remove_node( 'documentation' );
	$wp_admin_bar->remove_node( 'support-forums' );
	$wp_admin_bar->remove_node( 'feedback' );
	
	$wplogo = $wp_admin_bar->get_node( 'wp-logo' );
	$args = array(
		'id'    => 'hiilite_com',
		'title' => 'Hiilite.com',
		'href'  => 'http://hiilite.com',
		'meta'  => array( 'class' => 'hiilite_com' ),
		'parent' => $wplogo->id
	);
	$wp_admin_bar->add_node( $args );
	
	$args = array(
		'id'    => 'hiilite_marketing',
		'title' => 'Marketing',
		'href'  => 'http://www.hiilite.com/marketing-strategy/',
		'meta'  => array( 'class' => 'hiilite_marketing' ),
		'parent' => $wplogo->id
	);
	$wp_admin_bar->add_node( $args );
	
	$args = array(
		'id'    => 'hiilite_webdesign',
		'title' => 'Web Design',
		'href'  => 'http://www.hiilite.com/website-design/',
		'meta'  => array( 'class' => 'hiilite_webdesign' ),
		'parent' => $wplogo->id
	);
	$wp_admin_bar->add_node( $args );
	
	$args = array(
		'id'    => 'hiilite_seo',
		'title' => 'SEO',
		'href'  => 'http://www.hiilite.com/seo-social-media/',
		'meta'  => array( 'class' => 'hiilite_seo' ),
		'parent' => $wplogo->id
	);
	$wp_admin_bar->add_node( $args );
}
?>