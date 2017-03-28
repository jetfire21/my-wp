<?php
/**
 * Twenty Sixteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

/**
 * Twenty Sixteen only works in WordPress 4.4 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twentysixteen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own twentysixteen_setup() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Twenty Sixteen, use a find and replace
	 * to change 'twentysixteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'twentysixteen', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 9999 );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'twentysixteen' ),
		'social'  => __( 'Social Links Menu', 'twentysixteen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', twentysixteen_fonts_url() ) );
}
endif; // twentysixteen_setup
add_action( 'after_setup_theme', 'twentysixteen_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'twentysixteen_content_width', 840 );
}
add_action( 'after_setup_theme', 'twentysixteen_content_width', 0 );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'twentysixteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 1', 'twentysixteen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 2', 'twentysixteen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentysixteen_widgets_init' );

if ( ! function_exists( 'twentysixteen_fonts_url' ) ) :
/**
 * Register Google fonts for Twenty Sixteen.
 *
 * Create your own twentysixteen_fonts_url() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function twentysixteen_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Merriweather font: on or off', 'twentysixteen' ) ) {
		$fonts[] = 'Merriweather:400,700,900,400italic,700italic,900italic';
	}

	/* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'twentysixteen' ) ) {
		$fonts[] = 'Montserrat:400,700';
	}

	/* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'twentysixteen' ) ) {
		$fonts[] = 'Inconsolata:400';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentysixteen_javascript_detection', 0 );

/**
 * Enqueues scripts and styles.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentysixteen-fonts', twentysixteen_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );

	// Theme stylesheet.
	wp_enqueue_style( 'twentysixteen-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentysixteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentysixteen-style' ), '20150930' );
	wp_style_add_data( 'twentysixteen-ie', 'conditional', 'lt IE 10' );

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'twentysixteen-ie8', get_template_directory_uri() . '/css/ie8.css', array( 'twentysixteen-style' ), '20151230' );
	wp_style_add_data( 'twentysixteen-ie8', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'twentysixteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentysixteen-style' ), '20150930' );
	wp_style_add_data( 'twentysixteen-ie7', 'conditional', 'lt IE 8' );

	// Load the html5 shiv.
	wp_enqueue_script( 'twentysixteen-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'twentysixteen-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'twentysixteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151112', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentysixteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20151104' );
	}

	wp_enqueue_script( 'twentysixteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20151204', true );

	wp_localize_script( 'twentysixteen-script', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'twentysixteen' ),
		'collapse' => __( 'collapse child menu', 'twentysixteen' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'twentysixteen_scripts' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function twentysixteen_body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to sites with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of no-sidebar to sites without active sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'twentysixteen_body_classes' );

/**
 * Converts a HEX value to RGB.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function twentysixteen_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
// require get_template_directory() . '/inc/customizer.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentysixteen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

	if ( 'page' === get_post_type() ) {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	} else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentysixteen_content_image_sizes_attr', 10 , 2 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function twentysixteen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		! is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'twentysixteen_post_thumbnail_sizes_attr', 10 , 3 );

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Twenty Sixteen 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function twentysixteen_widget_tag_cloud_args( $args ) {
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['unit'] = 'em';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'twentysixteen_widget_tag_cloud_args' );




/* ***********alex code ************ */



/* *********** Group Extension API создание новой секции настроек для группы ************ */

/**
 * The bp_is_active( 'groups' ) check is recommended, to prevent problems 
 * during upgrade or when the Groups component is disabled
 */
if( function_exists('bp_is_active')):
if ( bp_is_active( 'groups' ) ) :
  
class Group_Extension_Example_2 extends BP_Group_Extension {
    /**
     * Here you can see more customization of the config options
     */
    function __construct() {
        $args = array(
            'slug' => 'group-extension-example-2',
            'name' => 'Group Extension Example 2',
            'nav_item_position' => 105,
            'show_tab' => 'noone',
            'screens' => array(
                'edit' => array(
                    'name' => 'GE Example 2',
                    // Changes the text of the Submit button
                    // on the Edit page
                    'submit_text' => 'Submit, suckaz',
                ),
                'create' => array(
                    'position' => 100,
                ),
            ),
        );
        parent::init( $args );
    }
 
    function display( $group_id = NULL ) {
        $group_id = bp_get_group_id();
        echo 'This plugin is 2x cooler!';
    }
 
