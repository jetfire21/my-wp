<?php
/**
 * Setting up Jobify
 *
 * @see https://github.com/astoundify/setup-guide
 * @see https://github.com/astoundify/content-importer
 * @see https://github.com/astoundify/themeforest-updater
 * @see https://github.com/facetwp/use-child-theme
 *
 * @since 3.0.0
 * @package Jobify
 * @category Admin
 */
class Jobify_Setup {

	/**
	 * @var string
	 */
	public static $content_importer_strings;

	/**
	 * Start things up.
	 *
	 * @since 3.0.0
	 *
	 * @return void
	 */
	public static function init() {
		if ( ! is_admin() ) {
			return;
		}

		// UCT self inits so we need to be early
		self::child_theme();

		self::includes();

		self::theme_updater();
		self::content_importer();

		// add this late so we can access plugin information
		add_action( 'tgmpa_register', array( __CLASS__, 'setup_guide' ) );
	}

	public static function includes() {
		include_once( dirname( __FILE__ ) . '/_setup-guide/class-astoundify-setup-guide.php' );
		include_once( dirname( __FILE__ ) . '/_importer/ContentImporter.php' );
		include_once( dirname( __FILE__ ) . '/_updater/class-astoundify-themeforest-updater.php' );
		include_once( dirname( __FILE__ ) . '/_child_theme/use-child-theme.php' );
	}

	/**
	 * Create a child theme.
	 *
	 * @since 3.0.0
	 * @return void
	 */
	public static function child_theme() {
		add_filter( 'uct_functions_php', array( __CLASS__, 'uct_functions_php' ) );
		add_filter( 'uct_admin_notices_screen_id', array( __CLASS__, 'uct_admin_notices_screen_id' ) );
		add_filter( 'astoundify_content_importer_screen', array( __CLASS__, 'uct_admin_notices_screen_id' ) );
	}

