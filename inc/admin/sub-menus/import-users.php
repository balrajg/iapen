<?php
/**
 * Admin view for add-ons page display in admin under menu LearnPress -> Add ons
 *
 * @author  ThimPress
 * @package Admin/Views
 * @version 1.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
global $user_bulk_upload_results;
add_action('init', 'learn_press_upload_user_actions');

if (!function_exists('learn_press_upload_user_actions')) {

    function learn_press_upload_user_actions() {
        $action = learn_press_get_request('action');
        if (!$action)
            return;
        if (current_user_can('manage_options')) {
            switch ($action) {
                case 'learn-press-upload-users':
                    learn_press_upload_user_data();
                    break;

                default:
                    break;
            }
        } else {
            wp_die(__('Sorry, you are nto allowed to access this page.', 'learnpress'));
        }
    }

}

if (!function_exists('learn_press_upload_user_data')) {

    function learn_press_upload_user_data() {
        global $wpdb;
        $nonce = learn_press_get_request('learn-press-upload-users-nonce');
        if (!wp_verify_nonce($nonce, 'learn-press-upload-user-data')) {
            return;
        }

        $excelfileId = learn_press_get_request("excel-attachment-id");
        $Filepath = get_attached_file($excelfileId);
        if (file_exists($file = LP_PLUGIN_PATH . "/inc/admin/excel-reader/php-excel-reader/excel_reader2.php")) {
            require_once $file;

            require_once LP_PLUGIN_PATH . "/inc/admin/excel-reader/SpreadsheetReader.php";
        }

        // $StartMem = memory_get_usage();

        $user_bulk_upload_results = [];
        try {
            $Spreadsheet = new SpreadsheetReader($Filepath);

            // $BaseMem = memory_get_usage();

            $Sheets = $Spreadsheet->Sheets();
            foreach ($Sheets as $Index => $Name) {
                $Time = microtime(true);
                $Spreadsheet->ChangeSheet($Index);
                $columnDefinitions = [];
                foreach ($Spreadsheet as $Key => $Row) {

                    // echo $Key.': ';

                    if ($Key == 0) {

                        // create column definitions

                        foreach ($Row as $rowKey => $rowVal) {
                            $columnDefinitions[$rowVal] = $rowKey;
                        }
                    } else {
                        if ($Row) {
                            $user_id = learn_press_page_import_create_user($Row, $columnDefinitions);
                            if ($user_id) {
                                ipa_create_order_for_user($Row, $columnDefinitions, $user_id);
                            }
                        } else {

                            //
                        }
                    }
                }
            }
        } catch (Exception $E) {
            echo $E->getMessage();
        }
    }
}
function learn_press_page_import_create_user($Row, $columnDefinitions) {
    $user_name = $Row[$columnDefinitions["username"]];
    $user_email = $Row[$columnDefinitions["email"]];
    $user_password = $Row[$columnDefinitions["password"]];
    $user_id = username_exists($user_name);
    if (!$user_id and email_exists($user_email) == false) {
        $user_id = wp_create_user($user_name, $user_password, $user_email);
        if ($user_id) {
            wp_update_user(array(
                'ID' => $user_id,
                'first_name' => $Row[$columnDefinitions["firstname"]],
                'last_name' => $Row[$columnDefinitions["lastname"]]
            ));
           // array_push($user_bulk_upload_results, "user for $user_name is created successfully and id is $user_id");
        }

        // $result[$user_name] = "created";
    }
                
    return $user_id;
}

function ipa_create_order_for_user($Row, $columnDefinitions, $user_id) {
    $courseName = $Row[$columnDefinitions["course1"]];
    global $wpdb;
    if ($courseName != "") {
        $course = get_page_by_title($courseName, "OBJECT", "lp_course");
     
        if ($course != null) {
            echo $order_id = $wpdb->get_var( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_user_id' AND meta_value= $user_id" );
			
	$args = array(
				'meta_key'         => '_user_id',
				'meta_value'       =>  $user_id,
				'post_type'        =>  LP_ORDER_CPT,
				'post_status'      => 'lp-completed'
			);
$posts_array = get_posts( $args ); 
print_r($posts_array);
exit;

			
            if($order_id==null|| empty($order_id)){
               $order_id = ipa_create_order($user_id);
            }else{
				add_post_meta($order_id, '_user_id', $user_id);
			}
            ipa_add_item_to_order($order_id, $course->ID);
            //array_push($user_bulk_upload_results, "$courseName is added to $user_id");
           
        } else {
            echo $courseName . " is not available. please verify once again";
        }
    }
}

/**
 * Creates temp new order if needed
 *
 * @return mixed|WP_Error
 * @throws Exception
 */
