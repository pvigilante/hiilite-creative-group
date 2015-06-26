<?php
/*
Plugin Name: Hiilite Admin
Plugin URI: http://hiilite.com
Description: This plugin customizes the WordPress login screen to Hiilite branding.
Version: 1.0.2
Author: Hiilite Creative Group
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
	?>
	<!-- Start of hiilite Zendesk Widget script -->
<script>/*<![CDATA[*/window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement("iframe");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src="javascript:false",r.title="",r.role="presentation",(r.frameElement||r).style.cssText="display: none",d=document.getElementsByTagName("script"),d=d[d.length-1],d.parentNode.insertBefore(r,d),i=r.contentWindow,s=i.document;try{o=s}catch(c){n=document.domain,r.src='javascript:var d=document.open();d.domain="'+n+'";void(0);',o=s}o.open()._l=function(){var o=this.createElement("script");n&&(this.domain=n),o.id="js-iframe-async",o.src=e,this.t=+new Date,this.zendeskHost=t,this.zEQueue=a,this.body.appendChild(o)},o.write('<body onload="document._l();">'),o.close()}("//assets.zendesk.com/embeddable_framework/main.js","hiilite.zendesk.com");/*]]>*/</script>
<!-- End of hiilite Zendesk Widget script -->
	<?php
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

require_once dirname( __FILE__ ) . '/Plugin-Activation/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );


/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function my_theme_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // This is an example of how to include a plugin pre-packaged with a theme.
        array(
            'name'               => 'Backup Buddy', // The plugin name.
            'slug'               => 'backupbuddy-5.1.0.9', // The plugin slug (typically the folder name).
            'source'             => plugin_dir_path( __FILE__ ) . '/Plugin-Activation/plugins/backupbuddy-5.1.0.9.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),
		array(
            'name'               => 'WPBakery Visual Composer', // The plugin name.
            'slug'               => 'js_composer', // The plugin slug (typically the folder name).
            'source'             => plugin_dir_path( __FILE__ ) . '/Plugin-Activation/plugins/js_composer.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),

        // This is an example of how to include a plugin from a private repo in your theme.
        /*
		array(
            'name'               => 'TGM New Media Plugin', // The plugin name.
            'slug'               => 'tgm-new-media-plugin', // The plugin slug (typically the folder name).
            'source'             => 'https://s3.amazonaws.com/tgm/tgm-new-media-plugin.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'external_url'       => 'https://github.com/thomasgriffin/New-Media-Image-Uploader', // If set, overrides default API URL and points to an external URL.
        ),*/

        // This is an example of how to include a plugin from the WordPress Plugin Repository.
        array(
            'name'      => 'InfiniteWP Client',
            'slug'      => 'iwp-client',
            'required'  => false,
        ),
		array(
            'name'      => 'WordPress SEO by Yoast',
            'slug'      => 'wordpress-seo',
            'required'  => false,
        ),
		array(
            'name'      => 'Math Captcha',
            'slug'      => 'wp-math-captcha',
            'required'  => false,
        ),
		array(
            'name'      => 'Sucuri Security - Auditing, Malware Scanner and Security Hardening',
            'slug'      => 'sucuri-scanner',
            'required'  => false,
        ),

    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
            'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
            'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}
?>