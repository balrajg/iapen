<?php

/**
 * Class LP_Email_User_Order_Completed
 *
 * @author  ThimPress
 * @package LearnPress/Classes
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit();
if ( !class_exists( 'LP_Email_User_Notify_File_Approved' ) ) {

	class LP_Email_User_Notify_File_Approved extends LP_Email {
		/**
		 * LP_Email_User_Order_Completed constructor.
		 */
		public function __construct() {
			$this->id    = 'user_file_approved';
			$this->title = __( 'User File Approved', 'learnpress' );

			$this->template_html  = 'emails/user-order-completed.php';
			$this->template_plain = 'emails/plain/user-order-completed.php';

			$this->default_subject = __( 'Your File for course {{course_name}} is approved', 'learnpress' );
			$this->default_heading = __( 'Your lesson {{lesson_name}} is completed', 'learnpress' );

			$this->support_variables = array(
				'{{site_url}}',
				'{{site_title}}',
				'{{site_admin_email}}',
				'{{site_admin_name}}',
				'{{login_url}}',
				'{{header}}',
				'{{footer}}',
				'{{email_heading}}',
				'{{footer_text}}',
				'{{course_name}}',
				'{{lesson_name}}',
				'{{user_name}}'
			);

			// $this->email_text_message_description = sprintf( '%s {{order_number}}, {{order_total}}, {{order_view_url}}, {{user_email}}, {{user_name}}, {{user_profile_url}}', __( 'Shortcodes', 'learnpress' ) );

			add_action( 'learn_press_user_file_approved_notification', array( $this, 'trigger' ) );

			parent::__construct();
		}

		public function admin_options( $settings_class ) {
			$view = learn_press_get_admin_view( 'settings/emails/user-order-completed.php' );
			include_once $view;
		}

		/**
		 * Trigger email to send to users
		 *
		 * @param $order_id
		 *
		 * @return bool
		 */
		public function trigger( $course_id, $lesson_id, $user_id ) {

			if ( !$this->enable ) {
				return false;
			}

			$format = $this->email_format == 'plain_text' ? 'plain' : 'html';

			$this->object = $this->get_common_template_data(
				$format,
				array(
					'course_id'          => $course_id,
					'lesson_id'     => $lesson_id,
					'user_id'   => $user_id
				)
			);

			
				$this->variables       = $this->data_to_variables( $this->object );
				$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
			
			return false;
		}

		/**
		 * Get email recipients
		 *
		 * @return mixed|void
		 */
		public function get_recipient() {
			if ( $user_id= $this->object['user_id'] ) {
				$this->recipient = get_userdata($user_id)->user_email;
			}
			return parent::get_recipient();
		}

		/**
		 * @param string $format
		 *
		 * @return array|void
		 */
		public function get_template_data( $format = 'plain' ) {
			return $this->object;

		}
	}
}

return new LP_Email_User_Notify_File_Approved();
