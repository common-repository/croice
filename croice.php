<?
/*
Plugin Name: Croice
Plugin URI: http://croice.com
Description: Croice plugin
Version: 0.2
Author: P.Nixx
Author URI: http://pnixx.ru
*/

define('CROICE_CONTENT_URL', get_option('siteurl') . '/wp-content');
define('CROICE_PLUGIN_URL', CROICE_CONTENT_URL . '/plugins/croice');
define('CROICE_HOST', 'croice.com');
define('CROICE_URL', 'http://' . CROICE_HOST);
define('CROICE_ID', 'croice');

register_deactivation_hook(__FILE__, 'croice_delete');

add_action('admin_menu', 'croice_add_pages');
add_action('admin_notices', 'croice_messages');
add_action('widgets_init', 'croice_register_widgets');

class CroiceWidget extends WP_Widget {

	function CroiceWidget() {
		// Instantiate the parent object
		parent::__construct( false, 'Croice' );
	}

	function widget( $args, $instance ) {
		if( get_option('croice_id') ) {
			$id = get_option('croice_id');
			$host = CROICE_URL;
			echo <<<HTML
<iframe src="{$host}/widget/{$id}" width="300" height="412" scrolling="no" frameborder="no"></iframe>
HTML;
		}
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
	}

	function form( $instance ) {
		// Output admin widget options form
	}
}

function croice_register_widgets() {
	register_widget('CroiceWidget');
}


/**
 * Notice of setting the widget
 */
function croice_messages() {

	$page = (isset($_GET['page']) ? $_GET['page'] : null);
	if( !get_option('croice_id') && $page != CROICE_ID ) {
		echo '<div class="updated"><p><b>' . __('You must <a href="options-general.php?page=croice">configure the plugin</a> to enable Croice.', CROICE_ID) . '</b></p></div>';
	}
}

/**
 * Action when uninstall plugin
 */
function croice_delete(){
	delete_option('croice_id');
}

/**
 * Include manage file
 */
function croice_options_page() {
	if( $_POST['croice_form_counter_sub'] == 'Y' ) {
		if(isset($_POST['croice_id'])){
			update_option( 'croice_id',  $_POST['croice_id'] );
		}else{
			delete_option('croice_id');
		}
		echo '<div class="updated"><p><strong>'.__('Options saved', CROICE_ID).'</strong></p></div>';
	}
	include_once(dirname(__FILE__) . '/manage.php');
}



/**
 * Insert menu in the Comments section
 */
function croice_add_pages() {
	add_options_page('Croice Plugin', 'Croice', 'read', CROICE_ID, 'croice_options_page');
}