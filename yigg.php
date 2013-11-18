<?php
/*
 Plugin Name: YiGG Button
 Plugin URI: http://wordpress.org/extend/plugins/yigg
 Description: Adds the yigg-button to your posts and pages
 Author: pfefferle
 Author URI: http://yigg.de/
 Version: 1.0.2
 License: GPLv3 or later
 License URI: http://www.gnu.org/licenses/gpl-3.0.html
 Text Domain: yigg
*/

include("yigg-admin.php");

/**
 * add the button to the content
 *
 * @param string $content the post/page content
 * @return string the post/page-code with the yigg button
 */
function yigg_extend_post($content) {
  $perma_link = get_permalink();

  if (get_option("yigg_button_type") == "big") {
    $type = "big";
  } else {
    $type = "small";
  }

  $button = yigg_generate_button($perma_link, $type);

  $visibility = get_option("yigg_button_visibility");
  if (!is_array($visibility)) {
    $visibility = array();
  }

  if (
       (is_single() && array_key_exists("posts", $visibility) && $visibility["posts"] == "show") ||
       (is_page() && array_key_exists("pages", $visibility) &&  $visibility["pages"] == "show") ||
       (!is_singular() && array_key_exists("home", $visibility) &&  $visibility["home"] == "show")
     ) {
    if (get_option("yigg_button_position") == "top") {
      return $button . $content;
    } else {
      return $content . $button;
    }
  }

  return $content;
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
		'url' => get_permalink(),
		'type' => 'simple',
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
    <script src='http://yigg.de/js/embed_".$var."button.js'></script>
  </div>";

	return $html;
}