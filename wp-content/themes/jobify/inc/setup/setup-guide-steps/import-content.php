<?php
/**
 */

global $tgmpa;
?>

<form id="astoundify-content-importer" action="" method="">

	<div id="content-pack">
		<p>
			<strong><?php _e( 'Demo Content:', 'jobify' ); ?></strong>
		</p>

		<p>
			<label for="classic" class="content-pack">
				<input type="radio" value="classic" name="demo_style" id="classic" checked="checked" />
				<span class="content-pack-img">
					<span class="dashicons dashicons-yes"></span>
					<img src="<?php echo get_template_directory_uri(); ?>/inc/setup/assets/images/content-classic.png" />
				</span>
				<span class="screen-reader-text"><?php _e( 'Classic', 'jobify' ); ?></span>
			</label>
			<label for="extended" class="content-pack">
				<input type="radio" value="extended" name="demo_style" id="extended" />
				<span class="content-pack-img">
					<span class="dashicons dashicons-yes"></span>
					<img src="<?php echo get_template_directory_uri(); ?>/inc/setup/assets/images/content-extended.png" />
				</span>
				<span class="screen-reader-text"><?php _e( 'Extended', 'jobify' ); ?></span>
			</label>
			<label for="coming-soon" class="content-pack">
				<input type="radio" value="coming-soon" name="" disabled="disabled" id="coming-soon" />
				<span class="content-pack-img">
					<img src="<?php echo get_template_directory_uri(); ?>/inc/setup/assets/images/content-coming-soon.png" />
				</span>
				<span class="screen-reader-text"><?php _e( 'Coming Soon...', 'jobify' ); ?></span>
			</label>
		</p>
	</div>

	<div id="import-summary" style="display: none;">
		<p><?php _e( 'Please do not navigate away from this page. This process may take a few minutes depending on your server capabilities and internet connection.', 'jobify' ); ?></p>

		<p><strong id="import-status"><?php _e( 'Summary:', 'jobify' ); ?></strong></p>

		<?php foreach ( Jobify_Setup::$content_importer_strings[ 'type_labels' ] as $key => $labels ) : ?>
		<p id="import-type-<?php echo esc_attr( $key ); ?>" class="import-type">
			<span class="dashicons import-type-<?php echo esc_attr( $key ); ?>"></span>&nbsp;
			<strong class="process-type"><?php echo esc_attr( $labels[1] ); ?>:</strong>
			<span class="process-count">
				<span id="<?php echo esc_attr( $key ); ?>-processed">0</span> / <span id="<?php echo esc_attr( $key ); ?>-total">0</span>
			</span>
			<span id="<?php echo esc_attr( $key ); ?>-spinner" class="spinner"></span>
		</p>
		<?php endforeach; ?>
	</div>

	<ul id="import-errors"></ul>

	<div id="plugins-to-import">
		<p><?php _e( 'Jobify requires the following plugins to be active in order to import content.', 'jobify' ); ?></p>

		<ul>
		<?php foreach ( Jobify_Setup::get_required_plugins() as $key => $plugin ) : ?>
		<li>
			<?php if ( $plugin[ 'condition' ] ) : ?>
				<span class="active"><span class="dashicons dashicons-yes"></span></span>
			<?php else : ?>
				<span class="inactive"><span class="dashicons dashicons-no"></span></span>
			<?php endif; ?>

			<?php echo $plugin[ 'label' ]; ?>

			<?php if ( ! $plugin[ 'condition' ] ) : ?>
			&mdash; <span class="inactive"><?php _e( 'Demo content for this plugin will not be imported.', 'jobify' ); ?></span>
			<?php endif; ?>
		</li>
		<?php endforeach; ?>
		</ul>

		<p><?php _e( 'Want extra features on your site? Activate the following plugins for even more demo content; saving you setup time!', 'jobify' ); ?></p>

		<ul id="astoundify-recommended-plugins">
		<?php foreach ( Jobify_Setup::get_recommended_plugins() as $key => $plugin ) : ?>
		<li data-pack="<?php echo implode( ' ', $plugin[ 'pack' ] ); ?>">
			<?php if ( $plugin[ 'condition' ] ) : ?>
				<span class="active dashicons dashicons-yes"></span>
			<?php else : ?>
				<span class="dashicons dashicons-minus" style="color: #b4b9be;"></span>
			<?php endif; ?>

			<?php echo $plugin[ 'label' ]; ?>

			<?php if ( ! $plugin[ 'condition' ] ) : ?>
			<em>(<?php _e( 'Demo content will not be imported for this inactive plugin', 'listify' ); ?>)</em>
			<?php endif; ?>
		</li>
		<?php endforeach; ?>
		</ul>
	</div>

	<p>
		<?php submit_button( __( 'Import Content', 'jobify' ), 'primary', 'import', false ); ?>
		&nbsp;
		<?php submit_button( __( 'Reset Content', 'jobify' ), 'secondary', 'reset', false ); ?>
	</p>

</form>

<script>
/**
 * @param {jQuery} $ jQuery object.
 * @param {object} wp WP object.
 */
(function( $, wp ) {
	var $window = $( window );

	/**
	 * The Astoundify_ContentImporter object.
	 *
	 * @since 3.3.0
	 * @type {object}
	 */
	var Astoundify_ContentImporter = Astoundify_ContentImporter || {};

	/**
	 * All packs
	 *
	 * @since 3.3.0
	 * @type string
	 */
	Astoundify_ContentImporter.packs = $( '#content-pack' ).find( 'input[name="demo_style"]' );

	Astoundify_ContentImporter.toggleRecommendedPlugins = function() {
		var pack = Astoundify_ContentImporter.packs.filter( ':checked' ).val();

		$( '#astoundify-recommended-plugins li' ).hide().filter( function() {
			var showFor = $(this).data( 'pack' ).split( ' ' );

			return showFor.indexOf( pack ) != -1;
		} ).show();
	}

	/**
	 * Bind actions to DOM
	 *
	 * @since 3.3.0
	 */
	jQuery(document).ready(function($) {
		Astoundify_ContentImporter.toggleRecommendedPlugins();

		Astoundify_ContentImporter.packs.on( 'change', function() {
			Astoundify_ContentImporter.toggleRecommendedPlugins();
		});
	});

})( jQuery, window.wp );
</script>

<style>
.content-pack {
	display: inline-block;
	background: url(<?php echo get_template_directory_uri(); ?>/inc/setup/assets/images/content-browser.svg);
	width: 300px;
	height: 300px;
	position: relative;
}

.content-pack img {
	width: 263px;
	height: 223px;
}

.content-pack input[type="radio"] {
	visibility: hidden;
	position: absolute;
}

label[for="coming-soon"],
.content-pack input[type="radio"]:disabled {
	cursor: text;
}

.content-pack-img {
	width: 263px;
	height: 223px;
	position: absolute;
    bottom: 29px;
    left: 19px;
}

.content-pack input[type="radio"]:checked  + .content-pack-img:after {
	content: ' ';
	background: rgba(85, 85, 95, .79);
	position: absolute;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
}

.content-pack-img .dashicons-yes {
	visibility: hidden;
	position: absolute;
	color: white;
	font-size: 60px;
	z-index: 10;
	width: 60px;
	height: 60px;
	top: 50%;
	left: 50%;
	margin: -30px 0 0 -30px;
}

.content-pack input[type="radio"]:checked + .content-pack-img .dashicons-yes {
	visibility: visible;
}
</style>