function ipa_create_order($user_id) {
    global $wpdb;
    // Third-party can be controls to create a order
    try {
        // Start transaction if available
        //$wpdb->query( 'START TRANSACTION' );

        $order_data = array(
            'status' => apply_filters('learn_press_default_order_status', 'completed'),
            'user_id' => $user_id,
            'user_note' => "Created from bulk upload",
            'created_via' => 'admin'
        );


        $order = ipa_create_complete_order($order_data);
        if (is_wp_error($order)) {
            throw new Exception(sprintf(__('Error %d: Unable to create order. Please try again.', 'learnpress'), 400));
        } else {
            $order_id = $order->id;
        }


        //$wpdb->query( 'COMMIT' );
    } catch (Exception $e) {
        // There was an error adding order data!
        $wpdb->query('ROLLBACK');
        echo $e->getMessage();
        return false; //$e->getMessage();
    }


    return $order_id;
}

function ipa_create_complete_order($order_data) {
    $order_data_defaults = array(
        'ID' => 0,
        'post_author' => '1',
        'post_parent' => '0',
        'post_type' => LP_ORDER_CPT,
        'post_status' => 'lp-' . apply_filters('learn_press_default_order_status', 'completed'),
        'ping_status' => 'closed',
        'post_title' => __('Order on', 'learnpress') . ' ' . current_time("l jS F Y h:i:s A")
    );
    $order_data = wp_parse_args($order_data, $order_data_defaults);

    if ($order_data['status']) {
        if (!in_array('lp-' . $order_data['status'], array_keys(learn_press_get_order_statuses()))) {
            return new WP_Error('learn_press_invalid_order_status', __('Invalid order status', 'learnpress'));
        }
        $order_data['post_status'] = 'lp-' . $order_data['status'];
    }



    if ($order_data['ID']) {
        $order_data = apply_filters('learn_press_update_order_data', $order_data);
        wp_update_post($order_data);
        $order_id = $order_data['ID'];
    } else {
        $order_data = apply_filters('learn_press_new_order_data', $order_data);
        $order_id = wp_insert_post($order_data);
    }

    if ($order_id) {
        $order = LP_Order::instance($order_id);
        update_post_meta($order_id, '_order_currency', learn_press_get_currency());
        update_post_meta($order_id, '_prices_include_tax', 'no');
        update_post_meta($order_id, '_user_ip_address', learn_press_get_ip());
        update_post_meta($order_id, '_user_agent', isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '' );
        update_post_meta($order_id, '_user_id', $order_data[user_id]);
       // update_post_meta( $order_id, '_lp_multi_users', 'yes', 'yes' );
        update_post_meta($order_id, '_order_subtotal', 0);
        update_post_meta($order_id, '_order_total', 0);
        update_post_meta($order_id, '_order_key', apply_filters('learn_press_generate_order_key', uniqid('order')));
        update_post_meta($order_id, '_payment_method', '');
        update_post_meta($order_id, '_payment_method_title', '');
        update_post_meta($order_id, '_order_version', '1.0');
        update_post_meta($order_id, '_created_via', 'bulk-upload');
    }

    return LP_Order::instance($order_id, true);
}

/**
 * Add new course to order
 */
