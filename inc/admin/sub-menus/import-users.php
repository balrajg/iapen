<?php
/**
 * Admin view for add-ons page display in admin under menu LearnPress -> Add ons
 *
 * @author  ThimPress
 * @package Admin/Views
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
add_action( 'init', 'learn_press_upload_user_actions' );
if ( !function_exists( 'learn_press_upload_user_actions' ) ) {

	function learn_press_upload_user_actions() {
		$action = learn_press_get_request( 'action' );
		if ( !$action ) return;
		if ( current_user_can( 'manage_options' ) ) {
			switch ( $action ) {
				case 'learn-press-upload-users':
					learn_press_upload_user_data();
					break;
				
				default:
					break;
			}
			
		} else {
			wp_die( __( 'Sorry, you are nto allowed to access this page.', 'learnpress' ) );
		}
	}

}

if ( !function_exists( 'learn_press_upload_user_data' ) ) {
	function learn_press_upload_user_data() {
		global $wpdb;
		$nonce = learn_press_get_request( 'learn-press-upload-users-nonce' );
		echo $nonce;
		
		if ( !wp_verify_nonce( $nonce, 'learn-press-upload-user-data' ) ) {
			return;
		}
		
$excelfilepaath = learn_press_get_request("excel-file-url");
echo $excelfilepaath;
		

		LP_Admin_Notice::add( __( 'All courses, lessons, quizzes and questions have been removed', 'learnpress' ), 'updated', '', true );
		//wp_redirect( admin_url( 'admin.php?page=learn-press-tools&learn-press-remove-data=1' ) );
		exit();
	}
}


function learn_press_page_import_users() {
	?>
	<form method="post">
	<input type="text" name="excel-file-url" id="excel-file-url" readonly="true"/><br/><br/>
	  <input id="upload-button" type="button" class="browser button" value="Upload File" />
	  
	  <input type="submit" value="Proceed" />
	  <input type ="hidden" name="action" value="learn-press-upload-users" />
	   <?php wp_nonce_field( 'learn-press-upload-user-data', 'learn-press-upload-users-nonce' ); ?>
	</form>

	<script type="text/javascript">
		jQuery(function ($) {
			var mediaUploader;

  $('#upload-button').click(function(e) {
    e.preventDefault();
    // If the uploader object has already been created, reopen the dialog
      if (mediaUploader) {
      mediaUploader.open();
      return;
    }
    // Extend the wp.media object
    mediaUploader = wp.media.frames.file_frame = wp.media({
      title: 'Select File',
      button: {
      text: 'Select File'
    }, multiple: false });

    // When a file is selected, grab the URL and set it as the text field's value
    mediaUploader.on('select', function() {
      var attachment = mediaUploader.state().get('selection').first().toJSON();
      $('#excel-file-url').val(attachment.url);
    });
    // Open the uploader dialog
    mediaUploader.open();
  });
		})
	</script>
	<?php
}


/**
 * Add-on page
 */
function learn_press_import_users_page() {
	/*$subtabs = learn_press_tools_subtabs();
	$subtab  = !empty( $_REQUEST['tab'] ) ? $_REQUEST['tab'] : '';
	if ( !$subtab ) {
		$tab_keys = array_keys( $subtabs );
		$subtab   = reset( $tab_keys );
	} */
	$subtab = "import_users";
	?>
	<div id="learn-press-tools-wrap" class="wrap">
		 <h2><?php echo __( 'Import Users', 'learnpress' ); ?></h2>
		
		<?php
		if ( is_callable( 'learn_press_page_' . $subtab ) ) {
			call_user_func( 'learn_press_page_' . $subtab, $subtab, $subtabs[$subtab] );
		} else {
			do_action( 'learn_press_page_' . $subtab, $subtab, $subtabs[$subtab] );
		}
		?>
	</div>
	<?php
}
