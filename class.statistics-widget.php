<?php
/**
 * @package Statistics
 */
class Statistics_Widget extends WP_Widget {

	function __construct() {


		parent::__construct(
			'statistics_widget',
			__( 'Statistics Widget' , 'Statistics'),
			array( 'description' => __( 'Display Meta Data About Your Posts. Shows useful, statistical information about the content on your blog, in a widget. Data displayed: Combined wordcount of all your published posts, Total no of published posts, Avg no of words written per post, and Days since the first post was published. Please note that all counts shown are approximations, based on some simple calculations.' , 'statistics') )
		);

		if ( is_active_widget( false, false, $this->id_base ) ) {
			add_action( 'wp_head', array( $this, 'css' ) );
		}
	}

	function css() {
?>

<style type="text/css">
.indefiniteloop-stats {
	width: auto;
}

.indefiniteloop-stats p span {
	color:#222;
	display: block;
	font-size: 15px;
	line-height: 16px;
	padding: 10px 5px 5px 0px;


}
</style>

<?php
	}

	function form( $instance ) {
		if ( $instance ) {
			$title = $instance['title'];
		}
		else {
			$title = __( 'Publishing Statistics' , 'statistics');
		}
?>

        <p><small>Please note that all counts shown are approximations, based on some simple calculations.</small></p>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:' , 'statistics'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

<?php
	}

	function update( $new_instance, $old_instance ) {

		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

	function widget( $args, $instance ) {
	    $no_of_days_since_first_post= get_option('no_of_days_since_first_post');
		$total_no_of_words_in_blog = get_option('total_no_of_words_in_blog');
		$total_no_posts_since_start = get_option('total_no_posts_since_start');
		$avg_words_published_per_day = get_option('avg_words_published_per_day');


		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'];
			echo esc_html( $instance['title'] );
			echo $args['after_title'];
		}
?>

	<div class="indefiniteloop-stats">

	    <p>
	        <span><strong><?php echo $total_no_of_words_in_blog; ?></strong> Words in all published posts.</span>
	        <span><strong><?php echo $no_of_days_since_first_post; ?></strong> Days since the first post was published.</span>
	        <span><strong><?php echo $total_no_posts_since_start; ?></strong> Posts published here, so far.</span>
	        <span><strong><?php echo $avg_words_published_per_day; ?></strong> Avg words written per post.</span>



	    </p>
	</div>

<?php
		echo $args['after_widget'];
	}
}

function statistics_register_widgets() {
	register_widget( 'Statistics_Widget' );
}

add_action( 'widgets_init', 'statistics_register_widgets' );