function ipa_add_item_to_order($order_id, $item_id) {

    // ensure that user has permission
    if (!current_user_can('edit_lp_orders')) {
        die(__('Permission denied', 'learnpress'));
    }


    // validate order
    if (!is_numeric($order_id) || get_post_type($order_id) != 'lp_order') {
        die(__('Order invalid', 'learnpress'));
    }

    // validate item

    $item_html = '';
    $order_data = array();
    $post = get_post($item_id);
    if (!$post || ( 'lp_course' !== $post->post_type )) {
        echo $item_id . "<br/>";
        echo __('Course invalid', 'learnpress');
        return;
    }
    $course = learn_press_get_course($post->ID);
    $item = array(
        'course_id' => $course->id,
        'name' => $course->get_title(),
        'quantity' => 1,
        'subtotal' => $course->get_price(),
        'total' => $course->get_price()
    );

    // Add item
    $item_id = learn_press_add_order_item($order_id, array(
        'order_item_name' => $item['name']
            ));

    $item['id'] = $item_id;

    // Add item meta
    if ($item_id) {
        learn_press_add_order_item_meta($item_id, '_course_id', $item['course_id']);
        learn_press_add_order_item_meta($item_id, '_quantity', $item['quantity']);
        learn_press_add_order_item_meta($item_id, '_subtotal', $item['subtotal']);
        learn_press_add_order_item_meta($item_id, '_total', $item['total']);
    }

    $order_data = learn_press_update_order_items($order_id);
    $currency_symbol = learn_press_get_currency_symbol($order_data['currency']);
    $order_data['subtotal_html'] = learn_press_format_price($order_data['subtotal'], $currency_symbol);
    $order_data['total_html'] = learn_press_format_price($order_data['total'], $currency_symbol);
}

if (!function_exists('get_post_id_by_meta_key_and_value')) {

    function get_post_id_by_meta_key_and_value($key, $value) {
        global $wpdb;
        $meta = $wpdb->get_results("SELECT * FROM `" . $wpdb->postmeta . "` WHERE meta_key='" . $wpdb->escape($key) . "' AND meta_value='" . $wpdb->escape($value) . "'");
        if (is_array($meta) && !empty($meta) && isset($meta[0])) {
            $meta = $meta[0];
        }
        if (is_object($meta)) {
            return $meta->post_id;
        } else {
            return false;
        }
    }

}

function learn_press_page_import_users() {
    
    ?>
    <form method="post">
        <pre>
        <?php
        if(!(empty($user_bulk_upload_results))){
            
            print_r($user_bulk_upload_results);
        }
        ?>
        </pre>
        <input type="text" name="excel-file-url" id="excel-file-url" readonly="true"/><br/><br/>
        <input id="upload-button" type="button" class="browser button" value="Upload File" />
        <input type="hidden" name="excel-attachment-id" id="excel-attachment-id" />
        <input type="submit" value="Proceed" />
        <input type ="hidden" name="action" value="learn-press-upload-users" />
    <?php wp_nonce_field('learn-press-upload-user-data', 'learn-press-upload-users-nonce'); ?>
    </form>

    <script type="text/javascript">
        jQuery(function ($) {
            var mediaUploader;

            $('#upload-button').click(function (e) {
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
                    }, multiple: false});


    // When a file is selected, grab the URL and set it as the text field's value

                mediaUploader.on('select', function () {
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
function learn_press_import_users_page() {
    /* $subtabs = learn_press_tools_subtabs();
      $subtab  = !empty( $_REQUEST['tab'] ) ? $_REQUEST['tab'] : '';
      if ( !$subtab ) {
      $tab_keys = array_keys( $subtabs );
      $subtab   = reset( $tab_keys );
      } */
    $subtab = "import_users";
    ?>
    <div id="learn-press-tools-wrap" class="wrap">
        <h2><?php echo __('Import Users', 'learnpress'); ?></h2>

    <?php
    if (is_callable('learn_press_page_' . $subtab)) {
        call_user_func('learn_press_page_' . $subtab, $subtab, $subtabs[$subtab]);
    } else {
        do_action('learn_press_page_' . $subtab, $subtab, $subtabs[$subtab]);
    }
    ?>
    </div>
    <?php
}
