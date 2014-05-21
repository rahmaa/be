<?php
/**
 * Ultimate Social Deux.
 *
 * @package		Ultimate Social Deux
 * @author		Ultimate Wordpress <hello@ultimate-wp.com>
 * @link		http://social.ultimate-wp.com
 * @copyright 	2013 Ultimate Wordpress
 */

class UltimateSocialDeuxAdmin {

	private $settings_api;

	/**
	 * Instance of this class.
	 *
	 * @since	1.0.0
	 *
	 * @var		object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since	1.0.0
	 *
	 * @var		string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since	 1.0.0
	 */
	private function __construct() {

		$plugin = UltimateSocialDeux::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_slug . '.php' );

		$this->settings_api = new WeDevs_Settings_API;

		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_action( 'admin_init', array( $this, 'admin_init' ) );

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
	 * Loading settings page and menu.
	 *
	 * @since	 1.0.0
	 */
	public function admin_init() {

		$this->settings_api->set_sections( $this->get_settings_sections() );
		$this->settings_api->set_fields( $this->get_settings_fields() );

		$this->settings_api->admin_init();
	}

	/**
	 * Loading admin menu.
	 *
	 * @since	 1.0.0
	 */
	public function admin_menu() {
		add_options_page( 'Ultimate Social Deux', 'Ultimate Social Deux', 'delete_posts', 'ultimate_social_deux', array($this, 'settings_page') );
	}

	/**
	 * Creating admin menu wrapper.
	 *
	 * @since	 1.0.0
	 */
	public function settings_page() {

		echo '<div class="wrap ultimate-social-settings">';

		$this->settings_api->show_navigation();
		$this->settings_api->show_forms();

		echo '</div>';
	}

	/**
	 * Creating settings tabs.
	 *
	 * @since	 1.0.0
	 */
	public function get_settings_sections() {
		$sections = array(
			array(
				'id' => 'us_basic',
				'title' => __( 'Basic Settings', 'ultimate-social-deux' )
			),
			array(
				'id' => 'us_styling',
				'title' => __( 'Style Settings', 'ultimate-social-deux' )
			),
			array(
				'id' => 'us_mail',
				'title' => __( 'Mail Settings', 'ultimate-social-deux' )
			),
			array(
				'id' => 'us_placement',
				'title' => __( 'Placement Settings', 'ultimate-social-deux' )
			),
			array(
				'id' => 'us_advanced',
				'title' => __( 'Advanced Settings', 'ultimate-social-deux' )
			),
		);

		return $sections;
	}

