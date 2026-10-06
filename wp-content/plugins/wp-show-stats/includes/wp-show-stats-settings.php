<?php

function wp_show_stats_settings() {
  if (isset($_POST['action']) && $_POST['action'] == 'wp_show_stats_form_update') {

      // Save Settings
      $wp_show_stats_settings = array('roles_can_see' => array(), 'can_see_only_their' => '');

      foreach ($wp_show_stats_settings as $key => $value) {

          $field_key = 'wp_show_stats_' . $key;
          // Check field data
          if (isset($_POST[$field_key]) && count($_POST[$field_key]) > 0) {
              $wp_show_stats_settings[$key] = $_POST[$field_key];
          } else {
              $error_flag = TRUE;
          }
      }
      update_option('wp_show_stats_settings', serialize($wp_show_stats_settings));
    }
  ?>
    <div class="wrap">
        <h2>WP Show Stats - To keep an eye on your usage of WordPress elements</h2>
        <div class="stat-charts-main">
          <form id="wp_show_stats_form" novalidate="novalidate" action="?page=wp_show_stats_settings" method="post">
              <input type="hidden" value="wp_show_stats_form_update" name="action">
              <div class="setting-content">
                  <h3> WP Show Stats Settings </h3>
                  <div class="inside">

                      <table class="form-table">
                          <tbody>
                              <tr>
                                  <th scope="row"><label for="roles_can_see">Who should see this plugin?</label></th>
                                  <td>
                                    <?php $all_editable_roles = get_editable_roles();
                                      $wp_show_stats_settings = unserialize(get_option('wp_show_stats_settings'));
                                    ?>
                                    <?php foreach ($all_editable_roles as $key => $role) {
                                      if($key == 'administrator'):
                                        continue;
                                      endif;
                                       ?>
                                        <input type="checkbox" class="regular-text" value="<?php echo $key; ?>" name="wp_show_stats_roles_can_see[]" <?php echo (isset($wp_show_stats_settings['roles_can_see']) && in_array($key, $wp_show_stats_settings['roles_can_see'])) ? "checked='checked'" : ''; ?>> <?php echo $role['name']; ?> <br/>
                                    <?php } ?>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                      <p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit"></p>
                  </div>
              </div>
          </form>
        </div>
    </div>
    <?php include_once('wp-show-stats-sidebar.php'); ?>
<?php } ?>
