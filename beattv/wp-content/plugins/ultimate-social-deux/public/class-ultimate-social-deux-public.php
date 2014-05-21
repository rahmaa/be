<?php
/**
 * Ultimate Social Deux.
 *
 * @package		Ultimate Social Deux
 * @author		Ultimate Wordpress <hello@ultimate-wp.com>
 * @link		http://social.ultimate-wp.com
 * @copyright 	2013 Ultimate Wordpress
 */

class UltimateSocialDeux {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since	1.0.0
	 *
	 * @var	 string
	 */
	const VERSION = '1.0.0';

	/**
	 *
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since	1.0.0
	 *
	 * @var		string
	 */
	protected $plugin_slug = 'ultimate-social-deux';

	/**
	 * Instance of this class.
	 *
	 * @since	1.0.0
	 *
	 * @var		object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since	 1.0.0
	 */
	private function __construct() {

		add_action( 'init', array( $this, 'load_textdomain' ) );

		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );

		add_action( 'wp_ajax_nopriv_us_send_mail', array( $this, 'us_send_mail' ) );

		add_action( 'wp_ajax_us_send_mail', array( $this, 'us_send_mail' ) );

		add_filter( 'the_content', array( $this, 'buttons_pages_bottom') );

		add_filter( 'the_content', array( $this, 'buttons_pages_top') );

		add_filter( 'the_content', array( $this, 'buttons_posts_bottom') );

		add_filter( 'the_content', array( $this, 'buttons_posts_top') );

