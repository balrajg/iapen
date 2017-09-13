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

class Custom_Table_Example_List_Table extends WP_List_Table {

    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct() {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'person',
            'plural' => 'persons',
        ));
    }

    /**
     * [REQUIRED] this is a default column renderer
     *
     * @param $item - row (key, value array)
     * @param $column_name - string (key)
     * @return HTML
     */
    function column_default($item, $column_name) {
        return $item[$column_name];
    }

    /**
     * [OPTIONAL] this is example, how to render specific column
     *
     * method name must be like this: "column_[column_name]"
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_age($item) {
        return '<em>' . $item['age'] . '</em>';
    }

    /**
     * [OPTIONAL] this is example, how to render column with actions,
     * when you hover row "Edit | Delete" links showed
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_coursename($item) {
        // links going to /admin.php?page=[your_plugin_page][&other_params]
        // notice how we used $_REQUEST['page'], so action will be done on curren page
        // also notice how we use $this->_args['singular'] so in this example it will
        // be something like &person=2
        $actions = array(
            'edit' => sprintf('<a href="?page=persons_form&id=%s">%s</a>', $item['rel_id'], __('Edit', 'custom_table_example')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['rel_id'], __('Delete', 'custom_table_example')),
        );

        return sprintf('%s %s', $item['coursename'], $this->row_actions($actions)
        );
    }

    /**
     * [REQUIRED] this is how checkbox column renders
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="id[]" value="%s" />', $item['id']
        );
    }

    /**
     * [REQUIRED] This method return columns to display in table
     * you can skip columns that you do not want to show
     * like content, or description
     *
     * @return array
     */
    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'coursename' => __('Course Name', 'custom_table_example'),
            'username' => __('User Name', 'custom_table_example'),
            'parent_username' => __('Reporting To', 'custom_table_example'),
            'user_role' => __('Role for Course', 'custom_table_example')
        );
        return $columns;
    }

    /**
     * [OPTIONAL] This method return columns that may be used to sort table
     * all strings in array - is column names
     * notice that true on name column means that its default sort
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = array(
        );
        return $sortable_columns;
    }

    /**
     * [OPTIONAL] Return array of bult actions if has any
     *
     * @return array
     */
    function get_bulk_actions() {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    /**
     * [OPTIONAL] This method processes bulk actions
     * it can be outside of class
     * it can not use wp_redirect coz there is output already
     * in this example we are processing delete action
     * message about successful deletion will be shown on page in next part
     */
    function process_bulk_action() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'learnpress_user_relation'; // do not forget about tables prefix

        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids))
                $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
            }
        }
    }

    /**
     * [REQUIRED] This is the most important method
     *
     * It will get rows from database and prepare them to be showed in table
     */
    function prepare_items() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'learnpress_user_relation'; // do not forget about tables prefix

        $per_page = 10; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

        // will be used in pagination settings
        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? ($per_page * max(0, intval($_REQUEST['paged']) - 1)) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'rel_id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';
        $where = "";
        if ($_REQUEST['username-filter']) {
            $where = "WHERE relation.user = " . $_REQUEST['username-filter'];
        }
        $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name $where");
        // [REQUIRED] define $items array
        // notice that last argument is ARRAY_A, so we will retrieve array
        $items = $wpdb->get_results($wpdb->prepare("SELECT relation.rel_id, relation.user_role, user1.user_login as username,  user2.user_login as parent_username, course.post_title as coursename  FROM $table_name as relation INNER JOIN $wpdb->users as user1 ON relation.user = user1.ID LEFT JOIN $wpdb->users as user2 ON relation.parent = user2.ID INNER JOIN $wpdb->posts as course ON course.ID = relation.course_id $where ORDER BY user_role  LIMIT %d OFFSET %d ", $per_page, $paged), ARRAY_A);
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
        $table_name = $wpdb->prefix . 'learnpress_user_relation';
        if ($which == "top") {
            ?>
            <div class="alignleft actions">  <?php
            //   echo "select u.userlogin as name r.user as user from $table_name as r INNER JOIN $wpdb->users as u on r.user = u.ID ";
            $users = $wpdb->get_results("select u.user_login as name, r.user as user from $table_name as r INNER JOIN $wpdb->users as u ON r.user = u.ID ", ARRAY_A);
            if ($users) {
                ?>
                    <select name="username-filter" class="username-filter">
                        <option value="">All Users</option>
                        <?php
                        foreach ($users as $user) {
                            $selected = '';
                            if ($_REQUEST['username-filter'] == $user['user']) {
                                $selected = ' selected = "selected"';
                            }
                            ?>
                            <option value="<?php echo $user['user']; ?>" <?php echo $selected; ?>><?php echo $user['name']; ?></option>
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

/**
 * Add-on page
 */
function learn_press_manage_users_page() {
    ?>
    <div id="learn-press-tools-wrap" class="wrap">
        <h2><?php echo __('Manage Users and Courses', 'learnpress'); ?></h2>

    <?php
    global $wpdb;

    $table = new Custom_Table_Example_List_Table();
    $table->prepare_items();

    $message = '';
    if ('delete' === $table->current_action()) {
        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'custom_table_example'), count($_REQUEST['id'])) . '</p></div>';
    }
    ?>
        <div class="wrap">

            <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
            <h2><?php _e('Persons', 'custom_table_example') ?> <a class="add-new-h2"
                                                                  href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=persons_form'); ?>"><?php _e('Add new', 'custom_table_example') ?></a>
            </h2>
    <?php echo $message; ?>

            <form id="persons-table" method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
    <?php $table->display() ?>
            </form>

        </div>

    <?php
}

/**
 * PART 4. Form for adding andor editing row
 * ============================================================================
 *
 * In this part you are going to add admin page for adding andor editing items
 * You cant put all form into this function, but in this example form will
 * be placed into meta box, and if you want you can split your form into
 * as many meta boxes as you want
 *
 * http://codex.wordpress.org/Data_Validation
 * http://codex.wordpress.org/Function_Reference/selected
 */

/**
 * Form page handler checks is there some data posted and tries to save it
 * Also it renders basic wrapper in which we are callin meta box render
 */
function custom_table_example_persons_form_page_handler() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'cte'; // do not forget about tables prefix

    $message = '';
    $notice = '';

    // this is default $item which will be used for new records
    $default = array(
        'id' => 0,
        'name' => '',
        'email' => '',
        'age' => null,
    );

    // here we are verifying does this request is post back and have correct nonce
    if (wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
        // combine our default item with request params
        $item = shortcode_atts($default, $_REQUEST);
        // validate data, and if all ok save item to database
        // if id is zero insert otherwise update
        $item_valid = custom_table_example_validate_person($item);
        if ($item_valid === true) {
            if ($item['id'] == 0) {
                $result = $wpdb->insert($table_name, $item);
                $item['id'] = $wpdb->insert_id;
                if ($result) {
                    $message = __('Item was successfully saved', 'custom_table_example');
                } else {
                    $notice = __('There was an error while saving item', 'custom_table_example');
                }
            } else {
                $result = $wpdb->update($table_name, $item, array('id' => $item['id']));
                if ($result) {
                    $message = __('Item was successfully updated', 'custom_table_example');
                } else {
                    $notice = __('There was an error while updating item', 'custom_table_example');
                }
            }
        } else {
            // if $item_valid not true it contains error message(s)
            $notice = $item_valid;
        }
    } else {
        // if this is not post back we load item to edit or give new one to create
        $item = $default;
        if (isset($_REQUEST['id'])) {
            $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $_REQUEST['id']), ARRAY_A);
            if (!$item) {
                $item = $default;
                $notice = __('Item not found', 'custom_table_example');
            }
        }
    }

    // here we adding our custom meta box
    add_meta_box('persons_form_meta_box', 'Person data', 'custom_table_example_persons_form_meta_box_handler', 'person', 'normal', 'default');
    ?>
        <div class="wrap">
            <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
            <h2><?php _e('Person', 'custom_table_example') ?> <a class="add-new-h2"
                                                                 href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=persons'); ?>"><?php _e('back to list', 'custom_table_example') ?></a>
            </h2>

    <?php if (!empty($notice)): ?>
                <div id="notice" class="error"><p><?php echo $notice ?></p></div>
    <?php endif; ?>
            <?php if (!empty($message)): ?>
                <div id="message" class="updated"><p><?php echo $message ?></p></div>
            <?php endif; ?>

            <form id="form" method="POST">
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__)) ?>"/>
            <?php /* NOTICE: here we storing id to determine will be item added or updated */ ?>
                <input type="hidden" name="id" value="<?php echo $item['id'] ?>"/>

                <div class="metabox-holder" id="poststuff">
                    <div id="post-body">
                        <div id="post-body-content">
    <?php /* And here we call our custom meta box */ ?>
    <?php do_meta_boxes('person', 'normal', $item); ?>
                            <input type="submit" value="<?php _e('Save', 'custom_table_example') ?>" id="submit" class="button-primary" name="submit">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php
}