	/**
	 * Creating individual settings.
	 *
	 * @since	 1.0.0
	 */
	public function get_settings_fields() {

		$facebook = __('Facebook','ultimate-social-deux');
		$twitter = __('Twitter','ultimate-social-deux');
		$google = __('Google Plus','ultimate-social-deux');
		$pinterest = __('Pinterest','ultimate-social-deux');
		$linkedin = __('LinkedIn','ultimate-social-deux');
		$stumble = __('StumbleUpon','ultimate-social-deux');
		$delicious = __('Delicious','ultimate-social-deux');
		$buffer = __('Buffer','ultimate-social-deux');
		$mail = __('Mail','ultimate-social-deux');

		$fields = array(
			'us_basic' => array(
				array(
					'name' => 'us_tweet_via',
					'label' => __( 'Tweet via: @', 'ultimate-social-deux' ),
					'desc' => __( 'Write your Twitter username here to be mentioned in visitors tweets', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_pinterest_default',
					'label' => __( 'Default Pinterest Image', 'ultimate-social-deux' ),
					'desc' => __( 'Image that is passed if a post have no images', 'ultimate-social-deux' ),
					'type' => 'file',
					'default' => plugins_url( $this->plugin_slug . '/public/assets/img/ultimate_social.png' ),
				),
				array(
					'name' => 'us_total_shares_text',
					'label' => __( 'Total Shares Button Text', 'ultimate-social-deux' ),
					'desc' => __( 'The text you want for the total shares button', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => __( 'Total Shares', 'ultimate-social-deux' ),
				),
			),
			'us_styling' => array(
				array(
					'name' => 'us_hover_color',
					'label' => __( 'Hover Color', 'ultimate-social-deux' ),
					'desc' => __( 'When hovering over a button the button changes to this color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#008000',
				),
				array(
					'name' => 'us_facebook_color',
					'label' => __( 'Facebook Color', 'ultimate-social-deux' ),
					'desc' => __( 'Facebook button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#3b5998',
				),
				array(
					'name' => 'us_twitter_color',
					'label' => __( 'Twitter Color', 'ultimate-social-deux' ),
					'desc' => __( 'Twitter button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#00ABF0',
				),
				array(
					'name' => 'us_googleplus_color',
					'label' => __( 'Google Plus Color', 'ultimate-social-deux' ),
					'desc' => __( 'Google Plus button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#D95232',
				),
				array(
					'name' => 'us_linkedin_color',
					'label' => __( 'LinkedIn Color', 'ultimate-social-deux' ),
					'desc' => __( 'LinkedIn button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#1C86BC',
				),
				array(
					'name' => 'us_delicious_color',
					'label' => __( 'Delicious Color', 'ultimate-social-deux' ),
					'desc' => __( 'Delicious button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#66B2FD',
				),
				array(
					'name' => 'us_stumble_color',
					'label' => __( 'Stumble Color', 'ultimate-social-deux' ),
					'desc' => __( 'Stumble button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#E94B24',
				),
				array(
					'name' => 'us_buffer_color',
					'label' => __( 'Buffer Color', 'ultimate-social-deux' ),
					'desc' => __( 'Buffer button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#000000',
				),
				array(
					'name' => 'us_mail_color',
					'label' => __( 'Mail Color', 'ultimate-social-deux' ),
					'desc' => __( 'Mail button color', 'ultimate-social-deux' ),
					'type' => 'color',
					'default' => '#666666',
				),
			),
			'us_mail' => array(
				array(
					'name' => 'us_mail_from_email',
					'label' => __( 'Mail From:', 'ultimate-social-deux' ),
					'desc' => __( 'Email address that mail form will email from', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => get_bloginfo('admin_email'),
				),
				array(
					'name' => 'us_mail_from_name',
					'label' => __( 'Mail From Name:', 'ultimate-social-deux' ),
					'desc' => __( 'Name that mail form will email with', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => get_bloginfo('name'),
				),
				array(
					'name' => 'us_mail_subject',
					'label' => __( 'Mail Subject:', 'ultimate-social-deux' ),
					'desc' => __( 'Subject of email.<br>Available tags is: <br>{post_title} -> Outputs title of the post or page<br>{post_url} -> Outputs url of the post or page<br>{post_author} -> Outputs the author of the post or page<br>{site_title} -> Outputs the title of the Wordpress Install<br>{site_url} -> Outputs the url of the Wordpress Install', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => __('A visitor of {site_title} shared {post_title} with you.','ultimate-social-deux'),
				),
				array(
					'name' => 'us_mail_body',
					'label' => __( 'Mail Message:', 'ultimate-social-deux' ),
					'desc' => __( 'Body of email. Available tags is: <br>{post_title} -> Outputs title of the post or page<br>{post_url} -> Outputs url of the post or page<br>{post_author} -> Outputs the author of the post or page<br>{site_title} -> Outputs the title of the Wordpress Install<br>{site_url} -> Outputs the url of the Wordpress Install', 'ultimate-social-deux' ),
					'type' => 'textarea',
					'default' => __('I read this article and found it very interesting, thought it might be something for you. The article is called {post_title} and is located at {post_url}.','ultimate-social-deux'),
				),
				array(
					'name' => 'us_mail_bcc_enable',
					'label' => __( 'Send copy to admin?', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'no',
					'options' => array(
						'yes' => __( 'Yes', 'ultimate-social-deux' ),
						'no' => __( 'No', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_mail_captcha_enable',
					'label' => __( 'Enable Captcha?', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'yes',
					'options' => array(
						'yes' => __( 'Yes', 'ultimate-social-deux' ),
						'no' => __( 'No', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_mail_captcha_question',
					'label' => __( 'Captcha Question', 'ultimate-social-deux' ),
					'desc' => __( 'Your captcha question', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => __( 'What is the sum of 7 and 2?', 'ultimate-social-deux' ),
				),
				array(
					'name' => 'us_mail_captcha_answer',
					'label' => __( 'Captcha Answer', 'ultimate-social-deux' ),
					'desc' => __( 'Your captcha answer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => __( '9', 'ultimate-social-deux' ),
				),
				array(
					'name' => 'us_mail_success',
					'label' => __( 'Success message', 'ultimate-social-deux' ),
					'desc' => __( 'For successful sent email', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => __( 'Great work! Your message was sent.', 'ultimate-social-deux' ),
				),

			),
			'us_placement' => array(
				array(
					'name' => 'us_floating',
					'label' => '<h2>'.__( 'Floating', 'ultimate-social-deux' ).'</h2>',
					'type' => 'multicheck',
					'options' => array(
						'facebook' => $facebook,
						'twitter' => $twitter,
						'googleplus' => $google,
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'mail' => $mail,
						'hide_frontpage' => __( 'Hide on frontpage?', 'ultimate-social-deux' ),
					)
				),
				array(
					'name' => 'us_floating_url',
					'label' => __( 'Custom URL', 'ultimate-social-deux' ),
					'desc' => __( 'You might want a static URL for your floating buttons across your site.', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_floating_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Floating buttons on posts/pages with these IDs? Comma seperated: "42, 12, 4"', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_pages_top',
					'label' => '<h2>'.__( 'Top of Pages', 'ultimate-social-deux' ).'</h2>',
					'type' => 'multicheck',
					'options' => array(
						'facebook' => $facebook,
						'twitter' => $twitter,
						'googleplus' => $google,
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'mail' => $mail,
					)
				),
				array(
					'name' => 'us_pages_top_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_pages_top_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on top of pages with these IDs? Comma seperated: "42, 12, 4"', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_pages_top_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_pages_bottom',
					'label' => '<h2>'.__( 'Bottom of Pages', 'ultimate-social-deux' ).'</h2>',
					'type' => 'multicheck',
					'options' => array(
						'facebook' => $facebook,
						'twitter' => $twitter,
						'googleplus' => $google,
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'mail' => $mail,
					)
				),
				array(
					'name' => 'us_pages_bottom_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_pages_bottom_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on bottom of pages with these IDs? Comma seperated: "42, 12, 4"', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_pages_bottom_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_posts_top',
					'label' => '<h2>'.__( 'Top of Posts', 'ultimate-social-deux' ).'</h2>',
					'type' => 'multicheck',
					'options' => array(
						'facebook' => $facebook,
						'twitter' => $twitter,
						'googleplus' => $google,
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'mail' => $mail,
					)
				),
				array(
					'name' => 'us_posts_top_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_posts_top_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on top of posts with these IDs? Comma seperated: "42, 12, 4"', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_pposts_top_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_posts_bottom',
					'label' => '<h2>'.__( 'Bottom of Posts', 'ultimate-social-deux' ).'</h2>',
					'type' => 'multicheck',
					'options' => array(
						'facebook' => $facebook,
						'twitter' => $twitter,
						'googleplus' => $google,
						'pinterest' => $pinterest,
						'linkedin' => $linkedin,
						'stumble' => $stumble,
						'delicious' => $delicious,
						'buffer' => $buffer,
						'mail' => $mail,
					)
				),
				array(
					'name' => 'us_posts_bottom_align',
					'label' => __( 'Align', 'ultimate-social-deux' ),
					'type' => 'radio',
					'default' => 'center',
					'options' => array(
						'left' => __( 'Left', 'ultimate-social-deux' ),
						'center' => __( 'Center', 'ultimate-social-deux' ),
						'right' => __( 'Right', 'ultimate-social-deux' )
					)
				),
				array(
					'name' => 'us_posts_bottom_exclude',
					'label' => __( 'Exclude', 'ultimate-social-deux' ),
					'desc' => __( 'Exclude Buttons on bottom of posts with these IDs? Comma seperated: "42, 12, 4"', 'ultimate-social-deux' ),
					'type' => 'text',
				),
				array(
					'name' => 'us_posts_bottom_share_text',
					'label' => __( 'Share text', 'ultimate-social-deux' ),
					'desc' => __( 'Text to be added left of the buttons', 'ultimate-social-deux' ),
					'type' => 'text',
				),
			),
			'us_advanced' => array(
				array(
					'name' => 'us_facebook_height',
					'label' => __( 'Facebook Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'This value has to be an integer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '500',
				),
				array(
					'name' => 'us_facebook_width',
					'label' => __( 'Facebook Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'This value has to be an integer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '900',
				),
				array(
					'name' => 'us_twitter_height',
					'label' => __( 'Twitter Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'This value has to be an integer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '500',
				),
				array(
					'name' => 'us_twitter_width',
					'label' => __( 'Twitter Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'This value has to be an integer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '900',
				),
				array(
					'name' => 'us_googleplus_height',
					'label' => __( 'GooglePlus Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'This value has to be an integer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '500',
				),
				array(
					'name' => 'us_googleplus_width',
					'label' => __( 'Google Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'This value has to be an integer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '900',
				),
				array(
					'name' => 'us_delicious_height',
					'label' => __( 'Delicious Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'This value has to be an integer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '550',
				),
				array(
					'name' => 'us_delicious_width',
					'label' => __( 'Delicious Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'This value has to be an integer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '550',
				),
				array(
					'name' => 'us_stumble_height',
					'label' => __( 'StumbleUpon Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'This value has to be an integer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '550',
				),
				array(
					'name' => 'us_stumble_width',
					'label' => __( 'StumbleUpon Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'This value has to be an integer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '550',
				),
				array(
					'name' => 'us_linkedin_height',
					'label' => __( 'LinkedIn Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'This value has to be an integer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '550',
				),
				array(
					'name' => 'us_linkedin_width',
					'label' => __( 'LinkedIn Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'This value has to be an integer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '550',
				),
				array(
					'name' => 'us_pinterest_height',
					'label' => __( 'Pinterest Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'This value has to be an integer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '320',
				),
				array(
					'name' => 'us_pinterest_width',
					'label' => __( 'Pinterest Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'This value has to be an integer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '720',
				),
				array(
					'name' => 'us_buffer_height',
					'label' => __( 'Buffer Popup Height', 'ultimate-social-deux' ),
					'desc' => __( 'This value has to be an integer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '500',
				),
				array(
					'name' => 'us_buffer_width',
					'label' => __( 'Buffer Popup Width', 'ultimate-social-deux' ),
					'desc' => __( 'This value has to be an integer', 'ultimate-social-deux' ),
					'type' => 'text',
					'default' => '900',
				),
			),
		);

		return $fields;
	}

}