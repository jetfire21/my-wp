<?php

class Jobify_TGMPA extends Jobify_Integration {

	public function __construct() {
		$this->includes = array(
			'class-tgm-plugin-activation.php'
		);

		parent::__construct( dirname( __FILE__ ) );
	}

	public function setup_actions() {
		add_action( 'tgmpa_register', array( $this, 'register_required_plugins' ) );
	}

	public function register_required_plugins() {
		$plugins = array(
			array(
				'name'      => 'WP Job Manager',
				'slug'      => 'wp-job-manager',
				'required'  => true
			),
			array(
				'name'      => 'WP Job Manager - Company Profiles',
				'slug'      => 'wp-job-manager-companies',
				'required'  => false,
			),
			array(
				'name'      => 'WP Job Manager - Job Colors',
				'slug'      => 'wp-job-manager-colors',
				'required'  => false,
			),
			array(
				'name'      => 'WP Job Manager - Job Regions',
				'slug'      => 'wp-job-manager-locations',
				'required'  => false,
			),
			array(
				'name'      => 'WP Job Manager - Contact Listing',
				'slug'      => 'wp-job-manager-contact-listing',
				'required'  => false,
			),
			array(
				'name'      => 'WooCommerce',
				'slug'      => 'woocommerce',
				'required'  => true
			),
			array(
				'name'      => 'WooCommerce - Simple Registration',
				'slug'      => 'woocommerce-simple-registration',
				'required'  => false
			),
			array(
				'name'      => 'Ninja Forms',
				'slug'      => 'ninja-forms',
				'required'  => false,
			),
			array(
				'name'      => 'Testimonials',
				'slug'      => 'testimonials-by-woothemes',
				'required'  => false,
			),
			array(
				'name'      => 'Nav Menu Roles',
				'slug'      => 'nav-menu-roles',
				'required'  => false,
			)
		);

		$config = array(
			'id'          => 'tgmpa-jobify-' . get_option( 'jobify_version', '3.0.0' ),
			'has_notices' => false,
			'parent_slug' => Astoundify_Setup_Guide::get_page_id(),
			'is_automatic' => true
		);

		tgmpa( $plugins, $config );
	}

}
