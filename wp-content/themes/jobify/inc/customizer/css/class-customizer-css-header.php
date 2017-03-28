<?php
/**
 * Output the Header CSS.
 *
 * @package Jobify
 * @category Customizer
 * @since 3.4.0
 */
class Jobify_Customizer_CSS_Header {

    public function __construct() {
        $this->css = jobify_customizer()->css;

        add_action( 'jobify_output_customizer_css', array( $this, 'output' ) );
    }

    public function output() {
		$fixed_header = get_theme_mod( 'fixed-header', true );

		if ( $fixed_header ) {
			$this->css->add( array(
				'selectors' => array(
					'body'
				),
				'declarations' => array(
					'padding-top' => '110px'
				)
			) );
		}
    }

}