		add_action( 'wp_footer', array( $this, 'buttons_floating' ) );

	}

	/**
	* Register and enqueue public-facing style sheet.
	*
	* @since	1.0.0
	*/
	public function register_styles() {
		wp_register_style( 'us-plugin-styles', plugins_url( 'assets/css/style.css', __FILE__ ), array(), self::VERSION );
	}

	/**
	* Register and enqueues public-facing JavaScript files.
	*
	* @since	1.0.0
	*/
	public function register_scripts() {

		$tweet_via = ( self::opt('us_tweet_via', 'us_basic') ) ? self::opt('us_tweet_via', 'us_basic'): '';
		$success = ( self::opt('us_mail_success', 'us_mail') ) ? self::opt('us_mail_sucess', 'us_mail'): __('Great work! Your message was sent.', 'ultimate-social-deux' );

		$facebook_height = ( self::opt('us_facebook_height', 'us_advanced') ) ? self::opt('us_facebook_height', 'us_advanced'): '500';
		$facebook_width = ( self::opt('us_facebook_width', 'us_advanced') ) ? self::opt('us_facebook_width', 'us_advanced'): '900';
		$facebook_color = ( self::opt('us_facebook_color', 'us_styling') ) ? self::opt('us_facebook_color', 'us_styling'): '#3b5998';

		$twitter_height = ( self::opt('us_twitter_height', 'us_advanced') ) ? self::opt('us_twitter_height', 'us_advanced'): '500';
		$twitter_width = ( self::opt('us_twitter_width', 'us_advanced') ) ? self::opt('us_twitter_width', 'us_advanced'): '900';
		$twitter_color = ( self::opt('us_twitter_color', 'us_styling') ) ? self::opt('us_twitter_color', 'us_styling'): '#00ABF0';

		$googleplus_height = ( self::opt('us_googleplus_height', 'us_advanced') ) ? self::opt('us_googleplus_height', 'us_advanced'): '500';
		$googleplus_width = ( self::opt('us_googleplus_width', 'us_advanced') ) ? self::opt('us_googleplus_width', 'us_advanced'): '900';
		$googleplus_color = ( self::opt('us_googleplus_color', 'us_styling') ) ? self::opt('us_googleplus_color', 'us_styling'): '#D95232';

		$delicious_height = ( self::opt('us_delicious_height', 'us_advanced') ) ? self::opt('us_delicious_height', 'us_advanced'): '550';
		$delicious_width = ( self::opt('us_delicious_width', 'us_advanced') ) ? self::opt('us_delicious_width', 'us_advanced'): '550';
		$delicious_color = ( self::opt('us_delicious_color', 'us_styling') ) ? self::opt('us_delicious_color', 'us_styling'): '#66B2FD';

		$stumble_height = ( self::opt('us_stumble_height', 'us_advanced') ) ? self::opt('us_stumble_height', 'us_advanced'): '550';
		$stumble_width = ( self::opt('us_stumble_width', 'us_advanced') ) ? self::opt('us_stumble_width', 'us_advanced'): '550';
		$stumble_color = ( self::opt('us_stumble_color', 'us_styling') ) ? self::opt('us_stumble_color', 'us_styling'): '#E94B24';

		$linkedin_height = ( self::opt('us_linkedin_height', 'us_advanced') ) ? self::opt('us_linkedin_height', 'us_advanced'): '550';
		$linkedin_width = ( self::opt('us_linkedin_width', 'us_advanced') ) ? self::opt('us_linkedin_width', 'us_advanced'): '550';
		$linkedin_color = ( self::opt('us_linkedin_color', 'us_styling') ) ? self::opt('us_linkedin_color', 'us_styling'): '#1C86BC';

		$pinterest_height = ( self::opt('us_pinterest_height', 'us_advanced') ) ? self::opt('us_pinterest_height', 'us_advanced'): '320';
		$pinterest_width = ( self::opt('us_pinterest_width', 'us_advanced') ) ? self::opt('us_pinterest_width', 'us_advanced'): '720';
		$pinterest_color = ( self::opt('us_pinterest_color', 'us_styling') ) ? self::opt('us_pinterest_color', 'us_styling'): '#AE181F';

		$buffer_height = ( self::opt('us_buffer_height', 'us_advanced') ) ? self::opt('us_buffer_height', 'us_advanced'): '500';
		$buffer_width = ( self::opt('us_buffer_width', 'us_advanced') ) ? self::opt('us_buffer_width', 'us_advanced'): '900';
		$buffer_color = ( self::opt('us_buffer_color', 'us_styling') ) ? self::opt('us_buffer_color', 'us_styling'): '#000000';

		$mail_color = ( self::opt('us_mail_color', 'us_styling') ) ? self::opt('us_mail_color', 'us_styling'): '#666666';

		$hover_color = ( self::opt('us_hover_color', 'us_styling') ) ? self::opt('us_hover_color', 'us_styling'): '#008000';

		$total_shares_text = ( self::opt('us_total_shares_text', 'us_basic') ) ? self::opt('us_total_shares_text', 'us_basic'): __( 'Total Shares', 'ultimate-social-deux' );

		wp_register_script( 'us-sharrre', plugins_url( 'assets/js/jquery.sharrre-ck.js',__FILE__ ), array('jquery'), self::VERSION );
		wp_localize_script( 'us-sharrre', 'us_sharrre',
			array(
				'facebook_height' => $facebook_height,
				'facebook_width' => $facebook_width,
				'twitter_height' => $twitter_height,
				'twitter_width' => $twitter_width,
				'googleplus_height' => $googleplus_height,
				'googleplus_width' => $googleplus_width,
				'delicious_height' => $delicious_height,
				'delicious_width' => $delicious_width,
				'stumble_height' => $stumble_height,
				'stumble_width' => $stumble_width,
				'linkedin_height' => $linkedin_height,
				'linkedin_width' => $linkedin_width,
				'pinterest_height' => $pinterest_height,
				'pinterest_width' => $pinterest_width,
				'buffer_height' => $buffer_height,
				'buffer_width' => $buffer_width
			)
		);

		wp_register_script( 'us-jquery-magnific-popup', plugins_url( 'assets/js/jquery.magnific-popup.js',__FILE__ ), array(), self::VERSION );

		wp_register_script( 'us-script', plugins_url( 'assets/js/script-ck.js',__FILE__ ), array('jquery', 'jquery-color'), self::VERSION );
		wp_localize_script( 'us-script', 'us_script',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'tweet_via' => $tweet_via,
				'sharrre_url' => plugins_url( 'assets/js/sharrre.php', __FILE__ ),
				'success' => $success,
				'facebook_color' => $facebook_color,
				'twitter_color' => $twitter_color,
				'googleplus_color' => $googleplus_color,
				'delicious_color' => $delicious_color,
				'stumble_color' => $stumble_color,
				'linkedin_color' => $linkedin_color,
				'pinterest_color' => $pinterest_color,
				'buffer_color' => $buffer_color,
				'mail_color' => $mail_color,
				'hover_color' => $hover_color,
				'total_shares_text' => $total_shares_text
			)
		);

	}

	/**
	* Enqueues public-facing JavaScript and CSS files.
	*
	* @since	1.0.0
	*/
	public function enqueue_stuff() {

		wp_enqueue_style( 'us-plugin-styles' );

		wp_enqueue_script( 'us-sharrre' );

		wp_enqueue_script( 'us-jquery-magnific-popup' );

		wp_enqueue_script( 'us-script' );

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since	1.0.0
	 *
	 * @return	Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since	 1.0.0
	 *
	 * @return	object	A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since	1.0.0
	 */
	public function load_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );

	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since	1.0.0
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses
	 *										"Network Activate" action, false if
	 *										WPMU is disabled or plugin is
	 *										activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

			if ( function_exists( 'is_multisite' ) && is_multisite() ) {

					if ( $network_wide	) {

							// Get all blog ids
							$blog_ids = self::get_blog_ids();

							foreach ( $blog_ids as $blog_id ) {

									switch_to_blog( $blog_id );
									self::single_activate();
							}

							restore_current_blog();

					} else {
							self::single_activate();
					}

			} else {
					self::single_activate();
			}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since	1.0.0
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses
	 *										"Network Deactivate" action, false if
	 *										WPMU is disabled or plugin is
	 *										deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

			if ( function_exists( 'is_multisite' ) && is_multisite() ) {

					if ( $network_wide ) {

							// Get all blog ids
							$blog_ids = self::get_blog_ids();

							foreach ( $blog_ids as $blog_id ) {

									switch_to_blog( $blog_id );
									self::single_deactivate();

							}

							restore_current_blog();

					} else {
							self::single_deactivate();
					}

			} else {
					self::single_deactivate();
			}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since	1.0.0
	 *
	 * @param	int	$blog_id	ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

			if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
					return;
			}

			switch_to_blog( $blog_id );
			self::single_activate();
			restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since	1.0.0
	 *
	 * @return	array|false	The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

			global $wpdb;

			// get an array of blog ids
			$sql = "SELECT blog_id FROM $wpdb->blogs
					WHERE archived = '0' AND spam = '0'
					AND deleted = '0'";

			return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since	1.0.0
	 */
	private static function single_activate() {

	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since	1.0.0
	 */
	private static function single_deactivate() {

	}

	public function opt( $option, $section, $default = '' ) {

		$options = get_option( $section );

		if ( isset( $options[$option] ) ) {
			return $options[$option];
		}

		return $default;
	}

	/**
	 * Replace strings for mail options
	 *
	 * @since	1.0.0
	 *
	 * @return	Replaced string
	 */
	public function mail_replace_vars( $string, $url ) {

		if ( in_the_loop() || is_singular() ) {
			$post_title = get_the_title();
			$post_url = get_permalink();

			global $post;
			$post = get_post();
			$author_id=$post->post_author;
			$user_info = get_userdata($author_id);
			$post_author = $user_info->user_nicename;
		} elseif ( is_home() ) {
			$post_title = get_bloginfo('name');
			$post_url = get_bloginfo('url');
			$post_author = get_bloginfo('name');
		} else {
			$post_title = get_bloginfo('name');
			$post_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$post_author = get_bloginfo('name');
		}

		if ($url) {
			$post_url = $url;
		}

		$site_title = get_bloginfo('name');
		$site_url = get_bloginfo('url');

		$string = str_replace('{post_title}', $post_title, $string);
		$string = str_replace('{post_url}', $post_url, $string);
		$string = str_replace('{post_author}', $post_author, $string);
		$string = str_replace('{site_title}', $site_title, $string);
		$string = str_replace('{site_url}', $site_url, $string);

		return $string;
	}

	/**
	 * Returns first image of a post or page. If no images found it returns default image.
	 *
	 * @since	1.0.0
	 *
	 * @return	post image
	 */
	public function catch_first_image() {
		global $post, $posts;
		$first_img = '';
		ob_start();
		ob_end_clean();
		if ( is_singular( ) ) {
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

			if ( has_post_thumbnail( $post->ID ) ) {
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				$url = $thumb['0'];

				$first_img = $url;
			} elseif (isset($matches[1][0])) {
				$first_img = $matches [1] [0];
			} else {
				$first_img = ( self::opt('us_pinterest_default', 'us_basic') ) ? self::opt('us_pinterest_default', 'us_basic'): plugins_url( 'ultimate-social-deux/public/assets/img/ultimate_social.png' );
			}
		} else {
			$first_img = ( self::opt('us_pinterest_default', 'us_basic') ) ? self::opt('us_pinterest_default', 'us_basic'): plugins_url( 'ultimate-social-deux/public/assets/img/ultimate_social.png' );
		}

		return $first_img;
	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function buttons_posts_top ($content) {

		global $post;

		$sharetext = ( self::opt('us_posts_top_share_text', 'us_placement') ) ? self::opt('us_posts_top_share_text', 'us_placement') : '';

		$button = self::opt('us_posts_top', 'us_placement');

		$facebook = isset( $button['facebook'] ) ? true : '';

		$twitter = isset( $button['twitter'] ) ? true : '';

		$googleplus = isset( $button['googleplus'] ) ? true: '';

		$pinterest = isset( $button['pinterest'] ) ? true : '';

		$linkedin = isset( $button['linkedin'] ) ? true : '';

		$stumble = isset( $button['stumble'] ) ? true : '';

		$delicious = isset( $button['delicious'] ) ? true : '';

		$buffer = isset( $button['buffer'] ) ? true : '';

		$mail = isset( $button['mail'] ) ? true : '';

		$url = '';

		$exclude = ( self::opt('us_posts_top_exclude', 'us_placement') ) ? array( self::opt('us_posts_top_exclude', 'us_placement') ): array();

		$align = ( self::opt('us_posts_top_align', 'us_placement') ) ? self::opt('us_posts_top_align', 'us_placement'): 'center';

		$custom_content = '';

		if( !in_array($post->ID, $exclude, false) && is_single() && !is_page() && !is_attachment() && ( $facebook || $twitter || $googleplus || $pinterest || $linkedin || $stumble || $delicious || $buffer || $mail ) ) {

				$custom_content .= '<div class="us_posts_top">';

					$custom_content .= self::buttons($sharetext, false, $facebook, $twitter, $googleplus, $pinterest, $linkedin, $stumble, $delicious, $buffer, $mail, $url, $align, '');

				$custom_content .= '</div>';

				$custom_content .= $content;

				return $custom_content;

		} else {
			return $content;
		}
	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function buttons_posts_bottom( $content ) {

		global $post;

		$sharetext = ( self::opt('us_posts_top_share_text', 'us_placement') ) ? self::opt('us_posts_top_share_text', 'us_placement') : '';

		$button = self::opt('us_posts_bottom', 'us_placement');

		$facebook = isset( $button['facebook'] ) ? true : '';

		$twitter = isset( $button['twitter'] ) ? true : '';

		$googleplus = isset( $button['googleplus'] ) ?	true: '';

		$pinterest = isset( $button['pinterest'] ) ? true : '';

		$linkedin = isset( $button['linkedin'] ) ? true : '';

		$stumble = isset( $button['stumble'] ) ? true : '';

		$delicious = isset( $button['delicious'] ) ? true : '';

		$buffer = isset( $button['buffer'] ) ? true : '';

		$mail = isset( $button['mail'] ) ? true : '';

		$url = '';

		$exclude = ( self::opt('us_posts_bottom_exclude', 'us_placement') ) ? array( self::opt('us_posts_bottom_exclude', 'us_placement') ): array();

		$align = ( self::opt('us_posts_bottom_align', 'us_placement') ) ? self::opt('us_posts_bottom_align', 'us_placement'): 'center';

		$custom_content = '';

		if( !in_array($post->ID, $exclude, false) && is_single() && !is_page() && !is_attachment() && ( $facebook || $twitter || $googleplus || $pinterest || $linkedin || $stumble || $delicious || $mail ) ) {

				$custom_content .= $content;

				$custom_content .= '<div class="us_posts_bottom">';

					$custom_content .= self::buttons($sharetext, false, $facebook, $twitter, $googleplus, $pinterest, $linkedin, $stumble, $delicious, $buffer, $mail, $url, $align, '');

				$custom_content .= '</div>';

				return $custom_content;

		} else {
			return $content;
		}
	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function buttons_pages_bottom( $content ) {

		global $post;

		$sharetext = ( self::opt('us_pages_bottom_share_text', 'us_placement') ) ? self::opt('us_pages_bottom_share_text', 'us_placement') : '';

		$button = self::opt('us_pages_bottom', 'us_placement');

		$facebook = isset( $button['facebook'] ) ? true : '';

		$twitter = isset( $button['twitter'] ) ? true : '';

		$googleplus = isset( $button['googleplus'] ) ?	true: '';

		$pinterest = isset( $button['pinterest'] ) ? true : '';

		$linkedin = isset( $button['linkedin'] ) ? true : '';

		$stumble = isset( $button['stumble'] ) ? true : '';

		$delicious = isset( $button['delicious'] ) ? true : '';

		$buffer = isset( $button['buffer'] ) ? true : '';

		$mail = isset( $button['mail'] ) ? true : '';

		$url = '';

		$exclude = ( self::opt('us_pages_bottom_exclude', 'us_placement') ) ? array( self::opt('us_pages_bottom_exclude', 'us_placement') ): array();

		$align = ( self::opt('us_pages_bottom_align', 'us_placement') ) ? self::opt('us_pages_bottom_align', 'us_placement'): 'center';

		$custom_content = '';

		if( is_page() && !in_array($post->ID, $exclude, false) && ( $facebook || $twitter || $googleplus || $pinterest || $linkedin || $stumble || $delicious || $mail ) ) {

				$custom_content .= $content;

				$custom_content .= '<div class="us_pages_bottom">';

					$custom_content .= self::buttons($sharetext, false, $facebook, $twitter, $googleplus, $pinterest, $linkedin, $stumble, $delicious, $buffer, $mail, $url, $align, '');

				$custom_content .= '</div>';

				return $custom_content;

		} else {
			return $content;
		}
	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function buttons_pages_top ($content) {

		global $post;

		$sharetext = ( self::opt('us_pages_top_share_text', 'us_placement') ) ? self::opt('us_pages_top_share_text', 'us_placement') : '';

		$button = self::opt('us_pages_top', 'us_placement');

		$facebook = isset( $button['facebook'] ) ? true : '';

		$twitter = isset( $button['twitter'] ) ? true : '';

		$googleplus = isset( $button['googleplus'] ) ? true: '';

		$pinterest = isset( $button['pinterest'] ) ? true : '';

		$linkedin = isset( $button['linkedin'] ) ? true : '';

		$stumble = isset( $button['stumble'] ) ? true : '';

		$delicious = isset( $button['delicious'] ) ? true : '';

		$buffer = isset( $button['buffer'] ) ? true : '';

		$mail = isset( $button['mail'] ) ? true : '';

		$url = '';

		$exclude = ( self::opt('us_pages_top_exclude', 'us_placement') ) ? array( self::opt('us_pages_top_exclude', 'us_placement') ): array();

		$align = ( self::opt('us_pages_top_align', 'us_placement') ) ? self::opt('us_pages_top_align', 'us_placement'): 'center';

		$custom_content = '';

		if( is_page() && !in_array($post->ID, $exclude, false) && ( $facebook || $twitter || $googleplus || $pinterest || $linkedin || $stumble || $delicious || $mail ) ) {

				$custom_content .= '<div class="us_pages_top">';

					$custom_content .= self::buttons($sharetext, false, $facebook, $twitter, $googleplus, $pinterest, $linkedin, $stumble, $delicious, $buffer, $mail, $url, $align, '');

				$custom_content .= '</div>';

				$custom_content .= $content;

				return $custom_content;

		} else {
			return $content;
		}

	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function buttons_floating() {

		$button = self::opt('us_floating', 'us_placement');

		$facebook = isset( $button['facebook'] ) ? true : '';

		$twitter = isset( $button['twitter'] ) ? true : '';

		$googleplus = isset( $button['googleplus'] ) ? true: '';

		$pinterest = isset( $button['pinterest'] ) ? true : '';

		$linkedin = isset( $button['linkedin'] ) ? true : '';

		$stumble = isset( $button['stumble'] ) ? true : '';

		$delicious = isset( $button['delicious'] ) ? true : '';

		$buffer = isset( $button['buffer'] ) ? true : '';

		$mail = isset( $button['mail'] ) ? true : '';

		$hide_frontpage = isset( $button['hide_frontpage'] ) ? true : '';

		$url = ( self::opt('us_floating_url', 'us_placement') ) ? self::opt('us_floating_url', 'us_placement'): '';

		$floating = '';

		$exclude = ( self::opt('us_floating_exclude', 'us_placement') ) ? self::opt('us_floating_exclude', 'us_placement'): '';

		if ( $hide_frontpage && is_front_page() ) {
			$floating = '';
		} elseif ( !is_page( array($exclude) ) && !is_single( array($exclude) ) && ( $facebook || $twitter || $googleplus || $pinterest || $linkedin || $stumble || $delicious || $mail ) ) {

			$floating .= '<div class="us_floating">';

					$floating .= self::buttons('', false, $facebook, $twitter, $googleplus, $pinterest, $linkedin, $stumble, $delicious, $buffer, $mail, $url, '', '');

			$floating .= '</div>';
		}

		echo $floating;

	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function buttons($sharetext = '', $total = false, $facebook = false, $twitter = false, $google = false, $pinterest = false, $linkedin = false, $stumble = false , $delicious = false, $buffer = false, $mail = false, $url = '', $align = "center", $media = '') {

		if ( $url ) {
			$url = $url;
			$text = '';
		} elseif ( is_singular() ) {
			$text = get_the_title();
			$url = get_permalink();
		} elseif ( in_the_loop() ) {
			$text = get_the_title();
			$url = get_permalink();
		} elseif ( is_home() ) {
			$text = get_bloginfo('name');
			$url = get_bloginfo('url');
		} elseif ( is_tax() || is_category() ) {
			global $wp_query;
			$term = $wp_query->get_queried_object();
			$text = $term->name;
			$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		} else {
			$text = get_bloginfo('name');
			$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		}

		if ($align == 'left') {
			$align = "tal";
		} elseif ($align == 'right') {
			$align = "tar";
		} else {
			$align = "tac";
		}

		if ($media) {
			$media = $media;
		} else {
			$media = self::catch_first_image();
		}
		$buttons = '';

			$buttons .= sprintf('<div class="us_wrapper %s">', $align);

				if ($sharetext) {
					$buttons .= sprintf('<div class="us_button us_share_text"><span>%s</span></div>', $sharetext);
				}

				if ($total) {
					$buttons .= self::total_button($url, $text);
				}

				if ($facebook) {
					$buttons .= self::facebook_button($url, $text);
				}

				if ($twitter) {
					$buttons .= self::twitter_button($url, $text);
				}

				if ($google) {
					$buttons .= self::google_button($url, $text);
				}

				if ($pinterest) {
					$buttons .= self::pinterest_button($url, $text, $media);
				}

				if ($linkedin) {
					$buttons .= self::linkedin_button($url, $text);
				}

				if ($stumble) {
					$buttons .= self::stumble_button($url, $text);
				}

				if ($delicious) {
					$buttons .= self::delicious_button($url, $text);
				}

				if ($buffer) {
					$buttons .= self::buffer_button($url, $text);
				}

				if ($mail) {
					$buttons .= self::mail_button($url);
				}

			$buttons .= '</div>';

		return $buttons;

	}

	/**
	 * Returns total button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public function total_button($url, $text) {

		self::enqueue_stuff();

		$total_shares_text = ( self::opt('us_total_shares_text', 'us_basic') ) ? self::opt('us_total_shares_text', 'us_basic'): __( 'Total Shares', 'ultimate-social-deux' );

		$button = sprintf('<div class="us_total us_button" data-url="%s" data-text="%s"><a class="us_box" href="#"><div class="us_share">%s</div><div class="us_count" href="#"><i class="us-icon-spin us-icon-spinner"></i></div></a></div>', $url, $text, $total_shares_text);

		return $button;
	}

	/**
	 * Returns Facebook button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public function facebook_button($url, $text) {

		self::enqueue_stuff();

		$background_color = ( self::opt('us_facebook_color', 'us_styling') ) ? self::opt('us_facebook_color', 'us_styling') : '#3b5998';

		$button = sprintf('<div class="us_facebook us_button" style="background-color:%s;" data-url="%s" data-text="%s"><a class="us_box" href="#"><div class="us_share"><i class="us-icon-facebook"></i></div><div class="us_count" href="#"><i class="us-icon-spin us-icon-spinner"></i></div></a></div>', $background_color, $url, $text);

		return $button;
	}

	/**
	 * Returns Twitter button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public function twitter_button($url, $text) {

		self::enqueue_stuff();

		$background_color = ( self::opt('us_twitter_color', 'us_styling') ) ? self::opt('us_twitter_color', 'us_styling') : '#00ABF0';

		$button = sprintf('<div class="us_twitter us_button" style="background-color:%s;" data-url="%s" data-text="%s" ><a class="us_box" href="#"><div class="us_share"><i class="us-icon-twitter"></i></div><div class="us_count" href="#"><i class="us-icon-spin us-icon-spinner"></i></div></a></div>', $background_color, $url, $text);

		return $button;

	}

	/**
	 * Returns Google button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public function google_button($url, $text) {

		self::enqueue_stuff();

		$background_color = ( self::opt('us_googleplus_color', 'us_styling') ) ? self::opt('us_googleplus_color', 'us_styling') : '#D95232';

		$button = sprintf('<div class="us_googleplus us_button" style="background-color:%s;" data-url="%s" data-text="%s" ><a class="us_box" href="#"><div class="us_share"><i class="us-icon-google-plus"></i></div><div class="us_count" href="#"><i class="us-icon-spin us-icon-spinner"></i></div></a></div>', $background_color, $url, $text);

		return $button;

	}

	/**
	 * Returns Pinterest button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public function pinterest_button($url, $text, $media) {

		self::enqueue_stuff();

		$background_color = ( self::opt('us_pinterest_color', 'us_styling') ) ? self::opt('us_pinterest_color', 'us_styling') : '#AE181F';

		$button = sprintf('<div class="us_pinterest us_button" style="background-color:%s;" data-url="%s" data-text="%s" data-media="%s" ><a class="us_box" href="#"><div class="us_share"><i class="us-icon-pinterest"></i></div><div class="us_count" href="#"><i class="us-icon-spin us-icon-spinner"></i></div></a></div>', $background_color, $url, $text, $media);

		return $button;

	}

	/**
	 * Returns Linkedin button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public function linkedin_button($url, $text) {

		self::enqueue_stuff();

		$background_color = ( self::opt('us_linkedin_color', 'us_styling') ) ? self::opt('us_linkedin_color', 'us_styling') : '#1C86BC';

		$button = sprintf('<div class="us_linkedin us_button" style="background-color:%s;" data-url="%s" data-text="%s" ><a class="us_box" href="#"><div class="us_share"><i class="us-icon-linkedin"></i></div><div class="us_count" href="#"><i class="us-icon-spin us-icon-spinner"></i></div></a></div>', $background_color, $url, $text);

		return $button;

	}

	/**
	 * Returns Stumble button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public function stumble_button($url, $text) {

		self::enqueue_stuff();

		$background_color = ( self::opt('us_stumble_color', 'us_styling') ) ? self::opt('us_stumble_color', 'us_styling') : '#E94B24';

		$button = sprintf('<div class="us_stumble us_button" style="background-color:%s;" data-url="%s" data-text="%s" ><a class="us_box" href="#"><div class="us_share"><i class="us-icon-stumbleupon"></i></div><div class="us_count" href="#"><i class="us-icon-spin us-icon-spinner"></i></div></a></div>', $background_color, $url, $text);

		return $button;

	}

	/**
	 * Returns Delicious button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public function delicious_button($url, $text) {

		self::enqueue_stuff();

		$background_color = ( self::opt('us_delicious_color', 'us_styling') ) ? self::opt('us_delicious_color', 'us_styling') : '#66B2FD';

		$button = sprintf('<div class="us_delicious us_button" style="background-color:%s;" data-url="%s" data-text="%s" ><a class="us_box" href="#"><div class="us_share"><i class="us-icon-delicious"></i></div><div class="us_count" href="#"><i class="us-icon-spin us-icon-spinner"></i></div></a></div>', $background_color, $url, $text );

		return $button;

	}

	/**
	 * Returns Buffer button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public function buffer_button($url, $text) {

		self::enqueue_stuff();

		$background_color = ( self::opt('us_buffer_color', 'us_styling') ) ? self::opt('us_buffer_color', 'us_styling') : '#000000';

		$button = sprintf('<div class="us_buffer us_button" style="background-color:%s;" data-url="%s" data-text="%s" ><a class="us_box" href="#"><div class="us_share"><i class="us-icon-buffer"></i></div><div class="us_count" href="#"><i class="us-icon-spin us-icon-spinner"></i></div></a></div>', $background_color, $url, $text );

		return $button;

	}

	/**
	 * Returns Mail button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public function mail_button($url) {

		self::enqueue_stuff();

		$background_color = ( self::opt('us_mail_color', 'us_styling') ) ? self::opt('us_mail_color', 'us_styling') : '#666666';

		$to = ( self::opt('us_mail_to', 'us_mail') ) ? self::opt('us_mail_to', 'us_mail') : 'Recipient Email';
		$body = ( self::opt('us_mail_body', 'us_mail') ) ? self::mail_replace_vars( self::opt('us_mail_body', 'us_mail'), $url ) : self::mail_replace_vars( __('I read this article and found it very interesting, thought it might be something for you. The article is called {post_title} and is located at {post_url}.','ultimate-social-deux'), $url );

		$captcha_enable	= ( self::opt('us_mail_captcha_enable', 'us_mail') ) ? self::opt('us_mail_captcha_enable', 'us_mail') : 'yes';
		$captcha = ( self::opt('us_mail_captcha_question', 'us_mail') ) ? stripslashes( self::opt('us_mail_captcha_question', 'us_mail') ) : __('What is the sum of 7 and 2?','ultimate-social-deux');

		$random_string = self::random_string(5);

		$us_share = __('Share with your friends','ultimate-social-deux');
		$your_name = __('Your Name','ultimate-social-deux');
		$your_email = __('Your Email','ultimate-social-deux');
		$recipient_email = __('Recipient Email','ultimate-social-deux');
		$your_message = __('Enter a Message','ultimate-social-deux');
		$captcha_label = __('Captcha','ultimate-social-deux');

			$button = sprintf('<div class="us_wrapper us_modal mfp-hide" id="us_modal_%s">', $random_string);
				$button .= '<div class="us_heading">';
					$button .= $us_share;
				$button .= '</div>';
				$button .= '<div class="us_mail_response"></div>';
				$button .= '<div class="us_mail_form_holder">';
					$button .= '<form role="form" id="ajaxcontactform" class="form-group contact" action="" method="post" enctype="multipart/form-data">';
						$button .= '<div class="form-group">';
							$button .= sprintf('<label class="label" for="ajaxcontactyour_name">%s</label><br>', $your_name );
							$button .= sprintf('<input type="text" id="ajaxcontactyour_name" class="form-control border-us_box us_mail_your_name" name="%s" placeholder="%s"><br>', $your_name, $your_name );
							$button .= sprintf('<label class="label" for="ajaxcontactyour_email">%s</label><br>', $your_email );
							$button .= sprintf('<input type="email" id="ajaxcontactyour_email" class="form-control border-us_box us_mail_your_email" name="%s" placeholder="%s"><br>', $your_email, $your_email );
							$button .= sprintf('<label class="label" for="ajaxcontactrecipient_email">%s</label><br>', $recipient_email );
							$button .= sprintf('<input type="email" id="ajaxcontactrecipient_email" class="form-control border-us_box us_mail_recipient_email" name="%s" placeholder="%s"><br>', $recipient_email, $recipient_email);
							$button .= sprintf('<label class="label" for="message">%s</label><br>', $your_message);
							$button .= sprintf('<textarea class="form-control border-us_box us_mail_message" id="ajaxcontactmessage" name="%s" placeholder="%s">%s</textarea>', $your_message, $your_message, $body);
						$button .= '</div>';

						if ( $captcha_enable == 'yes' ){
							$button .= '<div class="form-group">';
								$button .= sprintf('<label class="label" for="ajaxcontactcaptcha">%s</label><br>', $captcha_label);
								$button .= sprintf('<input type="text" id="ajaxcontactcaptcha" class="form-control border-us_box us_mail_captcha" name="%s" placeholder="%s"><br>', $captcha_label, $captcha);
							$button .= '</div>';
						}
					$button .= '</form>';
					$button .= '<a class="btn btn-success us_mail_send">Submit</a>';
				$button .= '</div>';
			$button .= '</div>';

			$button .= sprintf('<div href="#us_modal_%s" class="us_mail us_button" style="background-color:%s;"><div class="us_box"><i class="us-icon-mail"></i></div></div>', $random_string, $background_color );

			return $button;
	}

	/**
	 * Ajax function to send mail.
	 *
	 * @since	1.0.0
	 */
	public function us_send_mail(){

		$your_name		= ( $_POST['your_name'] ) ? $_POST['your_name']: '';
		$your_email		= ( $_POST['your_email'] ) ? $_POST['your_email']: '';
		$recipient_email = ( $_POST['recipient_email'] ) ? $_POST['recipient_email']: '';
		$subject		= ( self::opt('us_mail_subject', 'us_mail') ) ? self::mail_replace_vars( self::opt('us_mail_subject', 'us_mail'), $url ) : self::mail_replace_vars( __('A visitor of {site_title} shared {post_title} with you.','ultimate-social-deux'), $url );
		$message		= ( $_POST['message'] ) ? $_POST['message']: '';
		$captcha		= ( $_POST['captcha'] ) ? $_POST['captcha']: '';
		$captcha_answer	= ( self::opt('us_mail_captcha_answer', 'us_mail') ) ? self::opt('us_mail_captcha_answer', 'us_mail') : '9';
		$captcha_enable	= ( self::opt('us_mail_captcha_enable', 'us_mail') ) ? self::opt('us_mail_captcha_enable', 'us_mail') : 'yes';

		$admin_email	= get_bloginfo('admin_email');
		$from_email		= ( self::opt('us_mail_from_email', 'us_mail') ) ? self::opt('us_mail_from_email', 'us_mail') : $admin_email;
		$from_name		= ( self::opt('us_mail_from_name', 'us_mail') ) ? self::opt('us_mail_from_name', 'us_mail') : get_bloginfo('name');
		$admin_copy		= ( self::opt('us_mail_bcc_enable', 'us_mail') ) ? self::opt('us_mail_bcc_enable', 'us_mail') : 'yes';

		if ( $captcha_enable == 'yes' ){
			if( '' == $captcha )
				die( __( 'Captcha cannot be empty!', 'ultimate-social-deux' ) );
			if( $captcha !== $captcha_answer )
				die( __( 'Captcha does not match.', 'ultimate-social-deux' ) );
		}

		if ( ! filter_var( $recipient_email, FILTER_VALIDATE_EMAIL ) ) {
			die( __( 'Recipient email address is not valid.', 'ultimate-social-deux' ) );
		} elseif ( ! filter_var( $your_email, FILTER_VALIDATE_EMAIL ) ) {
			die( __( 'Your email address is not valid.', 'ultimate-social-deux' ) );
		} elseif( strlen( $your_name ) == 0 ) {
			die( __( 'Your name cannot be empty.', 'ultimate-social-deux' ) );
		} elseif( strlen( $message ) == 0 ) {
			die( __( 'Message cannot be empty.', 'ultimate-social-deux' ) );
		}
		$headers	= array();
		$headers[] = sprintf('From: %s <%s>', $from_name, $from_email );
		$headers[] = sprintf('Reply-To: %s <%s>', $your_name, $your_email );
		if ($admin_copy == 'yes') {
			$headers[] = sprintf('Bcc: %s', $admin_email);
		}


		if( true === ( $result = wp_mail( $recipient_email, $subject, $message, implode("\r\n", $headers) ) ) )
			die( 'ok' );

		if ( ! $result ) {

			global $phpmailer;

			if( isset( $phpmailer->ErrorInfo ) ) {
				die( sprintf( 'Error: %s', $phpmailer->ErrorInfo ) );
			} else {
				die( __( 'Unknown wp_mail() error.', 'ultimate-social-deux' ) );
			}
		}
	}

	/**
	 * Returns random string.
	 *
	 * @since	1.0.0
	 *
	 * @return	random string
	 */
	public function random_string($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

}
