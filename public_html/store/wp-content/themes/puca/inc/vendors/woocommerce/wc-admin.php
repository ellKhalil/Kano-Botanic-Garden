<?php

if( !puca_is_woocommerce_activated() ) return;

// First Register the Tab by hooking into the 'woocommerce_product_data_tabs' filter
if (! function_exists('puca_add_custom_product_data_tab')) {
  add_filter('woocommerce_product_data_tabs', 'puca_add_custom_product_data_tab', 80);
  function puca_add_custom_product_data_tab($product_data_tabs)
  {
      $product_data_tabs['puca-options-tab'] = array(
        'label' => esc_html__('Puca Options', 'puca'),
        'target' => 'puca_product_data',
        'class'     => array(),
        'priority' => 99,
    );
      return $product_data_tabs;
  }
}

/*Add video to product detail*/
if ( !function_exists('puca_options_woocom_product_data_fields') ) {
    add_action( 'woocommerce_product_data_panels', 'puca_options_woocom_product_data_fields' );
  
    function puca_options_woocom_product_data_fields(){
  
      $args_video = apply_filters( 'puca_tbay_woocommerce_simple_url_video_args', array(
          'id' => '_video_url',
          'label' => esc_html__('Featured Video URL', 'puca'),
          'placeholder' => esc_html__('Video URL', 'puca'),
          'desc_tip' => true,
          'description' => esc_html__('Enter the video url at https://vimeo.com/ or https://www.youtube.com/', 'puca'))
      );
      $args_size_guide_type =  apply_filters( 'puca_tbay_woo_size_guide_type_args', array(
        'id'          => '_puca_size_guide_type',
        'label'       => esc_html__( 'Size Guide Type', 'puca' ),
        'options'     => array(
          'global'     => esc_html__( 'Global Setting', 'puca' ),
          'customize' => esc_html__( 'Customize', 'puca' ),
        ),
        'desc_tip'    => true,
        'description' => esc_html__( 'Global Setting is to choose Size Guide on the theme option', 'puca' ),
      ));

      $args_size_guide =  apply_filters( 'puca_tbay_woo_size_guide_args', array(
        'id'          => '_puca_size_guide', 
        'desc_tip'    => true,
        'label'       => esc_html__( 'Size Guide Customize', 'puca' ),
        'description' => esc_html__( 'Enter an optional shortcode or cusom text', 'puca' ),
        'wrapper_class'     => 'show_size_guide_customize',
      ));

      $args_delivery_type =  apply_filters( 'puca_tbay_woo_delivery_return_type_args', array(
        'id'          => '_puca_delivery_return_type',
        'label'       => esc_html__( 'Delivery Return Type', 'puca' ),
        'options'     => array(
          'global'     => esc_html__( 'Global Setting', 'puca' ),
          'customize' => esc_html__( 'Customize', 'puca' ),
        ),
        'desc_tip'    => true,
        'description' => esc_html__( 'Global Setting is to choose Delivery Return on the theme option', 'puca' ),
      ));

      $args_delivery =  apply_filters( 'puca_tbay_woo_delivery_return_args', array(
        'id'          => '_puca_delivery_return', 
        'desc_tip'    => true,
        'label'       => esc_html__( 'Delivery Return Customize', 'puca' ),
        'description' => esc_html__( 'Enter an optional shortcode or cusom text', 'puca' ),
        'wrapper_class'     => 'show_delivery_return_customize',
      ));
  
      echo '<div id="puca_product_data" class="panel woocommerce_options_panel"><div class="options_group">';
  
      ?>
      <div class="options_group">
      <?php
      woocommerce_wp_text_input( $args_video ) ;
      ?>
      </div><div class="options_group">
      <?php
        woocommerce_wp_select($args_size_guide_type); 

        woocommerce_wp_textarea_input( $args_size_guide );
      ?>
      </div><div class="options_group">
      <?php
        woocommerce_wp_select($args_delivery_type); 

        woocommerce_wp_textarea_input( $args_delivery ) ;
      ?>
      </div>
      <?php


      do_action( 'puca_woocommerce_options_product_data' );
      echo '</div></div>';
    }
  }
  
  if ( !function_exists('puca_options_woocom_save_proddata_custom_fields') ) {
    add_action( 'woocommerce_admin_process_product_object', 'puca_options_woocom_save_proddata_custom_fields', 10, 1 );
    function puca_options_woocom_save_proddata_custom_fields( $product ) {
        $video_url = isset($_POST['_video_url']) ? wp_unslash($_POST['_video_url']) : '';
        $old_value_url = $product->get_meta('_video_url');
 
        if ($video_url !== $old_value_url) {
          $product->update_meta_data('_video_url', $video_url);
        }

        $size_guide_type           = isset($_POST['_puca_size_guide_type']) ? wp_unslash($_POST['_puca_size_guide_type']) : '';
        $old_size_guide_type       = $product->get_meta('_puca_size_guide_type');

        $size_guide                = isset($_POST['_puca_size_guide']) ? wp_unslash($_POST['_puca_size_guide']) : '';
        $old_size_guide            = $product->get_meta('_puca_size_guide');

        $delivery_return_type                = isset($_POST['_puca_delivery_return_type']) ? wp_unslash($_POST['_puca_delivery_return_type']) : '';
        $old_delivery_return_type            = $product->get_meta('_puca_delivery_return_type');
        
        $delivery_return                = isset($_POST['_puca_delivery_return']) ? wp_unslash($_POST['_puca_delivery_return']) : '';
        $old_delivery_return            = $product->get_meta('_puca_delivery_return');

        if ($size_guide_type !== $old_size_guide_type) {
          $product->update_meta_data('_puca_size_guide_type', $size_guide_type);
        }

        if ($size_guide !== $old_size_guide) {
          $product->update_meta_data('_puca_size_guide', $size_guide);
        }

        if ($delivery_return_type !== $old_delivery_return_type) {
          $product->update_meta_data('_puca_delivery_return_type', $delivery_return_type);
        }
 
        if ($delivery_return !== $old_delivery_return) {
          $product->update_meta_data('_puca_delivery_return', $delivery_return);
        }

    }
  }
  
  if ( !function_exists('puca_tbay_VideoUrlType') ) {
    function puca_tbay_VideoUrlType($url) {
  
  
        $yt_rx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
        $has_match_youtube = preg_match($yt_rx, $url, $yt_matches);
  
  
        $vm_rx = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/';
        $has_match_vimeo = preg_match($vm_rx, $url, $vm_matches);
  
  
        //Then we want the video id which is:
        if($has_match_youtube) {
            $video_id = $yt_matches[5]; 
            $type = 'youtube';
        }
        elseif($has_match_vimeo) {
            $video_id = $vm_matches[5];
            $type = 'vimeo';
        }
        else {
            $video_id = 0;
            $type = 'none';
        }
  
  
        $data['video_id'] = $video_id;
        $data['video_type'] = $type;
  
        return $data;
    }
  }
  
  if ( !function_exists('puca_tbay_get_video_product') ) {
    add_action( 'tbay_product_video', 'puca_tbay_get_video_product', 10 );
    function  puca_tbay_get_video_product() {
      global $product;
   
  
      if( get_post_meta( $product->get_id(), '_video_url', true ) ) {
        $video = puca_tbay_VideoUrlType(get_post_meta( $product->get_id(), '_video_url', true ));
  
        if( $video['video_type'] == 'youtube' ) {
          $url  = 'https://www.youtube.com/embed/'.$video['video_id'].'?autoplay=1';
          $icon = '<i class="fa fa-youtube-play" aria-hidden="true"></i>'.esc_html__('View Video','puca');
  
        }elseif(( $video['video_type'] == 'vimeo' )) {
          $url = 'https://player.vimeo.com/video/'.$video['video_id'].'?autoplay=1';
          $icon = '<i class="fa fa-vimeo-square" aria-hidden="true"></i>'.esc_html__('View Video','puca');
  
        }
  
      }
  
      ?>
  
      <?php if( !empty($url) ) : ?>
  
        <div class="modal fade" id="productvideo">
          <div class="modal-dialog">
            <div class="modal-content tbay-modalContent">
  
              <div class="modal-body">
                
                <div class="close-button">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item"></iframe>
                </div>
              </div>
  
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
  
        <button type="button" class="tbay-modalButton" data-toggle="modal" data-tbaySrc="<?php echo esc_attr($url); ?>" data-tbayWidth="640" data-tbayHeight="480" data-target="#productvideo"  data-tbayVideoFullscreen="true"><?php echo trim($icon); ?></button>
  
      <?php endif; ?>
    <?php
    }
  }
  

