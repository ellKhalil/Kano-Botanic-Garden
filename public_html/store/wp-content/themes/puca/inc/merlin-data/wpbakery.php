<?php

class Puca_Merlin_Wpbakery {
	public function import_files_wpb_vc_fashion_v1(){
		$prefix_name = 'WPBakery';
		$prefix 	 = 'wpbakery';
		$skin_name 	 = 'Fashion 1';
		$skin 		 = 'fashion1';
		$rev_sliders = [
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-home1.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-home2.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-home3.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-home4.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-home5.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-home6.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-home7.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-home9.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-home10.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-home10-2.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-home-11.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-home13.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-home14.zip",
		];

		$data_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/data.xml";
		$widget_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/widgets.wie";

		return array(
			array(
				'import_file_name'           => 'Home 1',
				'home'                       => 'home',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca/',
				'group_label_start'          => 'yes',
				'group_label_name'           => $prefix_name.' '. $skin_name,
			),
			array(
				'import_file_name'           => 'Home 2',
				'home'                       => 'home-2',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca/',
			),
			array(
				'import_file_name'           => 'Home 3',
				'home'                       => 'home-3',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca/',
			),
			array(
				'import_file_name'           => 'Home 4',
				'home'                       => 'home-4',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home4/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home4/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca/home-4/',
			),
			array(
				'import_file_name'           => 'Home 5',
				'home'                       => 'home-5',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home5/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home5/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca/home-5/',
			),
			array(
				'import_file_name'           => 'Home 6',
				'home'                       => 'home-6',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home6/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home6/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca/home-6/',
			),
			array(
				'import_file_name'           => 'Home 7',
				'home'                       => 'home-7',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home7/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home7/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca/home-7/',
			),
			array(
				'import_file_name'           => 'Home 8',
				'home'                       => 'home-8',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home8/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home8/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca/home-8/',
			),
			array(
				'import_file_name'           => 'Home 9',
				'home'                       => 'home-9',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home9/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home9/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca/home-9/',
			),
			array(
				'import_file_name'           => 'Home 10',
				'home'                       => 'home-10',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home10/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home10/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca/home-10/',
			),
			array(
				'import_file_name'           => 'Home 11',
				'home'                       => 'home-11',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home11/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home11/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca/home-11/',
			),
			array(
				'import_file_name'           => 'Home 12',
				'home'                       => 'home-12',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home12/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home12/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca/home-12/',
			),
			array(
				'import_file_name'           => 'Home 13',
				'home'                       => 'home-13',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home13/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home13/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca/home-13/',
			),
			array(
				'import_file_name'           => 'Home 14',
				'home'                       => 'home-14',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home14/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home14/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca/home-14/',
				'group_label_end'          => 'yes',
			),
		);
	}

	public function import_files_wpb_vc_fashion_v2(){
		$prefix_name = 'WPBakery';
		$prefix 	 = 'wpbakery';
		$skin 		 = 'fashion2';
		$skin_name 	 = 'Fashion 2';

		$rev_sliders = [
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion2-home1.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-2-home-2.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-2-home-3.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-2-home-4.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-2-home-7.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-2-home-8.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/fashion-2-home-9.zip",
		];

		$data_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/data.xml";
		$widget_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/widgets.wie";


		return array(
			array(
				'import_file_name'           => 'Home 1',
				'home'                       => 'home',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_fashion2/',
				'group_label_start'          => 'yes',
				'group_label_name'          => $prefix_name.' '. $skin_name,
			),
			array(
				'import_file_name'           => 'Home 2',
				'home'                       => 'home-2',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_fashion2/home-2/',
			),
			array(
				'import_file_name'           => 'Home 3',
				'home'                       => 'home-3',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_fashion2/home-3/',
			),
			array(
				'import_file_name'           => 'Home 4',
				'home'                       => 'home-4',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home4/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home4/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_fashion2/home-4/',
			),
			array(
				'import_file_name'           => 'Home 5',
				'home'                       => 'home-5',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home5/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home5/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_fashion2/home-5/',
			),
			array(
				'import_file_name'           => 'Home 6',
				'home'                       => 'home-6',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home6/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home6/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_fashion2/home-6/',
			),
			array(
				'import_file_name'           => 'Home 7',
				'home'                       => 'home-7',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home7/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home7/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_fashion2/home-7/',
			),
			array(
				'import_file_name'           => 'Home 8',
				'home'                       => 'home-8',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home8/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home8/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_fashion2/home-8/',
			),
			array(
				'import_file_name'           => 'Home 9',
				'home'                       => 'home-9',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home9/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home9/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_fashion2/home-9/',
				'group_label_end'          => 'yes',
			),
		);
	}

