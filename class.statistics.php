<?php

class Statistics {

	const ONE_DAY_IN_SECS = 86400; // One day in seconds

    public static $oldest_post_date = 0; //not perfect but should work for most WordPress setups.
    private static $initiated = false;
    private static $total_number_of_words = 0;
    private static $total_number_of_posts = 0;
    private static $avg_words_per_day = 0;
	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
	}

	/**
	 * Initializes WordPress hooks
	 */
	private static function init_hooks() {
		self::$initiated = true;
		add_option('no_of_days_since_first_post',0);
		add_option('total_no_of_words_in_blog',0);
		add_option('total_no_posts_since_start',0);
		add_option('avg_words_published_per_day',0);
		self::on_posteds();

        add_action('publish_post', array('Statistics','on_posteds'));
        add_action('update_post', array('Statistics','on_posteds'));
        add_action('delete_post', array('Statistics','on_posteds'));

	}

	public static function on_posteds(){

        $all_posts = get_posts('post_status=publish&order=ASC');
        $first_post = $all_posts[0];
        self::$oldest_post_date = $first_post->post_date;
        $datetime1 = date_create(self::$oldest_post_date);
        $datetime2 = new DateTime("now");
        $interval = date_diff($datetime1, $datetime2);
        self::$oldest_post_date = $interval->format('%a');
        self::$total_number_of_posts = count($all_posts);
        foreach($all_posts as $posts){
            if($posts->post_status=="publish"){
                self::$total_number_of_words += str_word_count(strip_tags($posts->post_content));
            }
        }
        self::$avg_words_per_day = self::$total_number_of_words / self::$total_number_of_posts;
        update_option('no_of_days_since_first_post',self::$oldest_post_date);
		update_option('total_no_of_words_in_blog',self::$total_number_of_words);
		update_option('total_no_posts_since_start',self::$total_number_of_posts);
		update_option('avg_words_published_per_day',self::$avg_words_per_day);

	}




}
