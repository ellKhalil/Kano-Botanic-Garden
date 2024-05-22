<?php

if ( !function_exists( 'puca_tbay_post_metaboxes' ) ) {
    function puca_tbay_post_metaboxes() {
        $prefix = 'tbay_post_';

        $cmb2 = new_cmb2_box( array(
            'id'                        => 'post_format_standard_post_meta',
            'title'                     => esc_html__( 'Format Setting', 'puca' ),
            'object_types'              => array( 'post' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'autosave'                  => true,
        ) );


        $cmb2->add_field( array(
            'id'   => "{$prefix}gallery_files",
            'name' => esc_html__( 'Images Gallery', 'puca' ),
            'type' => 'file_list',
        ) );

        $cmb2->add_field( array(
            'id'   => "{$prefix}video_link",
            'name' => esc_html__( 'Video Link', 'puca' ),
            'type' => 'oembed',
        ) );

        $cmb2->add_field( array(
            'id'   => "{$prefix}link_text",
            'name' => esc_html__( 'Link Text', 'puca' ),
            'type' => 'text',
        ) );

        $cmb2->add_field( array(
            'id'   => "{$prefix}link_link",
            'name' => esc_html__( 'Link To Redirect', 'puca' ),
            'type' => 'text_url',
        ) );


        $cmb2->add_field( array(
            'id'   => "{$prefix}audio_link",
            'name' => esc_html__( 'Audio Link', 'puca' ),
            'type' => 'oembed',
        ) );


    }
    add_action( 'cmb2_admin_init', 'puca_tbay_post_metaboxes', 20 );
}


if ( !function_exists( 'puca_tbay_standard_post_meta' ) ) {
    function puca_tbay_standard_post_meta( $post_id ){
            
        global $post; 
        $prefix = 'tbay_post_';
        $type = get_post_format();

        $old = array(
            'gallery_files',
            'video_link',
            'link_text',
            'link_link',
            'audio_link',
        );
        
        $data = array( 'gallery' => array('gallery_files'), 
                       'video' =>  array('video_link'), 
                       'audio' =>  array('audio_link'), 
                       'link' => array('link_link','link_text') ); 

        $new = array();

        if( isset($data[$type]) ){
            foreach( $data[$type] as $key => $value ){
                $new[$prefix.$value] = $_POST[$prefix.$value];
            }
        }


        foreach( $old as $key => $value ){
            if( isset($_POST[$prefix.$value]) ){
                unset( $_POST[$prefix.$value] );
            }
        }
        if( $new ){
            $_POST = array_merge( $_POST, $new );
        }

    }
    add_action( "cmb2_meta_post_format_standard_post_meta_before_save_post", 'puca_tbay_standard_post_meta' , 9  );
}