	/**
	 * Filter the child theme's functions.php contents.
	 *
	 * @since 3.3.0
	 * @param string $output
	 * @return string $output
	 */
	public static function uct_functions_php( $output ) {
		$output = "<?php
/**
 * Jobify child theme.
 */
function jobify_child_styles() {
    wp_enqueue_style( 'jobify-child', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'jobify_child_styles', 20 );

/** Place any new code below this line */";

		return $output;
	}

	/**
	 * Filter the child theme's notice output
	 *
	 * @since 3.3.0
	 * @param array $screen_ids
	 * @return array $screen_ids
	 */
	public static function uct_admin_notices_screen_id( $screen_ids ) {
		return array( Astoundify_Setup_Guide::get_screen_id() );
	}

	/**
	 * Create the setup guide.
	 *
	 * @since 3.3.0
	 * @return void
	 */
	public static function setup_guide() {
		add_action( 'astoundify_setup_guide_intro', array( __CLASS__, '_setup_guide_intro' ) );

		Astoundify_Setup_Guide::init( array(
			'steps' => include_once( dirname( __FILE__ ) . '/setup-guide-steps/_step-list.php' ),
			'steps_dir' => get_template_directory() . '/inc/setup/setup-guide-steps',
			'strings' => array(
				'page-title' => __( 'Setup %s', 'jobify' ),
				'menu-title' => __( 'Getting Started', 'jobify' ),
				'sub-menu-title' => __( 'Setup Guide', 'jobify' ),
				'intro-title' => __( 'Welcome to %s', 'jobify' ),
				'step-complete' => __( 'Completed', 'jobify' ),
				'step-incomplete' => __( 'Not Complete', 'jobify' )
			),
			'stylesheet_uri' => get_template_directory_uri() . '/inc/setup/_setup-guide/style.css',
		) );
	}

	/**
	 * The introduction text for the setup guide page.
	 *
	 * @since 3.3.0
	 * @return void
	 */
	public static function _setup_guide_intro() {
?>
<p class="about-text"><?php printf( __( 'Creating a job listing website has never been easier with Jobify — the easiest to use job board theme available. Use the steps below to finish setting up your new website. If you have more questions please <a href="%s">review the documentation</a>.', 'jobify' ), 'http://jobify.astoundify.com' ); ?></p>

<div class="setup-guide-theme-badge"><img src="<?php echo get_template_directory_uri(); ?>/inc/setup/assets/images/badge.png" width="140" alt="" /></div>

<p class="helpful-links">
    <a href="http://jobify.astoundify.com" class="button button-primary js-trigger-documentation"><?php _e( 'Search Documentation', 'jobify' ); ?></a>&nbsp;
    <a href="https://astoundify.com/go/astoundify-support/" class="button button-secondary"><?php _e( 'Submit a Support Ticket', 'jobify' ); ?></a>&nbsp;
</p>

<script>
	jQuery(document).ready(function($) {
		$('.js-trigger-documentation').click(function(e) {
			e.preventDefault();
			HS.beacon.open();
		});
	});
</script>
<script>!function(e,o,n){window.HSCW=o,window.HS=n,n.beacon=n.beacon||{};var t=n.beacon;t.userConfig={},t.readyQueue=[],t.config=function(e){this.userConfig=e},t.ready=function(e){this.readyQueue.push(e)},o.config={modal: true, docs:{enabled:!0,baseUrl:"//astoundify-jobify.helpscoutdocs.com/"},contact:{enabled:!1,formId:"7f6e93b6-cb77-11e5-9e75-0a7d6919297d"}};var r=e.getElementsByTagName("script")[0],c=e.createElement("script");c.type="text/javascript",c.async=!0,c.src="https://djtflbt20bdde.cloudfront.net/",r.parentNode.insertBefore(c,r)}(document,window.HSCW||{},window.HS||{});</script>
<?php
	}

	/**
	 * Create the theme updater.
	 *
	 * @since 3.3.0
	 * @return void
	 */
	public static function theme_updater() {
		// start the updater
		$updater = Astoundify_ThemeForest_Updater::instance();
		$updater::set_strings( array(
			'cheating' => __( 'Cheating?', 'jobify' ),
			'no-token' => __( 'An API token is required.', 'jobify' ),
			'api-error' => __( 'API error.', 'jobify' ),
			'api-connected' => __( 'Connected', 'jobify' ),
			'api-disconnected' => __( 'Disconnected', 'jobify' )
		) );

		// set a filter for the token
		add_filter( 'astoundify_themeforest_updater', array( __CLASS__, '_theme_updater_get_token' ) );

		// init the api so it has a token value
		Astoundify_Envato_Market_API::instance();

		// ajax callback
		add_action( 'wp_ajax_astoundify_updater_set_token', array( __CLASS__, '_theme_updater_set_token' ) );
	}

	/**
	 * Filter the Theme Updater token.
	 *
	 * @since 3.3.0
	 * @return string
	 */
	public static function _theme_updater_get_token() {
		return get_option( self::get_template_name() . '_themeforest_updater_token', null );
	}

	/**
	 * AJAX response when a token is set in the Setup Guide.
	 *
	 * @since 3.3.0
	 * @return void
	 */
	public static function _theme_updater_set_token() {
		check_ajax_referer( 'astoundify-add-token', 'security' );

		$token = isset( $_POST[ 'token' ] ) ? esc_attr( $_POST[ 'token' ] ) : false;
		$api = Astoundify_Envato_Market_API::instance();

		update_option( self::get_template_name() . '_themeforest_updater_token', $token );
		delete_transient( 'atu_can_make_request' );

		// hotswap the token
		$api->token = $token;

		wp_send_json_success( array(
			'token' => $token,
			'can_request' => $api->can_make_request_with_token(),
			'request_label' => $api->connection_status_label()
		) );

		exit();
	}

	/**
	 * Create the content importer.
	 *
	 * @since 3.3.0
	 * @return void
	 */
	public static function content_importer() {
		self::$content_importer_strings = array(
			'type_labels' => array(
				'setting' => array( __( 'Setting', 'jobify' ), __( 'Settings', 'jobify' ) ),
				'theme-mod' => array( __( 'Theme Customization', 'jobify' ), __( 'Theme Customizations', 'jobify' ) ),
				'term' => array( __( 'Term', 'jobify' ), __( 'Terms', 'jobify' ) ),
				'nav-menu' => array( __( 'Navigation Menu', 'jobify' ), __( 'Navigation Menus', 'jobify' ) ),
				'nav-menu-item' => array( __( 'Navigation Menu Item', 'jobify' ), __( 'Navigation Menu Items', 'jobify' ) ),
				'object' => array( __( 'Content', 'jobify' ), __( 'Content', 'jobify' ) ),
				'widget' => array( __( 'Widget', 'jobify' ), __( 'Widgets', 'jobify' ) )
			),
			'import' => array(
				'complete' => __( 'Import Complete!', 'jobify' ),
			),
			'reset' => array(
				'complete' => __( 'Reset Complete!', 'jobify' )
			),
			'errors' => array(
				'process_action' => __( 'Invalid process action.', 'jobify' ),
				'process_type' => __( 'Invalid process type.', 'jobify' ),
				'iterate' => __( 'Iteration process failed.', 'jobify' ),
				'cap_check_fail' => __( 'You do not have permission to manage content.', 'jobify' )
			)
		);

		Astoundify_ContentImporter::instance();
		Astoundify_ContentImporter::set_strings( self::$content_importer_strings );
		Astoundify_ContentImporter::set_url( get_template_directory_uri() . '/inc/setup/_importer' );

		// ajax callback
		add_action( 'wp_ajax_astoundify_content_importer', array( __CLASS__, '_content_importer_stage' ) );
	}

	/**
	 * AJAX response when content is imported in the setup guide.
	 *
	 * @since 3.3.0
	 * @return void
	 */
	public static function _content_importer_stage() {
		check_ajax_referer( 'setup-guide-stage-import', 'security' );

		if ( ! current_user_can( 'import' ) ) {
			wp_send_json_error( __( 'You do not have permission to import content.', 'jobify' ) );
		}

		// the style to use
		$style = isset( $_POST[ 'style' ] ) ? $_POST[ 'style' ] : false;

		if ( ! $style ) {
			wp_send_json_error();
		}

		// remove any inactive plugins
		$files = glob( get_template_directory() . '/inc/setup/import-content/' . esc_attr( $style ) . '/*.json' );
		$files = self::get_importable_files( $files );

		$importer = Astoundify_ImporterFactory::create( $files );

		if ( ! is_wp_error( $importer ) ) {
			$stage = $importer->stage();

			if ( is_wp_error( $stage ) ) {
				wp_send_json_error( $stage->get_error_message() );
			}

			return wp_send_json_success( array(
				'total' => count( $importer->get_items() ),
				'groups' => $importer->item_groups,
				'items' => $importer->get_items(),
			) );
		} else {
			return wp_send_json_error( $importer->get_error_message() );
		}

		exit();
	}

	/**
	 * Cant properly use array_filter in PHP < 5.3
	 *
	 * @since 3.3.0
	 * @return array $plugins
	 */
	public static function get_active_plugins() {
		$plugins = self::get_importable_plugins();

		foreach ( $plugins as $k => $plugin ) {
			if ( false == $plugin[ 'condition' ] ) {
				unset( $plugins[ $k ] );
			}
		}

		$plugins = array_keys( $plugins );

		return $plugins;
	}

	/**
	 * Can't properly use array_filter in PHP < 5.3
	 *
	 * @since 3.3.0
	 * @return array $files
	 */
	public function get_importable_files( $files ) {
		$plugins = self::get_active_plugins();

		foreach ( $files as $k => $v ) {
			if ( false == strpos( $v, 'plugin' ) ) {
				continue;
			}

			if ( ! Astoundify_Utils::strposa( $v, $plugins ) ) {
				unset( $files[ $k ] );
			}
		}

		return $files;
	}

	public static function get_importable_plugins() {
		return array_merge( self::get_required_plugins(), self::get_recommended_plugins() );
	}

	public static function get_required_plugins() {
		return array(
			'woocommerce' => array(
				'label' => '<a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=woocommerce&TB_iframe=true&width=772&height=642' ) . '" class="thickbox">WooCommerce</a>',
				'condition' => class_exists( 'WooCommerce' ),
			),
			'wp-job-manager-base' => array(
				'label' => '<a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=wp-job-manager&TB_iframe=true&width=772&height=642' ) . '" class="thickbox">WP Job Manager</a>',
				'condition' => class_exists( 'WP_Job_Manager' ),
			)
		);
	}

	public static function get_recommended_plugins() {
		return array(
			'wp-job-manager-bookmarks' => array(
				'label' => '<a href="https://wpjobmanager.com/add-ons/bookmarks">WP Job Manager - Bookmarks</a>',
				'condition' => class_exists( 'WP_Job_Manager_Bookmarks' ),
				'pack' => array( 'extended' )
			),
			'wp-job-manager-company-profiles' => array(
				'label' => '<a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=wp-job-manager-companies&TB_iframe=true&width=772&height=642' ) . '" class="thickbox">WP Job Manager - Company Profiles</a>',
				'condition' => class_exists( 'Astoundify_Job_Manager_Companies' ),
				'pack' => array( 'classic', 'extended' )
			),
			'wp-job-manager-contact-listing' => array(
				'label' => '<a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=wp-job-manager-contact-listing&TB_iframe=true&width=772&height=642' ) . '" class="thickbox">WP Job Manager - Contact Listing</a>',
				'condition' => class_exists( 'Astoundify_Job_Manager_Contact_Listing' ),
				'pack' => array( 'classic', 'extended' )
			),
			'wp-job-manager-regions' => array(
				'label' => '<a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=wp-job-manager-locations&TB_iframe=true&width=772&height=642' ) . '" class="thickbox">WP Job Manager - Regions</a>',
				'condition' => class_exists( 'Astoundify_Job_Manager_Regions' ),
				'pack' => array( 'classic', 'extended' )
			),
			'wp-job-manager-resumes' => array(
				'label' => '<a href="https://wpjobmanager.com/add-ons/resume-manager">WP Job Manager - Resume Managear</a>',
				'condition' => class_exists( 'WP_Resume_Manager' ),
				'pack' => array( 'extended' )
			),
			'wp-job-manager-tags' => array(
				'label' => '<a href="https://wpjobmanager.com/add-ons/job-tags">WP Job Manager - Tags</a>',
				'condition' => class_exists( 'WP_Job_Manager_Job_Tags' ),
				'pack' => array( 'extended' )
			),
			'wp-job-manager-wc-paid-listings' => array(
				'label' => '<a href="https://wpjobmanager.com/add-ons/wc-paid-listings">WP Job Manager - WooCommerce Paid Listings</a>',
				'condition' => class_exists( 'WC_Paid_Listings' ),
				'pack' => array( 'extended' )
			),
			'woothemes-simple-registration' => array(
				'label' => '<a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=woocommerce-simple-registration&TB_iframe=true&width=772&height=642' ) . '" class="thickbox">WooCommerce - Simple Registration</a>',
				'condition' => class_exists( 'WooCommerce_Simple_Registration' ),
				'pack' => array( 'classic', 'extended' )
			),
			'woothemes-testimonials' => array(
				'label' => '<a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=testimonials-by-woothemes&TB_iframe=true&width=772&height=642' ) . '" class="thickbox">Testimonials</a>',
				'condition' => class_exists( 'Woothemes_Testimonials' ),
				'pack' => array( 'classic', 'extended' )
			),
		);
	}

	/**
	 * Get the name of the current template (not child theme)
	 *
	 * @since 1.5.0
	 * @return string $template
	 */
	public static function get_template_name() {
		// if the current theme is a child theme find the parent
		$current_child_theme = wp_get_theme();

		if ( false !== $current_child_theme->parent() ) {
			$current_theme = wp_get_theme( $current_child_theme->get_template() );
		} else {
			$current_theme = wp_get_theme();
		}

		$template = $current_theme->get_template();

		return $template;
	}

}

Jobify_Setup::init();
