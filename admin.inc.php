<?php
/**
 * Generates the settings page in the Admin
 *
 * @package Hiilite_admin
 */

// If this file is called directly, then abort execution.
if ( ! defined( 'WPINC' ) ) {
	die( "Aren't you supposed to come here via WP-Admin?" );
}

/**
 * Add to Footer options.
 */
function hiilite_options() {

	global $wpdb;
	$poststable = $wpdb->posts;

	$hiilite_settings = hiilite_read_options();

	if ( isset( $_POST['hiilite_save'] ) && check_admin_referer( 'hiilite-admin-options' ) ) {
		$hiilite_settings['enable_plugin'] = isset( $_POST['enable_plugin'] ) ? true : false;
		$hiilite_settings['disable_notice'] = isset( $_POST['disable_notice'] ) ? true : false;
		$hiilite_settings['hiilite_other'] = $_POST['hiilite_other'];

		update_option( 'hiilite_settings', $hiilite_settings );

		$str = '<div id="message" class="updated fade"><p>' . __( 'Options saved successfully.', 'hiilite-admin' ) . '</p></div>';
		echo $str;
	}

	if ( isset( $_POST['hiilite_default'] ) && check_admin_referer( 'hiilite-admin-options' ) ) {
		delete_option( 'hiilite_settings' );
		$hiilite_settings = hiilite_default_options();
		update_option( 'hiilite_settings', $hiilite_settings );

		$str = '<div id="message" class="updated fade"><p>' . __( 'Options set to Default.', 'hiilite-admin' ) . '</p></div>';
		echo $str;
	}
?>

<div class="wrap">
	<h2><?php _e( "Hiilite Admin", 'hiilite-admin' ) ?></h2>
	<div id="poststuff">
	<div id="post-body" class="metabox-holder columns-2">
	<div id="post-body-content">
	  <form method="post" id="hiilite_options" name="hiilite_options" onsubmit="return checkForm()">
	    <div id="genopdiv" class="postbox"><div class="handlediv" title="<?php _e( 'Click to toggle', 'hiilite-admin' ); ?>"><br /></div>
	      <h3 class='hndle'><span><?php _e( 'General options', 'hiilite-admin' ); ?></span></h3>
	      <div class="inside">
			<table class="form-table">
				<tr><th scope="row" style="background:#<?php if ( $hiilite_settings['enable_plugin'] ) echo 'cfc'; else echo 'fcc'; ?>"><label for="enable_plugin">&nbsp;<?php _e( 'Enable Footer Code:', 'hiilite-admin' ); ?></label></th>
					<td style="background:#<?php if ( $hiilite_settings['enable_plugin'] ) echo 'cfc'; else echo 'fcc'; ?>"><input type="checkbox" name="enable_plugin" id="enable_plugin" <?php if ( $hiilite_settings['enable_plugin'] ) echo 'checked="checked"' ?> /></td>
				</tr>
				
				<tr><th scope="row" colspan="2"><?php _e( 'HTML (no PHP) to add to <code>wp_footer</code>:', 'hiilite-admin' ); ?></th>
				</tr>
				<tr><td scope="row" colspan="2"><textarea name="hiilite_other" id="hiilite_other" rows="15" cols="80"><?php echo stripslashes( $hiilite_settings['hiilite_other'] ); ?></textarea></td>
				</tr>
			</table>
	      </div>
	    </div>
		<p>
		  <input type="submit" name="hiilite_save" id="hiilite_save" value="<?php _e( 'Save Options', 'hiilite-admin' ); ?>" class="button button-primary" />
		  <input type="submit" name="hiilite_default" id="hiilite_default" value="<?php _e( 'Default Options', 'hiilite-admin' ); ?>" class="button button-secondary" onclick="if ( ! confirm( '<?php _e( "Do you want to set options to Default?", 'hiilite-admin' ); ?>' ) ) return false;" />
		</p>
		<?php wp_nonce_field( 'hiilite-admin-options' ); ?>
	  </form>

	</div><!-- /post-body-content -->
	<div id="postbox-container-1" class="postbox-container">
	  <div id="side-sortables" class="meta-box-sortables ui-sortable">
		  <?php hiilite_admin_side(); ?>
	  </div><!-- /side-sortables -->
	</div><!-- /postbox-container-1 -->
	</div><!-- /post-body -->
	<br class="clear" />
	</div><!-- /poststuff -->
</div><!-- /wrap -->

<?php
}


