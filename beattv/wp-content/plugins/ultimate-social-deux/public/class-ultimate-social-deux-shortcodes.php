<?php
/**
 * Ultimate Social Deux.
 *
 * @package 	Ultimate Social Deux
 * @author		Ultimate Wordpress <hello@ultimate-wp.com>
 * @link		http://social.ultimate-wp.com
 * @copyright 	2013 Ultimate Wordpress
 */

class UltimateSocialDeuxShortcodes {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since	 1.0.0
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

		add_shortcode( 'ultimatesocial', array($this, 'all_buttons' ) );
		add_shortcode( 'ultimatesocial_total', array($this, 'total' ) );
		add_shortcode( 'ultimatesocial_facebook', array($this, 'facebook' ) );
		add_shortcode( 'ultimatesocial_twitter', array($this, 'twitter' ) );
		add_shortcode( 'ultimatesocial_google', array($this, 'google' ) );
		add_shortcode( 'ultimatesocial_pinterest', array($this, 'pinterest' ) );
		add_shortcode( 'ultimatesocial_linkedin', array($this, 'linkedin' ) );
		add_shortcode( 'ultimatesocial_stumble', array($this, 'stumble' ) );
		add_shortcode( 'ultimatesocial_delicious', array($this, 'delicious' ) );
		add_shortcode( 'ultimatesocial_buffer', array($this, 'buffer' ) );
		add_shortcode( 'ultimatesocial_mail', array($this, 'mail' ) );

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
	 * Return shortcode markup for all buttons
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function all_buttons( $atts ) {

		$defaults = array(
			'facebook' => true,
			'twitter' => true,
			'google' => true,
			'pinterest' => true,
			'linkedin' => true,
			'stumble' => true,
			'delicious' => true,
			'buffer' => true,
			'mail' => true,
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'media' => '',
			'share_text' => '',
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		if ( $atts['facebook'] || $atts['twitter'] || $atts['google'] || $atts['pinterest'] || $atts['linkedin'] || $atts['stumble'] || $atts['delicious'] || $atts['mail'] ) {

			$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

				$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], false, $atts['facebook'], $atts['twitter'], $atts['google'], $atts['pinterest'], $atts['linkedin'], $atts['stumble'], $atts['delicious'], $atts['buffer'], $atts['mail'], $atts['url'], $atts['align'], $atts['media'] );

			$shortcode .= '</div>';

		}

		return $shortcode;

	}

	/**
	 * Return shortcode markup for total button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function total( $atts ) {

		$defaults = array(
			'share_text' => '',
			'facebook' => true,
			'twitter' => true,
			'google' => true,
			'pinterest' => true,
			'linkedin' => true,
			'stumble' => true,
			'delicious' => true,
			'buffer' => true,
			'mail' => true,
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'media' => '',
			'share_text' => '',
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode us_total_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], true, $atts['facebook'], $atts['twitter'], $atts['google'], $atts['pinterest'], $atts['linkedin'], $atts['stumble'], $atts['delicious'], $atts['buffer'], $atts['mail'], $atts['url'], $atts['align'], $atts['media'] );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for facebook button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function facebook( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], false, true, false, false, false, false, false, false, false, false, $atts['url'], $atts['align'], '' );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for twitter button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function twitter( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], false, false, true, false, false, false, false, false, false, false, $atts['url'], $atts['align'], '' );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for google button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function google( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], false, false, false, true, false, false, false, false, false, false, $atts['url'], $atts['align'], '' );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for pinterest button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function pinterest( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'media' => '',
			'share_text' => '',
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], false, false, false, false, true, false, false, false, false, false, $atts['url'], $atts['align'], $atts['media'] );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for linkedin button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function linkedin( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], false, false, false, false, false, true, false, false, false, false, $atts['url'], $atts['align'], '' );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for stumble button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function stumble( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], false, false, false, false, false, false, true, false, false, false, $atts['url'], $atts['align'], '' );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for delicious button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function delicious( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], false, false, false, false, false, false, false, true, false, false, $atts['url'], $atts['align'], '' );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for buffer button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function buffer( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], false, false, false, false, false, false, false, false, true, false, $atts['url'], $atts['align'], '' );

		$shortcode .= '</div>';

		return $shortcode;

	}

	/**
	 * Return shortcode markup for mail button
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 shortcode markup
	 */
	public function mail( $atts ) {

		$defaults = array(
			'url' => '',
			'custom_class' => '',
			'align' => 'center',
			'share_text' => '',
		);

		$atts = shortcode_atts($defaults, $atts);

		$shortcode = '';

		$shortcode .= sprintf('<div class="us_shortcode %s">', $atts['custom_class'] );

			$shortcode .= UltimateSocialDeux::buttons($atts['share_text'], false, false, false, false, false, false, false, false, false, true, $atts['url'], $atts['align'], '' );

		$shortcode .= '</div>';

		return $shortcode;

	}

}