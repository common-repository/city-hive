<?php

  add_action( 'admin_menu', 'city_hive_menu' );

  function city_hive_menu() {
    add_options_page('City Hive Settings', 'City Hive Settings', 'manage_options', __FILE__, 'city_hive_settings_page');

    add_action( 'admin_init', 'register_mysettings' );
  }

  function register_mysettings() {
    register_setting( 'city-hive-settings-group', 'show_in_multiple_posts_pages');
    register_setting( 'city-hive-settings-group', 'api-key' );
  }

	//Add setting link on plugin page
  $plugin = plugin_basename(CITY_DIR . '/city-hive.php');
	add_filter( "plugin_action_links_$plugin", 'cityhive_plugin_settings_link' );

	function cityhive_plugin_settings_link($links) {
	 $mylinks = array(
	 '<a href="' . admin_url( 'options-general.php?page=city-hive%2Fcity-hive-settings-menu.php' ) . '">Settings</a>',
	 );
	return array_merge( $links, $mylinks );
	}
?>
