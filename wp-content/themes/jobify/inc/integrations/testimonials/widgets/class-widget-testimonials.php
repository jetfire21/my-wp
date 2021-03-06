<?php
/**
 * Individual Testimonials
 *
 * Use "individual" category with Testimonials by WooThemes
 *
 * @since Jobify 1.0
 */
class Jobify_Widget_Testimonials extends Jobify_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'jobify_widget_testimonials widget--home-testimonials';
		$this->widget_description = __( 'Display a slider of all the people you have helped.', 'jobify' );
		$this->widget_id          = 'jobify_widget_testimonials';
		$this->widget_name        = __( 'Jobify - Page: Testimonials', 'jobify' );
		$this->settings           = array(
			'home widgetized' => array(
				'std' => __( 'Homepage/Widgetized', 'jobify' ),
				'type' => 'widget-area'
			),
			'title' => array(
				'type'  => 'text',
				'std'   => __( 'Kind Words From Happy Campers', 'jobify' ),
				'label' => __( 'Title:', 'jobify' )
			),
			'description' => array(
				'type'  => 'textarea',
				'rows'  => 4,
				'std'   => 'What other people thought about the service provided by Jobify',
				'label' => __( 'Description:', 'jobify' ),
			),
			'number' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 8,
				'label' => __( 'Number of testimonials:', 'jobify' )
			),
			'background-color' => array(
				'type'  => 'colorpicker',
				'std'   => '#ffffff',
				'label' => __( 'Background Color:', 'jobify' )
			),
			'background' => array(
				'type'  => 'text',
				'std'   => null,
				'label' => __( 'Background Image:', 'jobify' )
			),
			'category' => array(
				'type' => 'description',
				'std' => sprintf( __( 'Assign <a href="%s">Testimonials</a> to the <a href="%s">Individual</a> category.', 'jobify' ), esc_url( admin_url( 'post-new.php?post_type=testimonial' ) ), esc_url( admin_url( 'edit-tags.php?taxonomy=testimonial-category&post_type=testimonial' ) ) )
			)
		);
		parent::__construct();
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		ob_start();

		extract( $args );

		$title       = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$number      = isset( $instance[ 'number' ] ) ? absint( $instance[ 'number' ] ) : 1;
		$description = isset( $instance[ 'description' ] ) ? esc_attr( $instance[ 'description' ] ) : false;
		$background  = isset( $instance[ 'background' ] ) ? esc_url( $instance[ 'background' ] ) : '';
		$backgroundc = isset( $instance[ 'background-color' ] ) ? esc_url( $instance[ 'background-color' ] ) : '#ffffff';

		if ( '#ffffff' == $backgroundc && ! $background ) {
			$before_widget = str_replace( 'widget--home-testimonials', 'widget--home-testimonials widget--home-testimonials--white', $before_widget );
		}

		echo $before_widget;
		?>

		<div class="container">

			<?php if ( $title ) echo $before_title . $title . $after_title; ?>

			<?php if ( $description ) : ?>
				<p class="widget-description widget-description--home"><?php echo $description; ?></p>
			<?php endif; ?>

			<div class="testimonial-slider-wrap">
				<div class="testimonial-slider">
					<?php
						woothemes_testimonials( array(
							'category' => 'individual',
							'limit'    => $number,
							'size'     => 70,
							'before'   => '',
							'after'    => ''
						) );
					?>
				</div>
			</div>

		</div>

		<style>
		#<?php echo $this->id; ?> { 
			background-color: <?php echo esc_attr( $backgroundc ); ?>; 
		}

		<?php if ( '' != $background ) : ?>
		#<?php echo $this->id; ?> { 
			background-image: url(<?php echo esc_url( $background ); ?>); 
			background-size: cover;
			background-repeat: none;
		}
		<?php endif; ?>

		<?php if ( '#ffffff' == $backgroundc && ! $background ) : ?>
		#<?php echo $this->id; ?> .widget-title,
		#<?php echo $this->id; ?> .widget-description,
		#<?php echo $this->id; ?> .testimonial-slider .slick-prev:before, 
		#<?php echo $this->id; ?> .testimonial-slider .slick-next:after {
			color: <?php echo esc_attr( jobify_theme_mod( 'color-body-text' ) ); ?>
		}
		<?php endif; ?>
		</style>

		<?php
		echo $after_widget;

		$content = ob_get_clean();

		echo $content;
	}
}