    function settings_screen( $group_id = NULL ) {
        $setting = groups_get_groupmeta( $group_id, 'group_extension_example_2_setting' );
        $setting_2 = groups_get_groupmeta( $group_id, 'gr_ext_exm_2_enable' );
 
        ?>
        Save your plugin setting here: 
        <input type="url" name="group_extension_example_2_setting" value="<?php echo esc_attr( $setting ) ?>" />
		<label for="gr_ext_exm_2_enable">
		<input type="checkbox" id="gr_ext_exm_2_enable" name="gr_ext_exm_2_enable" <?php if($setting_2 == 'yes') echo 'checked="checked"';?>value="yes"> Enable automate
		</label>
		<script type="text/javascript">
			jQuery(document).ready(function(){
			var sel = jQuery('#gr_ext_exm_2_enable');
			sel.on('click', function(){     
			if(sel.attr("checked") == 'checked') {  
				sel.val("yes")
			} else {
				sel.val("no")
			}
			});
		});
		</script>
        <?php
    }
 
    function settings_screen_save( $group_id = NULL ) {
        $setting = isset( $_POST['group_extension_example_2_setting'] ) ? $_POST['group_extension_example_2_setting'] : '';
        groups_update_groupmeta( $group_id, 'group_extension_example_2_setting', $setting );
        $setting_2 = isset( $_POST['gr_ext_exm_2_enable'] ) ? $_POST['gr_ext_exm_2_enable'] : '';
        groups_update_groupmeta( $group_id, 'gr_ext_exm_2_enable', $setting_2 );
    }
 
    /**
     * create_screen() is an optional method that, when present, will
     * be used instead of settings_screen() in the context of group
     * creation.
     *
     * Similar overrides exist via the following methods:
     *   * create_screen_save()
     *   * edit_screen()
     *   * edit_screen_save()
     *   * admin_screen()
     *   * admin_screen_save()
     */
    function create_screen( $group_id = NULL ) {
        $setting = groups_get_groupmeta( $group_id, 'group_extension_example_2_setting' );
 
        ?>
        Welcome to your new group! You are neat.
        Save your plugin setting here: 
        <input type="text" name="group_extension_example_2_setting" value="<?php echo esc_attr( $setting ) ?>" />
		<label for="gr_ext_exm_2_enable">
		<input type="checkbox" id="gr_ext_exm_2_enable" name="gr_ext_exm_2_enable" value="yes"> Enable automate
		</label>
        <?php
    }
 
}
bp_register_group_extension( 'Group_Extension_Example_2' );
 
endif;
endif;

/* *********** Group Extension API ************ */


// add_action("wp_footer","alex_t1");
add_action("bp_after_group_home_content","alex_t1");
function alex_t1(){
	global $bp;
	$group_id = $bp->groups->current_group->id;
	echo "<h1>alex 888</h1>";
	// получение значения настройки из таблицы groupmeta
	$setting = groups_get_groupmeta( $group_id, 'group_extension_example_2_setting' );
	$enable_auto = groups_get_groupmeta( $group_id, 'gr_ext_exm_2_enable' );
	if(!$setting) echo "<br>no setting "; else alex_debug(0,0,'$setting',$setting);
	if(!$enable_auto) echo "<br>no enable_auto "; else alex_debug(0,0,'$enable_auto',$enable_auto);
}

function alex_debug ( $show_text = false, $is_arr = false, $title = false, $var, $sep = "<br>"){

	//  alex_debug(0,0,'$enable_auto',$enable_auto);
	$debug_text = "<br>======= Debug MODE ========<br>";
	if( boolval($show_text) ) echo $debug_text;
	if( boolval($is_arr) ){
		echo $title."-";
		echo "<pre>";
		print_r($var);
		echo "</pre>";
		echo "<hr>";
	} else echo "<b>".$title.":</b> ".$var;
	if($sep == "line") echo "<hr>"; else echo $sep;
}

