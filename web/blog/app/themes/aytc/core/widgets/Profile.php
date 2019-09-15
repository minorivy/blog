<?php

class Profile_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 *
	 * @link https://developer.wordpress.org/reference/classes/wp_widget/__construct/
	 * @see https://developer.wordpress.org/reference/functions/wp_register_sidebar_widget/
	 */
	public function __construct() {
		parent::__construct('mnr_profile_widget', '【子テーマ】プロフィール', [
			'classname' => 'mnr_profile_widget',
			'description' => 'プロフィールを表示します',
		]);
	}

		/**
		 * Outputs the content of the widget on front-end
		 *
		 * @param array $args Widget arguments
		 * @param array $instance
		 * @link https://developer.wordpress.org/reference/classes/wp_widget/widget/
		 */
		public function widget( $args, $instance ) {
			$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __('About Me');

			echo $args['before_widget'];
			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'] . "\n";
			}
			$author_id = 1; // admin user
			$obj_author = get_userdata($author_id);
			?>
			<figure class="profile-box-thumb profile-box-thumb--center">
				<?php echo keni_get_avatar($author_id);?>
			</figure>
			<p class="mnr_profile_widget__author_name"><?php echo esc_html( $obj_author->display_name );?></p>
			<?php if ($obj_author->description):?>
			<p class="mnr_profile_widget__description"><?php echo $obj_author->description;?></p>
			<?php endif;
			echo $args['after_widget'];
		}

		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 * @link https://developer.wordpress.org/reference/classes/wp_widget/form/
		 */
		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__('About Me');
			?>
			<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
			<?php esc_attr_e( 'Title:'); ?>
			</label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				type="text"
				value="<?php echo esc_attr( $title ); ?>">
			</p>
			<?php
		}

		/**
		 * Processing widget options on save
		 *
		 * @param array $new_instance The new options
		 * @param array $old_instance The previous options
		 * @link https://developer.wordpress.org/reference/classes/wp_widget/update/
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = [];
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			return $instance;
		}
}

add_action( 'widgets_init', function(){
	register_widget( 'Profile_Widget' );
});
