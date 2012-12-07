<?php
/*
 Plugin Name: YiGG Button
 Plugin URI: http://wordpress.org/extend/plugins/yigg
 Description: Adds the yigg-button to your posts and pages
 Author: Matthias Pfefferle
 Author URI: http://yigg.de/
 Version: 1.0.0
 License: 
 Text Domain: yigg
*/

/**
 * render admin stuff
 */
function yigg_admin_page() {
  
}

/**
 * add the button to the content
 *
 * @param string $content the post/page content
 * @return string the post/page-code with the yigg button
 */
function yigg_extend_post($content) {
  $perma_link = get_permalink();
	
	return $content . yigg_generate_button($perma_link);
}
add_action("the_content", "yigg_extend_post");

/**
 * a button shortcode
 *
 * @param array $atts the shortcode attributes
 * @return string the button html code
 */
function yigg_button_shortcode($atts) {
	extract( shortcode_atts( array(
		'url' => '',
		'type' => 'small',
	), $atts ) );

	return yigg_generate_button($url, $type);
}
add_shortcode("yigg_button", "yigg_button_shortcode");

/**
 * gernerates the button code
 *
 * @param string $url the url that should be liked
 * @param string $type the type of the button
 * @return string the button html code
 */
function yigg_generate_button($url = "", $type = "small") {
	$var = "";
	if ($type == "small") {
		$var = "flat_";
	}

	$html = "<div class='yiggbutton'>
	  <script> var yigg_url = '$url'; </script>
    <script src='http://static.yigg.de/v6/js/embed_".$var."button.js'></script>
  </div>";
	
	return $html;
}