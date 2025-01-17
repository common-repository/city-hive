<?php

  /**
   * Register meta box(es).
   */
  function city_hive_register_meta_boxes() {
      add_meta_box( 'city-hive-meta-box', 'City Hive Products', 'city_hive_metabox_display', 'post', 'side', 'high');
      add_meta_box( 'city-hive-meta-box', 'City Hive Products', 'city_hive_metabox_display', 'page', 'side', 'high');
  }
  // Add box to post editor
  add_action( 'add_meta_boxes', 'city_hive_register_meta_boxes' );

  /**
   * Meta box display callback.
   *
   * @param WP_Post $post Current post object.
   */
  function city_hive_metabox_display( $post ) {
    global $CITY_HIVE_SETTINGS;
    wp_nonce_field( 'city-hive-meta-box', 'city_hive_meta_box_nonce' );

    $value = get_post_meta( $post->ID, $CITY_HIVE_SETTINGS["products_metadata_name"], true );
    $related_value = get_post_meta( $post->ID, $CITY_HIVE_SETTINGS["related_products_metadata_name"], true );
    $related_producers_value = get_post_meta( $post->ID, $CITY_HIVE_SETTINGS["producers_metadata_name"], true );
    $noshow_product = get_post_meta($post->ID,$CITY_HIVE_SETTINGS["products_noshow_meta"],true);
    if ($noshow_product==='true'){
      $boxChecked  = 'checked';
    } else {$boxChecked  = '';}

?>
    <p>
        <label for="city_hive_search_products">Search products</label>
        <input type="text" id="city_hive_product_field" name="city_hive_product_field" size="25" placeholder="Products"/>
    </p>
    <p>
        <label for="city_hive_selected_products">Products mentioned in this post:</label>
        <div id="city_hive_selected_products"></div>
        <input type="text" id="city_hive_products_hidden" name="city_hive_products_hidden" style="display: none"/>
    </p>
    <p>
        <label for="city_hive_producers">Producers related to this post: (beta)</label>
        <div id="city_hive_selected_producers"></div>
        <input type="text" class= "typeahead tt-input" id="city_hive_producers_field" name="city_hive_producers_field" size="25" placeholder="Producers" />
        <input type="text" id="city_hive_producers_hidden" name="city_hive_producers_hidden" style="display: none"/>
    </p>
    <p>
        <label for="city_hive_related_product">Products related to this post:</label>
        <input type="text" id="city_hive_related_product_field" name="city_hive_related_product_field" size="25" placeholder="Related products" />
        <input type="text" id="city_hive_related_products_hidden" name="city_hive_related_products_hidden" style="display: none"/>
        <div id="city_hive_related_selected_products"></div>
    </p>

     <p>
        <input class="checkbox" <?= $boxChecked ?> type="checkbox" id="city_hive_noshow_products_checkbox" name="city_hive_noshow_products_checkbox" />
        <label for="city_hive_noshow_products_checkbox">don't show products for this post (beta)</label>
    </p>

     <script>
      /* global initCityHiveProducts */
      initCityHiveProducts('#city_hive_product_field', '#city_hive_selected_products', '#city_hive_products_hidden', <?= json_encode($value) ?>);
      initCityHiveProducts('#city_hive_related_product_field', '#city_hive_related_selected_products', '#city_hive_related_products_hidden', <?= json_encode($related_value) ?>);
      initCityHiveProducts('#city_hive_producers_field', '#city_hive_selected_producers', '#city_hive_producers_hidden', <?= json_encode($related_producers_value) ?>);

    </script>
    <div>
     <p><a href=" <?php echo get_permalink(); ?>?city-hive-staging?city-hive-office" class="button button-small">View <?php echo get_post_type($post)?> with City Hive widget</a></p>
    </div>

<?php
  }

  /**
   * Save meta box content.
   *
   * @param int $post_id Post ID
   */
  function city_hive_save_meta_box( $post_id ) {
      global $CITY_HIVE_SETTINGS;
      // Check if our nonce is set.
      if ( ! isset( $_POST['city_hive_meta_box_nonce'] ) ) {
        return;
      }

      // Verify that the nonce is valid.
      if ( ! wp_verify_nonce( $_POST['city_hive_meta_box_nonce'], 'city-hive-meta-box' ) ) {
        return;
      }

      // If this is an autosave, our form has not been submitted, so we don't want to do anything.
      if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
      }

      // Check the user's permissions.
      if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
          return;
        }

      } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
          return;
        }
      }

      // Make sure that it is set.
      if ( ! isset( $_POST['city_hive_products_hidden'] ) ) {
        return;
      }

      $data = json_decode(stripcslashes($_POST['city_hive_products_hidden']));

      // Update the meta field in the database.
      update_post_meta( $post_id, $CITY_HIVE_SETTINGS["products_metadata_name"], $data );

      $related_data = json_decode(stripcslashes($_POST['city_hive_related_products_hidden']));

      // Update the meta field in the database.
      update_post_meta( $post_id, $CITY_HIVE_SETTINGS["related_products_metadata_name"], $related_data );

      $producers_data = json_decode(stripcslashes($_POST['city_hive_producers_hidden']));
      // Update the meta field in the database.
      update_post_meta( $post_id, $CITY_HIVE_SETTINGS["producers_metadata_name"], $producers_data);

      // Update the meta field in the database.
      if (isset($_POST['city_hive_noshow_products_checkbox'])) {
          update_post_meta( $post_id, $CITY_HIVE_SETTINGS["products_noshow_meta"], "true");
      } else {

          update_post_meta( $post_id, $CITY_HIVE_SETTINGS["products_noshow_meta"], "false");
      }




  }
  // Handle post save (Save selected products in post metadata)
  add_action('save_post', 'city_hive_save_meta_box' );


  function city_hive_scripts_method() {
    wp_enqueue_script(
      'city_hive_typeahead_plugin',
      plugins_url( '/js/typeahead.bundle.min.js' , __FILE__ ),
      array( 'jquery' )
    );

    wp_enqueue_script(
       'city_hive_handlebars_templating',
          plugins_url( '/js/handlebars.js' , __FILE__ ),
          array( 'jquery' )
    );

    wp_enqueue_script(
      'city_hive_products',
      plugins_url( '/js/products.js' , __FILE__ ),
      array( 'jquery' )
    );

     wp_enqueue_script(
         'city_hive_producers',
         plugins_url( '/js/producers.js' , __FILE__ ),
         array( 'jquery' )
     );

    wp_enqueue_style(
      'city_hive_typeahead_style',
      plugins_url( '/css/typeahead.css' , __FILE__ ));

  }

  // add required js scripts used by box
  add_action( 'admin_enqueue_scripts', 'city_hive_scripts_method' );

?>
