<?php
/**
 * Admin view for add-ons page display in admin under menu LearnPress -> Add ons
 *
 * @author  ThimPress
 * @package Admin/Views
 * @version 1.0
 */

if (!defined('ABSPATH'))
	{
	exit; // Exit if accessed directly
	}

add_action('init', 'learn_press_upload_user_actions');

if (!function_exists('learn_press_upload_user_actions'))
	{
	function learn_press_upload_user_actions()
		{
		$action = learn_press_get_request('action');
		if (!$action) return;
		if (current_user_can('manage_options'))
			{
			switch ($action)
				{
			case 'learn-press-upload-users':
				learn_press_upload_user_data();
				break;

			default:
				break;
				}
			}
		  else
			{
			wp_die(__('Sorry, you are nto allowed to access this page.', 'learnpress'));
			}
		}
	}

if (!function_exists('learn_press_upload_user_data'))
	{
	function learn_press_upload_user_data()
		{
		global $wpdb;
		$nonce = learn_press_get_request('learn-press-upload-users-nonce');
		if (!wp_verify_nonce($nonce, 'learn-press-upload-user-data'))
			{
			return;
			}

		$excelfileId = learn_press_get_request("excel-attachment-id");
		$Filepath = get_attached_file($excelfileId);
		if (file_exists($file = LP_PLUGIN_PATH . "/inc/admin/excel-reader/php-excel-reader/excel_reader2.php"))
			{
			require_once $file;

			require_once LP_PLUGIN_PATH . "/inc/admin/excel-reader/SpreadsheetReader.php";

			}

		// $StartMem = memory_get_usage();

		$result = [];
		try
			{
			$Spreadsheet = new SpreadsheetReader($Filepath);

			// $BaseMem = memory_get_usage();

			$Sheets = $Spreadsheet->Sheets();
			foreach($Sheets as $Index => $Name)
				{
				$Time = microtime(true);
				$Spreadsheet->ChangeSheet($Index);
				$columnDefinitions = [];
				foreach($Spreadsheet as $Key => $Row)
					{

					// echo $Key.': ';

					if ($Key == 0)
						{

						// create column definitions

						foreach($Row as $rowKey => $rowVal)
							{
							$columnDefinitions[$rowVal] = $rowKey;
							}
						}
					  else
						{
						if ($Row)
							{
							$user_id = learn_press_page_import_create_user($Row, $columnDefinitions);
							if ($user_id)
								{
								ipa_create_order_for_user($Row, $columnDefinitions, $user_id);
								}
							}
						  else
							{

							//

							}
						}
					}
				}
			}

		catch(Exception $E)
			{
			echo $E->getMessage();
			}

		// print_r($result);
		// LP_Admin_Notice::add( __( 'All courses, lessons, quizzes and questions have been removed', 'learnpress' ), 'updated', '', true );
		// wp_redirect( admin_url( 'admin.php?page=learn-press-tools&learn-press-remove-data=1' ) );
		// exit();

		}
	}

function learn_press_page_import_create_user($Row, $columnDefinitions)
	{
	$user_name = $Row[$columnDefinitions["username"]];
	$user_email = $Row[$columnDefinitions["email"]];
	$user_password = $Row[$columnDefinitions["password"]];
	$user_id = username_exists($user_name);
	if (!$user_id and email_exists($user_email) == false)
		{
		$user_id = wp_create_user($user_name, $user_password, $user_email);
		if ($user_id)
			{
			wp_update_user(array(
				'ID' => $user_id,
				'first_name' => $Row[$columnDefinitions["firstname"]],
				'last_name' => $Row[$columnDefinitions["lastname"]]
			));
			}

		// $result[$user_name] = "created";

		}

	return $user_id;
	}

function ipa_create_order_for_user($Row, $columnDefinitions, $user_id)
	{
	$courseName = $Row[$columnDefinitions["course1"]];
	if ($courseName != "")
		{
		$course = get_page_by_title($courseName, "OBJECT", "lp_course");
		if ($course != null)
			{

			// do create lms-order for this course and user;

			}
		}
	}

function learn_press_page_import_users()
	{
	echo $filetype = wp_check_filetype($file) ["ext"];
?>
	<form method="post">
	<input type="text" name="excel-file-url" id="excel-file-url" readonly="true"/><br/><br/>
	  <input id="upload-button" type="button" class="browser button" value="Upload File" />
	  <input type="hidden" name="excel-attachment-id" id="excel-attachment-id" />
	  <input type="submit" value="Proceed" />
	  <input type ="hidden" name="action" value="learn-press-upload-users" />
	   <?php
	wp_nonce_field('learn-press-upload-user-data', 'learn-press-upload-users-nonce'); ?>
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
	  $('#excel-attachment-id').val(attachment.id);
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

function learn_press_import_users_page()
	{
	/*$subtabs = learn_press_tools_subtabs();
	$subtab  = !empty( $_REQUEST['tab'] ) ? $_REQUEST['tab'] : '';
	if ( !$subtab ) {
	$tab_keys = array_keys( $subtabs );
	$subtab   = reset( $tab_keys );
	} */
	$subtab = "import_users";
?>
	<div id="learn-press-tools-wrap" class="wrap">
		 <h2><?php
	echo __('Import Users', 'learnpress'); ?></h2>
		
		<?php
	if (is_callable('learn_press_page_' . $subtab))
		{
		call_user_func('learn_press_page_' . $subtab, $subtab, $subtabs[$subtab]);
		}
	  else
		{
		do_action('learn_press_page_' . $subtab, $subtab, $subtabs[$subtab]);
		}

?>
	</div>
	<?php
	}