/**
 * Function to generate the right sidebar of the Settings page.
 */
function hiilite_admin_side() {
?>
    <div id="donatediv" class="postbox"><div class="handlediv" title="<?php _e( 'Click to toggle', 'hiilite-admin' ); ?>"><br /></div>
      <h3 class='hndle'><span><?php _e( 'Tools', 'hiilite-admin' ); ?></span></h3>
      <div class="inside">
		<!-- COMING SOON -->
     	<a href="/wp-admin/themes.php?page=tgmpa-install-plugins">Install Recomended Plugins</a>
     
      </div>
    </div>
    <div id="followdiv" class="postbox"><div class="handlediv" title="<?php _e( 'Click to toggle', 'hiilite-admin' ); ?>"><br /></div>
      <h3 class='hndle'><span><?php _e( 'Hiilite Creative Group', 'hiilite-admin' ); ?></span></h3>
      <div class="inside">
		<!-- SOCIAL MEDIA -->
   
<p>Hiilite works with a mix of local, regional, provincial and international clients. We are equally happy working face-to-face and working remotely. We serve BC, Western Canada and beyond from a little corner of paradise - Kelowna, BC.<br><br>

115-1690 Water Street<br>
Kelowna, BC, V1Y 8T8, Canada<br>
<a href="tel:+18883033444">1.888.303.3444</a><br>
</p><div id="social-icons">
<a href="https://www.facebook.com/hiilite" target="_blank"><img src="https://hiilite.com/wp-content/uploads/2014/11/Facebook-32.png" width="32" height="32" alt="Facebook" scale="0"></a><a href="https://twitter.com/hiilite" target="_blank"><img src="https://hiilite.com/wp-content/uploads/2014/11/Twitter-Bird-32.png" width="32" height="32" alt="Twitter" scale="0"></a><a href="https://plus.google.com/u/0/b/107657092449987968512/107657092449987968512" target="_blank"><img src="https://hiilite.com/wp-content/uploads/2014/11/Google-Plus-32.png" width="32" height="32" alt="Google" scale="0"></a>
</div>
      </div>
    </div>

<?php
}


/**
 * Add menu item in WP-Admin.
 *
 */
function hiilite_adminmenu() {
	$plugin_page = add_options_page( __( "Hiilite Admin", 'hiilite-admin' ), __( "Hiilite Admin", 'hiilite-admin' ), 'manage_options', 'hiilite_options', 'hiilite_options');
	add_action( 'admin_head-'. $plugin_page, 'hiilite_adminhead' );
}
add_action( 'admin_menu', 'hiilite_adminmenu' );


/**
 * Function scripts to Admin head.
 *
 * @access public
 * @return void
 */
function hiilite_adminhead() {
	global $hiilite_url;

	wp_enqueue_script( 'common' );
	wp_enqueue_script( 'wp-lists' );
	wp_enqueue_script( 'postbox' );
?>

	<style type="text/css">
	.postbox .handlediv:before {
		right:12px;
		font:400 20px/1 dashicons;
		speak:none;
		display:inline-block;
		top:0;
		position:relative;
		-webkit-font-smoothing:antialiased;
		-moz-osx-font-smoothing:grayscale;
		text-decoration:none!important;
		content:'\f142';
		padding:8px 10px;
	}
	.postbox.closed .handlediv:before {
		content: '\f140';
	}
	.wrap h2:before {
	    content: "\f164";
	    display: inline-block;
	    -webkit-font-smoothing: antialiased;
	    font: normal 29px/1 'dashicons';
	    vertical-align: middle;
	    margin-right: 0.3em;
	}
	</style>

	<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) {
			// close postboxes that should be closed
			$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			// postboxes setup
			postboxes.add_postbox_toggles('addfeed_options');
		});
		//]]>
	</script>

	<script type="text/javascript" language="JavaScript">
		//<![CDATA[
		function checkForm() {
		answer = true;
		if (siw && siw.selectingSomething)
			answer = false;
		return answer;
		}//
		//]]>
	</script>

<?php
}

?>