	public function import_files_wpb_vc_smarket_v1(){
		$prefix_name = 'WPBakery';
		$prefix 	 = 'wpbakery';
		$skin 		 = 'smarket1';
		$skin_name 	 = 'Smarket 1';

		$rev_sliders = [
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home1.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home2.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home3.zip",
		];

		$data_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/data.xml";
		$widget_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/widgets.wie";

		return array(
			array(
				'import_file_name'           => 'Home 1',
				'home'                       => 'home',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket/',
				'group_label_start'          => 'yes',
				'group_label_name'          => $prefix_name.' '. $skin_name,
			),
			array(
				'import_file_name'           => 'Home 2',
				'home'                       => 'home-2',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket/home-2',
			),
			array(
				'import_file_name'           => 'Home 3',
				'home'                       => 'home-3',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket/home-3',
				'group_label_end'          => 'yes',
			),
		);
	}

	public function import_files_wpb_vc_smarket_rtl(){
		$prefix_name = 'WPBakery';
		$prefix 	 = 'wpbakery';
		$skin 		 = 'smarket-rtl';
		$skin_name 	 = 'Smarket RTL';

		$rev_sliders = [
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home1.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home2.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home3.zip",
		];

		$data_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/data.xml";
		$widget_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/widgets.wie";

		return array(
			array(
				'import_file_name'           => 'Home 1',
				'home'                       => 'home',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_rtl/',
				'group_label_start'          => 'yes',
				'group_label_name'          => $prefix_name.' '. $skin_name,
			),
			array(
				'import_file_name'           => 'Home 2',
				'home'                       => 'home-2',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_rtl/home-2',
			),
			array(
				'import_file_name'           => 'Home 3',
				'home'                       => 'home-3',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_rtl/home-3',
				'group_label_end'          => 'yes',
			),
		);
	}


	public function import_files_wpb_vc_smarket_dokan(){
		$prefix_name = 'WPBakery';
		$prefix 	 = 'wpbakery';
		$skin 		 = 'marketplace-dokan';
		$skin_name 	 = 'Marketplace Dokan';

		$rev_sliders = [
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home1.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home2.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home3.zip",
		];

		$data_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/data.xml";
		$widget_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/widgets.wie";

		return array(
			array(
				'import_file_name'           => 'Home 1',
				'home'                       => 'home',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket/',
				'group_label_start'          => 'yes',
				'group_label_name'          => $prefix_name.' '. $skin_name,
			),
			array(
				'import_file_name'           => 'Home 2',
				'home'                       => 'home-2',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket/home-2',
			),
			array(
				'import_file_name'           => 'Home 3',
				'home'                       => 'home-3',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket/home-3',
				'group_label_end'          => 'yes',
			),
		);
	}

		
	public function import_files_wpb_vc_smarket_wcfm(){
		$prefix_name = 'WPBakery';
		$prefix 	 = 'wpbakery';
		$skin 		 = 'marketplace-wcfm';
		$skin_name 	 = 'Marketplace WCFM';

		$rev_sliders = [
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home1.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home2.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home3.zip",
		];

		$data_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/data.xml";
		$widget_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/widgets.wie";

		return array(
			array(
				'import_file_name'           => 'Home 1',
				'home'                       => 'home',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket/',
				'group_label_start'          => 'yes',
				'group_label_name'          => $prefix_name.' '. $skin_name,
			),
			array(
				'import_file_name'           => 'Home 2',
				'home'                       => 'home-2',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket/home-2',
			),
			array(
				'import_file_name'           => 'Home 3',
				'home'                       => 'home-3',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket/home-3',
				'group_label_end'          => 'yes',
			),
		);
	}

