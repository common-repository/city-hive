<?php

  function city_hive_settings_page() {
    global $CITY_HIVE_SETTINGS;
    ?>
  <div class="wrap">

	<div id="icon-options-general" class="icon32"></div>
	<h1><?php esc_attr_e( 'City Hive', 'wp_admin_style' ); ?></h1>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<h2><span><?php esc_attr_e( 'Get your API key', 'wp_admin_style' ); ?></span></h2>

						<div class="inside">
              <div id="col-container">
                <div id="col-right">
                  <div class="col-wrap">
                    <div class="inside">
                      <p><a class="button-primary" target="_blank" href="<?php echo $CITY_HIVE_SETTINGS["api_key_url"]; ?>" title="<?php esc_attr_e( 'Title for Example Link Button' ); ?>"><?php esc_attr_e( 'Get your API key' ); ?></a></p>
                    </div>
                  </div>
                  <!-- /col-wrap -->
                </div>
                <!-- /col-right -->
                <div id="col-left">
                  <div class="col-wrap">
                    <div class="inside">
                      <p><?php esc_attr_e('Sign up to get your API key: '); ?> </p>
                    </div>
                  </div>
                  <!-- /col-wrap -->
                </div>
                <!-- /col-left -->
              </div>
              <!-- /col-container -->
						</div>
						<!-- .inside -->
					</div>
					<!-- .postbox -->
				</div>
				<!-- .meta-box-sortables .ui-sortable -->
			</div>
			<!-- post-body-content -->
			<!-- sidebar -->
    			<div id="post-body-content">

    				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<h2><span><?php esc_attr_e(
									'Enter your API key', 'wp_admin_style'
								); ?></span></h2>

						<div class="inside">
              <div id="col-container">
                <div id="col-right">
            			<div class="col-wrap">
            				<div class="inside">
                      <form method="post" action="options.php">
                        <?php settings_fields( 'city-hive-settings-group' ); ?>
                        <?php do_settings_sections( 'api-key' ); ?>
                        <input type='text' maxlength="32" size="40" name='api-key' value="<?php echo get_option( 'api-key' )?>" />
            				</div>
            			</div>
            			<!-- /col-wrap -->
            		</div>
            		<!-- /col-right -->
            		<div id="col-left">
            			<div class="col-wrap">
            				<div class="inside">
                      <?php esc_attr_e('Your key: '); ?>
            				</div>
            			</div>
            			<!-- /col-wrap -->
            		</div>
            		<!-- /col-left -->
            	</div>
            	<!-- /col-container -->
						</div>
						<!-- .inside -->
					</div>
					<!-- .postbox -->
				</div>
				<!-- .meta-box-sortables -->
			</div>
      <!-- sidebar -->
          <div id="post-body-content">

            <div class="meta-box-sortables ui-sortable">

          <div class="postbox">

            <h2><span><?php esc_attr_e(
                  'Multiple posts', 'wp_admin_style'
                ); ?></span></h2>

            <div class="inside">
              <div id="col-container">
                <div id="col-right">
                  <div class="col-wrap">
                    <div class="inside">
                        <?php do_settings_sections( 'city-hive-settings-group' ); ?>
                        <input type="checkbox" name="show_in_multiple_posts_pages" value="true" <?php echo (get_option('show_in_multiple_posts_pages') === 'true') ? 'checked' : '' ?> />
                    </div>
                  </div>
                  <!-- /col-wrap -->
                </div>
                <!-- /col-right -->
                <div id="col-left">
                  <div class="col-wrap">
                    <div class="inside">
                      <p><?php esc_attr_e('Show City Hive widget on pages showing multiple posts? ', 'wp_admin_style'); ?></p>
                    </div>
                  </div>
                  <!-- /col-wrap -->
                </div>
                <!-- /col-left -->
              </div>
              <!-- /col-container -->
            </div>
            <!-- .inside -->
          </div>
          <!-- .postbox -->
        </div>
        <!-- .meta-box-sortables -->
      </div>
			<!-- #postbox-container-1 .postbox-container -->
		</div>
		<!-- #post-body .metabox-holder .columns-2 -->
		<br class="clear">
	</div>
	<!-- #poststuff -->
</div> <!-- .wrap -->
<?php submit_button(); ?>
</form>
    <?php
  }
?>
