<?php
// write the content for our settings page that allows you to define your endpoints
function yigg_add_settings_page() { ?>
  <div class="wrap">
  <h2>YiGG Settings</h2>
  
  <p>maunz!</p>
  
  <form method="post" action="options.php">
  <?php //wp_nonce_field('update-options'); ?>
  <!-- starting -->
  <?php settings_fields('yigg_settings_group'); ?>
  <?php do_settings_sections('yigg_settings_section'); ?>
  <!-- ending -->
  
  <?php
  $yigg_button_visibility = get_option('yigg_button_visibility');
  ?>
  
  <h3>Button visibility</h3>
  
  <table class="form-table">

  <tr valign="top">
  <th scope="row"><label for="yigg_button_position">Show</label></th>
  <td>
    <select id="yigg_button_position" name="yigg_button_position">
      <option value="bottom" <?php if (get_option('yigg_button_position') == "bottom") { echo 'selected="selected"'; } ?>>after post/page</option>
      <option value="top" <?php if (get_option('yigg_button_position') == "top") { echo 'selected="selected"'; } ?>>before page/post</option>
    </select>
  </td>
  </tr>
  <tr>
    <th scope="row"><label for="yigg_button_visibility_posts">Show on single posts:</label></th>
    <td>
      <input type="checkbox" name="yigg_button_visibility[posts]" id="yigg_button_visibility_posts" value="show" <?php if ($yigg_button_visibility['posts'] == "show") { echo 'checked="checked"'; } ?> />
    </td>
  </tr>
  
  <tr>
    <th scope="row"><label for="yigg_button_visibility_pages">Show on single pages:</label></th>
    <td>
      <input type="checkbox" name="yigg_button_visibility[pages]" id="yigg_button_visibility_pages" value="show" <?php if ($yigg_button_visibility['pages'] == "show") { echo 'checked="checked"'; } ?> />
    </td>
  </tr>
  
  <tr>
    <th scope="row"><label for="yigg_button_visibility_home">Show on overview pages (home, archives, search, ...):</label></th>
    <td>
      <input type="checkbox" name="yigg_button_visibility[home]" id="yigg_button_visibility_home" value="show" <?php if ($yigg_button_visibility['home'] == "show") { echo 'checked="checked"'; } ?> />
    </td>
  </tr>
  
  </table>
  
  <h3>Button Type</h3>
  
  <table class="form-table">
  
  <tr>
    <th scope="row"><label for="yigg_button_type">Show:</label></th>
    <td>
      <select id="yigg_button_type" name="yigg_button_type">
        <option value="small" <?php if (get_option('yigg_button_type') == "small") { echo 'selected="selected"'; } ?>>small button</option>
        <option value="big" <?php if (get_option('yigg_button_type') == "big") { echo 'selected="selected"'; } ?>>big button</option>
      </select>
    </td>
  </tr>

  </table>

  <input type="hidden" name="action" value="update" />
  <input type="hidden" name="page_options" value="pubsub_endpoints" />

  <p class="submit">
  <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
  </p>

  </form>
</div>

<?php }

// add a link to our settings page in the WP menu
function yigg_add_plugin_menu() {
  add_options_page('YiGG Settings', 'YiGG', 'administrator', __FILE__, 'yigg_add_settings_page');
}
add_action('admin_menu', 'yigg_add_plugin_menu');

// add a settings link next to deactive / edit
function yigg_add_settings_link( $links, $file ) {
  if( $file == 'yigg/yigg.php' && function_exists( "admin_url" ) ) {
    $settings_link = '<a href="' . admin_url( 'options-general.php?page=yigg/yigg' ) . '">' . __('Settings') . '</a>';
    array_unshift( $links, $settings_link ); // before other links
  }
  return $links;
}
add_filter('plugin_action_links', 'yigg_add_settings_link', 10, 2);

// keep WPMU happy
function yigg_register_settings() {
  register_setting('yigg_settings_group','yigg_button_type');
  register_setting('yigg_settings_group','yigg_button_position');
  register_setting('yigg_settings_group','yigg_button_visibility');
}
add_action('admin_init', 'yigg_register_settings');