	public function import_files_wpb_vc_smarket_mvx(){
		$prefix_name = 'WPBakery';
		$prefix 	 = 'wpbakery';
		$skin 		 = 'marketplace-mvx';
		$skin_name   = 'Marketplace WCMP';

		$rev_sliders = [
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home1.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home2.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home3.zip",
		];

		$data_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/data.xml";
		$widget_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/widgets.wie";

		return array(
			array(
				'import_file_name'           => 'Home 1',
				'home'                       => 'home',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket/',
				'group_label_start'          => 'yes',
				'group_label_name'          => $prefix_name.' '. $skin_name,
			),
			array(
				'import_file_name'           => 'Home 2',
				'home'                       => 'home-2',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket/home-2',
			),
			array(
				'import_file_name'           => 'Home 3',
				'home'                       => 'home-3',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket/home-3',
				'group_label_end'          => 'yes',
			),
		);
	}

	public function import_files_wpb_vc_smarket_wcvendors(){
		$prefix_name = 'WPBakery';
		$prefix 	 = 'wpbakery';
		$skin 		 = 'marketplace-wcvendors';
		$skin_name   = 'Marketplace WC Vendors';

		$rev_sliders = [
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home1.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home2.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/smarket-home3.zip",
		];

		$data_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/data.xml";
		$widget_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/widgets.wie";

		return array(
			array(
				'import_file_name'           => 'Home 1',
				'home'                       => 'home',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket/',
				'group_label_start'          => 'yes',
				'group_label_name'          => $prefix_name.' '. $skin_name,
			),
			array(
				'import_file_name'           => 'Home 2',
				'home'                       => 'home-2',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket/home-2',
			),
			array(
				'import_file_name'           => 'Home 3',
				'home'                       => 'home-3',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket/home-3',
				'group_label_end'          => 'yes',
			),
		);
	}

	public function import_files_wpb_vc_smarket_v2(){
		$prefix_name = 'WPBakery';
		$prefix 	 = 'wpbakery';
		$skin 		 = 'smarket2';
		$skin_name   = 'Smarket 2';

		$rev_sliders = [
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/home1.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/home-2.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/home-3.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/home-4.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/home-5.zip",
		];

		$data_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/data.xml";
		$widget_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/widgets.wie";

		return array(
			array(
				'import_file_name'           => 'Home 1',
				'home'                       => 'home',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket2/',
				'group_label_start'          => 'yes',
				'group_label_name'          => $prefix_name.' '. $skin_name,
			),
			array(
				'import_file_name'           => 'Home 2',
				'home'                       => 'home-2',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket2/home-2/',
			),
			array(
				'import_file_name'           => 'Home 3',
				'home'                       => 'home-3',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket2/home-3/',
			),
			array(
				'import_file_name'           => 'Home 4',
				'home'                       => 'home-4',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home4/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home4/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket2/home-4/',
			),
			array(
				'import_file_name'           => 'Home 5',
				'home'                       => 'home-5',
				'import_file_url'          	 => $data_url,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home5/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home5/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_smarket2/home-5/',
				'group_label_end'          => 'yes',
			),
		);
	}

