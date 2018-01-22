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
/*
  if (!class_exists('WP_List_Table')) {
  require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
  }
  $user_bulk_upload_results = array();
  add_action('init', 'learn_press_manage_user_actions');




  if (!function_exists('learn_press_manage_user_actions')) {

  function learn_press_manage_user_actions() {
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

  class upload_List_Table extends WP_List_Table {

  function __construct() {
  global $status, $page;

  parent::__construct(array(
  'singular' => 'upload',
  'plural' => 'uploads',
  ));
  }



  function column_default($item, $column_name) {
  return $item[$column_name];
  }

  function column_user_id($item) {
  // links going to /admin.php?page=[your_plugin_page][&other_params]
  // notice how we used $_REQUEST['page'], so action will be done on curren page
  // also notice how we use $this->_args['singular'] so in this example it will
  // be something like &person=2
  $actions = array(
  'edit' => sprintf('<a href="user-edit.php?user_id=%s">%s</a>', $item['user_id'], __('View', 'custom_table_example')),
  );
  $display_name = get_user_meta($item['user_id'], "first_name", true) . " " . get_user_meta($item['user_id'], "last_name", true);

  return sprintf('%s %s', $display_name, $this->row_actions($actions));
  }

  function column_lesson_id($item) {
  // links going to /admin.php?page=[your_plugin_page][&other_params]
  // notice how we used $_REQUEST['page'], so action will be done on curren page
  // also notice how we use $this->_args['singular'] so in this example it will
  // be something like &person=2
  $actions = array(
  'edit' => sprintf('<a href="wp-admin/post.php?post=%s">%s</a>', $item['lesson_id'], __('View', 'custom_table_example')),
  );
  $display_name = get_post_field('post_title', $item['lesson_id']);

  return sprintf('%s %s', $display_name, $this->row_actions($actions));
  }

  function column_course_id($item) {
  // links going to /admin.php?page=[your_plugin_page][&other_params]
  // notice how we used $_REQUEST['page'], so action will be done on curren page
  // also notice how we use $this->_args['singular'] so in this example it will
  // be something like &person=2
  $actions = array(
  'edit' => sprintf('<a href="wp-admin/post.php?post=%s">%s</a>', $item['course_id'], __('View', 'custom_table_example')),
  );
  $display_name = get_post_field('post_title', $item['course_id']);

  return sprintf('%s %s', $display_name, $this->row_actions($actions));
  }

  function column_filelink($item) {
  // links going to /admin.php?page=[your_plugin_page][&other_params]
  // notice how we used $_REQUEST['page'], so action will be done on curren page
  // also notice how we use $this->_args['singular'] so in this example it will
  // be something like &person=2
  $actions = array(
  'download' => sprintf('<a target="_blank" href="%s">%s</a>', $item['filelink'], __('Download', 'custom_table_example')),
  );


  return sprintf('%s %s', $item['filelink'], $this->row_actions($actions));
  }

  function column_file_status($item) {


  if ($item['file_status'] == "uploaded") {
  $actions = array(
  'action' => sprintf('<a  class="change_action" data-upload-id ="%s" data-new-action = "%s"  href="#">%s</a>', $item['upload_id'], 'approved', __('Approve', 'custom_table_example')),
  'delete' => sprintf('<a class="change_action" data-upload-id ="%s" data-new-action = "%s"  href="#">%s</a>', $item['upload_id'], 'delete', __('Delete', 'custom_table_example')),
  );
  }



  return sprintf('%s %s', $item['file_status'], $this->row_actions($actions));
  }


  function column_cb($item) {
  return sprintf(
  '<input type="checkbox" name="id[]" value="%s" />', $item['id']
  );
  }


  function get_columns() {
  $columns = array(
  'upload_id' => __('S.No', 'custom_table_example'),
  'user_id' => __('User Name', 'custom_table_example'),
  'course_id' => __('Course Name', 'custom_table_example'),
  'lesson_id' => __('Lesson Name', 'custom_table_example'),
  'filelink' => __('File Path', 'custom_table_example'),
  'upload_time' => __('Uploaded Time', 'custom_table_example'),
  'file_status' => __('Status', 'custom_table_example')
  );
  return $columns;
  }

  function get_sortable_columns() {
  $sortable_columns = array(
  );
  return $sortable_columns;
  }

  function get_bulk_actions() {
  $actions = array(
  );
  return $actions;
  }


  function prepare_items() {
  global $wpdb;

  //
  $upload_table_name = $wpdb->prefix . 'learnpress_user_itemuploads'; // do not forget about tables prefix
  $user_item_table = $wpdb->prefix . 'learnpress_user_items';
  $per_page = 10; // constant, how much records will be shown per page

  $columns = $this->get_columns();
  $hidden = array();
  $sortable = $this->get_sortable_columns();

  // here we configure table headers, defined in our methods
  $this->_column_headers = array($columns, $hidden, $sortable);


  // will be used in pagination settings
  // prepare query params, as usual current page, order by and order direction
  $paged = isset($_REQUEST['paged']) ? ($per_page * max(0, intval($_REQUEST['paged']) - 1)) : 0;
  $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'rel_id';
  $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';
  $where = "";
  if ($_REQUEST['username-filter']) {
  $where = "WHERE ut.user_id = " . $_REQUEST['username-filter'];
  }
  $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $upload_table_name $where");
  // [REQUIRED] define $items array
  // notice that last argument is ARRAY_A, so we will retrieve array
  $items = $wpdb->get_results($wpdb->prepare("SELECT upload_id, uploads.status as file_status, uploads.date_time as upload_time, uploads.media_path as filelink, ut.item_id as lesson_id, ut.ref_id as course_id, ut.user_id FROM $upload_table_name as uploads LEFT JOIN $user_item_table as ut on ut.user_item_id = uploads.learnpress_user_item_id $where   LIMIT %d OFFSET %d ", $per_page, $paged), ARRAY_A);
  // echo $wpdb->last_error;
  // exit;
  $this->items = $items;

  // [REQUIRED] configure pagination
  $this->set_pagination_args(array(
  'total_items' => $total_items, // total items defined above
  'per_page' => $per_page, // per page constant defined at top of method
  'total_pages' => ceil($total_items / $per_page) // calculate pages count
  ));
  }

  function extra_tablenav($which) {
  global $wpdb;
  $upload_table_name = $wpdb->prefix . 'learnpress_user_itemuploads'; // do not forget about tables prefix
  $user_item_table = $wpdb->prefix . 'learnpress_user_items';
  if ($which == "top") {
  ?>
  <div class="alignleft actions">  <?php
  $users = $wpdb->get_results("SELECT ut.user_id FROM $upload_table_name as uploads LEFT JOIN $user_item_table as ut on ut.user_item_id = uploads.learnpress_user_item_id", ARRAY_A);
  if ($users) {
  ?>
  <select name="username-filter" class="username-filter">
  <option value="">All Users</option>
  <?php
  foreach ($users as $user) {
  $selected = '';
  if ($_REQUEST['username-filter'] == $user['user_id']) {
  $selected = ' selected = "selected"';
  }
  ?>
  <option value="<?php echo $user['user_id']; ?>" <?php echo $selected; ?>><?php echo get_userdata($user['user_id'])->user_login; ?></option>
  <?php
  }
  ?>
  </select>
  <?php
  }
  ?>
  <input type="submit" name="filter_action" id="post-query-submit" class="button" value="Filter">
  </div>
  <?php
  }
  }

  }
 */

function learn_press_reports_page() {
    ?>

    <div id="learn-press-reports-wrap" class="wrap">
        <h2><?php echo __('Reports', 'learnpress'); ?></h2>
    </div>
        <?php
    }
    