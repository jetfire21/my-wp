<?php
/*
Template Name: Any theme
*/
?>



<div id="content" class="site-content">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			
			<article id="post-29" class="post-29 page type-page status-publish hentry">
				<header class="entry-header">
					<h1 class="entry-title">Jobs</h1>	</header><!-- .entry-header -->

					
					<div class="entry-content">
						<div class="job_listings" data-location="" data-keywords="" data-show_filters="true" data-show_pagination="false" data-per_page="10" data-orderby="featured" data-order="DESC" data-categories="" >

							<form class="job_filters">
								
								<div class="search_jobs">
									
									<div class="search_keywords">
										<label for="search_keywords">Keywords</label>
										<input type="text" name="search_keywords" id="search_keywords" placeholder="Keywords" value="" />
									</div>

									<div class="search_location">
										<label for="search_location">Location</label>
										<input type="text" name="search_location" id="search_location" placeholder="Location" value="" />
									</div>

									<div class="search_categories">
										<label for="search_categories">Category</label>
										<select name='search_categories[]' id='search_categories' class='job-manager-category-dropdown '  data-placeholder='Choose a category&hellip;' data-no_results_text='No results match' data-multiple_text='Select Some Options'>
											<option value="">Any category</option>	<option class="level-0" value="18">category one</option>
											<option class="level-0" value="19">category two</option>
											<option class="level-0" value="28">designers</option>
											<option class="level-0" value="27">developers</option>
										</select>
									</div>
									
<!-- 				<div class="search_submit">
			<input type="submit" name="submit" value="Search" />
		</div>
	-->

</div>

<ul class="job_types">
	<li><label for="job_type_full-time" class="full-time"><input type="checkbox" name="filter_job_type[]" value="full-time"  checked='checked' id="job_type_full-time" /> full time</label></li>
	<li><label for="job_type_part-time" class="part-time"><input type="checkbox" name="filter_job_type[]" value="part-time"  checked='checked' id="job_type_part-time" /> part time</label></li>
</ul>
<input type="hidden" name="filter_job_type[]" value="" />
<div class="showing_jobs"></div></form>


<noscript>Your browser does not support JavaScript, or it is disabled. JavaScript must be enabled in order to view listings.</noscript><ul class="job_listings"></ul><a class="load_more_jobs" href="#" style="display:none;"><strong>Load more listings</strong></a></div>
</div><!-- .entry-content -->

<footer class="entry-footer"><span class="edit-link"><a class="post-edit-link" href="http://my-wp.dev/wp-admin/post.php?post=29&#038;action=edit">Edit<span class="screen-reader-text"> "Jobs"</span></a></span></footer><!-- .entry-footer -->
</article><!-- #post-## -->

</main><!-- .site-main -->


</div><!-- .content-area -->



		</div><!-- .site-content -->