	public function import_files_wpb_vc_furniture(){
		$prefix_name = 'WPBakery';
		$prefix 	 = 'wpbakery';
		$skin 		 = 'furniture';
		$skin_name   = 'Furniture';

		$rev_sliders = [
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio_home_01.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-02.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-03.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-04.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-05.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-06.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-07.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-08.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-09.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-10.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-11.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-12-01.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-12-02.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-12-03.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-14.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-15.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-16.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-17.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-18.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-19.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-20.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-21.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-22.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-23.zip",
			"http://demosamples.thembay.com/puca/${prefix}/${skin}/revslider/ohio-home-24.zip",
		];

		$data_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/data.xml";
		$widget_url = "http://demosamples.thembay.com/puca/${prefix}/${skin}/widgets.wie";

		return array(
			array(
				'import_file_name'           => 'Home 1',
				'home'                       => 'home',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home1/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/',
				'group_label_start'          => 'yes',
				'group_label_name'          => $prefix_name.' '. $skin_name,
			),
			array(
				'import_file_name'           => 'Home 2',
				'home'                       => 'home-2',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home2/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-2/',
			),
			array(
				'import_file_name'           => 'Home 3',
				'home'                       => 'home-3',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home3/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-3/',
			),
			array(
				'import_file_name'           => 'Home 4',
				'home'                       => 'home-4',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home4/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home4/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-4/',
			),
			array(
				'import_file_name'           => 'Home 5',
				'home'                       => 'home-5',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home5/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home5/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-5/',
			),
			array(
				'import_file_name'           => 'Home 6',
				'home'                       => 'home-6',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home6/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home6/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-6/',
			),
			array(
				'import_file_name'           => 'Home 7',
				'home'                       => 'home-7',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home7/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home7/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-7/',
			),
			array(
				'import_file_name'           => 'Home 8',
				'home'                       => 'home-8',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home8/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home8/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-8/',
			),
			array(
				'import_file_name'           => 'Home 9',
				'home'                       => 'home-9',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home9/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home9/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-9/',
			),
			array(
				'import_file_name'           => 'Home 10',
				'home'                       => 'home-10',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home10/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home10/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-10/',
			),
			array(
				'import_file_name'           => 'Home 11',
				'home'                       => 'home-11',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home11/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home11/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-11/',
			),
			array(
				'import_file_name'           => 'Home 12',
				'home'                       => 'home-12',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home12/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home12/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-12/',
			),
			array(
				'import_file_name'           => 'Home 13',
				'home'                       => 'home-13',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home13/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home13/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-13/',
			),
			array(
				'import_file_name'           => 'Home 14',
				'home'                       => 'home-14',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home14/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home14/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-14/',
			),
			array(
				'import_file_name'           => 'Home 15',
				'home'                       => 'home-15',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home15/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home15/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-15/',
			),
			array(
				'import_file_name'           => 'Home 16',
				'home'                       => 'home-16',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home16/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home16/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-16/',
			),
			array(
				'import_file_name'           => 'Home 17',
				'home'                       => 'home-17',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home17/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home17/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-17/',
			),
			array(
				'import_file_name'           => 'Home 18',
				'home'                       => 'home-18',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home18/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home18/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-18/',
			),
			array(
				'import_file_name'           => 'Home 19',
				'home'                       => 'home-19',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home19/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home19/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-19/',
			),
			array(
				'import_file_name'           => 'Home 20',
				'home'                       => 'home-20',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home20/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home20/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-20/',
			),
			array(
				'import_file_name'           => 'Home 21',
				'home'                       => 'home-21',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home21/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home21/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-21/',
			),
			array(
				'import_file_name'           => 'Home 22',
				'home'                       => 'home-22',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home22/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home22/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-22/',
			),
			array(
				'import_file_name'           => 'Home 23',
				'home'                       => 'home-23',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home23/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home23/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-23/',
			),
			array(
				'import_file_name'           => 'Home 24',
				'home'                       => 'home-24',
				'import_file_url'          	 => $data_url ,
				'import_widget_file_url'     => $widget_url,
				'import_redux'         => array(
					array(
						'file_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home24/redux_options.json",
						'option_name' => 'puca_tbay_theme_options',
					),
				),
				'rev_sliders'                => $rev_sliders,
				'import_preview_image_url'   => "http://demosamples.thembay.com/puca/${prefix}/${skin}/home24/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'puca' ),
				'preview_url'                => 'https://wpbakery.thembay.com/puca_ohio/home-24/',
				'group_label_end'          => 'yes',
			),
		);
	}
}