add_action("wp_footer","alex_t2");
function alex_t2(){
	echo "<h2>testing query</h2>";
	global $wpdb;

/* *** множественное обновление за 1 запрос,второй запрос работает быстрее*** */
$st_time = microtime(true);

// $wpdb->query("UPDATE alex_test SET post_title='t11111111111111_w2',post_content='c111111111111111_w2' WHERE id=1");
// $wpdb->query("UPDATE alex_test SET post_title='t21111111111111_w2',post_content='c211111111111111_w2' WHERE id=2");
// $wpdb->query("UPDATE alex_test SET post_title='t31111111111111_w2',post_content='c311111111111111_w2' WHERE id=3");
// $wpdb->query("UPDATE alex_test SET post_title='t41111111111111_w2',post_content='c411111111111111_w2' WHERE id=4");
// $wpdb->query("UPDATE alex_test SET post_title='t51111111111111_w2',post_content='c511111111111111_w2' WHERE id=5");
// $wpdb->query("UPDATE alex_test SET post_title='t61111111111111_w2',post_content='c611111111111111_w2' WHERE id=6");
// time == 0.36151599884033

$wpdb->query("UPDATE alex_test SET
    post_title = CASE id WHEN 1 THEN 'title1_123456789' WHEN 2 THEN 'title2_123456789' WHEN 3 THEN 'title3_123456789' WHEN 4 THEN 'title4_123456789' WHEN 5 THEN 'title5_123456789' WHEN 6 THEN 'title6_123456789' ELSE '' END,
    post_content = CASE id WHEN 1 THEN 'content1_123456789' WHEN 2 THEN 'content2_123456789' WHEN 3 THEN 'content3_123456789' WHEN 4 THEN 'content4_123456789' WHEN 5 THEN 'content5_123456789' WHEN 6 THEN 'content6_123456789' ELSE '' END");
// time  = 0.09584903717041

$end_time = microtime(true);
echo "time = ".($end_time - $st_time);
/* *** множественное обновление за 1 запрос,второй запрос работает быстрее*** */

}





/////////////////////////////////////////

// /home/jetfire/www/my-wp.dev/wp-content/themes/twentysixteen/wp-job-manager-tags/wp-job-manager-tags.php
// include_once( 'wp-job-manager-tags/wp-job-manager-tags.php' );
// /home/jetfire/www/my-wp.dev/wp-content/themes/twentysixteen/wp-job-manager/class-wp-job-manager.php

// if(class_exists('WP_Job_Manager')) include_once( 'wp-job-manager/class-wp-job-manager.php' );


// add_action( 'wp_enqueue_scripts', 'a21_css_js_for_theme',999 );
// function a21_css_js_for_theme(){
//   // wp_deregister_style( 'wp-job-manager-frontend' );
//   //  wp_enqueue_script('jquery', get_template_directory_uri()."/libs/jquery/jquery_1.8.3.min.js",'','',true);
//    if( is_page('jobs') || is_page("jobs-any-themes")){ 
//    		// wp_enqueue_style( 'a21-jobify', get_template_directory_uri()."/css/a21-wp-job-n.css");
//    		// wp_enqueue_style( 'a21-wp-job-inline', get_template_directory_uri()."/css/a21-wp-job-inline.css");
//    		// wp_enqueue_style( 'a21-jobify', get_template_directory_uri()."/css/a21-jobify.css");
//        // wp_enqueue_script('lightbox-js', get_template_directory_uri()."/libs/lightbox/js/lightbox.min.js",array('jquery'),'',true);
//     }
// }

// $shortcode = do_shortcode('[jobs]');
// // $shortcode = do_shortcode('[jobs selected_job_types="full-time"]');
// echo apply_filters('my_new_filter',$shortcode);
// add_filter('my_new_filter','my_new_filter_callback');
// function my_new_filter_callback($shortcode){
//     //to stuff here
//     return $shortcode;
//     // var_dump($shortcode);
// }

// add_action("wp_footer","a21_debug_queries");
// add_action("loop_end","a21_debug_queries",999);

function a21_debug_queries(){
   global $wpdb;
   echo "<pre>";
   print_r($wpdb->queries);
   echo "</pre>";
}


add_action( 'wp_enqueue_scripts', 'css_js_for_theme' );
function css_js_for_theme(){
	// отключение js скрипта у плагина и подключение вместо него другого
	// http://my-wp.dev/wp-content/plugins/wp-job-manager/assets/js/ajax-filters.js
  	// wp_deregister_script( 'wp-job-manager-ajax-filters' );
	// wp_enqueue_script( 'wp-job-manager-ajax-filters', plugins_url() . '/wp-job-manager/assets/js/ajax-filters.js', '','', true );
}




// override function path.../plugins/wp-job-manager/wp-job-manager-functions.php - it is necessary for work the filter by keyword
function get_job_listings_keyword_search( $args ) {

	global $wpdb, $job_manager_keyword;
	$conditions   = array();
	$conditions[] = "{$wpdb->posts}.post_title LIKE '%" . esc_sql( $job_manager_keyword ) . "%'";
	$conditions[] = "{$wpdb->posts}.ID IN ( SELECT post_id FROM {$wpdb->postmeta} WHERE meta_value LIKE '%" . esc_sql( $job_manager_keyword ) . "%' )";
	$conditions[] = "{$wpdb->posts}.ID IN ( SELECT object_id FROM {$wpdb->term_relationships} AS tr LEFT JOIN {$wpdb->term_taxonomy} AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id LEFT JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id WHERE t.name LIKE '%" . esc_sql( $job_manager_keyword ) . "%' )";
	$conditions[] = "{$wpdb->posts}.post_content LIKE '%" . esc_sql( $job_manager_keyword ) . "%'";
	$args['where'] .= " AND ( " . implode( ' OR ', $conditions ) . " ) ";
	return $args;
}
