<?php
/*
Template Name: Orig jobify
*/
get_header();

?>

		<div id="main" class="site-main">

			<div id="primary" role="main">

				<div class="job_listing-map-wrapper">

					<div class="job_listing-map">
						<div id="job_listing-map-canvas"></div>
					</div>

				</div>

				<div class="container content-area">


					<div class="entry-content">

						<div class="job_listings" data-location="" data-keywords="" data-show_filters="true" data-show_pagination="false" data-per_page="15" data-orderby="featured" data-order="DESC" data-categories="" > 

						<?php echo do_shortcode("[jobs]");?>

						</div><!-- #primary -->


		</div><!-- #main -->