/**
 * ------------------------------------------------------------------------------------------------
 * Dropdown
 * ------------------------------------------------------------------------------------------------
 */
//Dropdown template
if (! function_exists('puca_swatch_attribute_template')) {
    function puca_swatch_attribute_template($post)
    {
        global $post;


        $attribute_post_id = get_post_meta($post->ID, '_puca_attribute_select');
        $attribute_post_id = isset($attribute_post_id[0]) ? $attribute_post_id[0] : ''; ?>

          <select name="puca_attribute_select" class="puca_attribute_taxonomy">
            <option value="" selected="selected"><?php esc_html_e('Global Setting', 'puca'); ?></option>

              <?php
                // Array of defined attribute taxonomies.
                $attribute_taxonomies = wc_get_attribute_taxonomies();

                if (! empty($attribute_taxonomies)) {
                    foreach ($attribute_taxonomies as $tax) {
                        $attribute_taxonomy_name = wc_attribute_taxonomy_name($tax->attribute_name);
                        $label                   = $tax->attribute_label ? $tax->attribute_label : $tax->attribute_name;

                        echo '<option value="' . esc_attr($attribute_taxonomy_name) . '" '. selected($attribute_post_id, $attribute_taxonomy_name) .' >' . esc_html($label) . '</option>';
                    }
                } ?>
          </select>

        <?php
    }
}


//Dropdown Save
if (! function_exists('puca_attribute_dropdown_save')) {
    add_action('woocommerce_process_product_meta', 'puca_attribute_dropdown_save', 30, 2);

    function puca_attribute_dropdown_save($post_id)
    {
        if (isset($_POST['puca_attribute_select'])) {
            update_post_meta($post_id, '_puca_attribute_select', $_POST['puca_attribute_select']);
        }
    }
}