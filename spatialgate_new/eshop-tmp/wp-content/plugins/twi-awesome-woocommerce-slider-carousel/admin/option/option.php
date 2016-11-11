<?php


return array(
	'title' => __('TWI Awesome Woocommerce Grid/Slider/Carousel Options', 'twi_awesome_woo_slider_carousel'),
	'logo' => TWI_AWESOME_WOO_SLIDER_CAROUSEL_URL.'/images/twi-logo.png',
	'menus' => array(
		array(
			'title' => __('Upsells Slider', 'twi_awesome_woo_slider_carousel'),
			'name' => 'twi_woo_upsells',
			'icon' => 'font-awesome:fa-gear',
			'controls' => array(
				
				array(
					'type' => 'section',
					'title' => __('Upsells Slider Options', 'twi_awesome_woo_slider_carousel'),
					'name' => 'twi_upsells_options',
					'fields' => array(
						array(
							'type' => 'toggle',
							'name' => 'twi_woo_upsell_off_on',
							'label' => __('Do you want to active Up sells slider/Carousel ?', 'twi_awesome_woo_slider_carousel'),
							'description' => __('Enable/Disable options', 'twi_awesome_woo_slider_carousel'),
							'default' => 0,
						),
					),
				),
				
				
				
				array(
					'type' => 'section',
					'title' => __('Caroseul/Slider options', 'twi_awesome_woo_slider_carousel'),
					'name' => 'twi_woo_upsell_carousel_options',
					'dependency' => array(
						'field' => 'twi_woo_upsell_off_on',
						'function' => 'vp_dep_boolean',
					),
					
					
					'fields' => array(
						array(
											'type' => 'radiobutton',
											'name' => 'twi_upsell_woo_autoplay',
											'label' => __('Autoplay', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												array(
													'value' => 'true',
													'label' => 'Yes'
												),
												array(
													'value' => 'false',
													'label' => 'No'
											),
											),
											'default' => 'true',
					     ),
						array(
								'type'    => 'slider',
								'name'    => 'upsell_au_time',
								'label'   => __('Autoplay Timeout', 'twi_awesome_woo_slider_carousel'),
								'description' => __('Autoplay Timeout (Second)', 'twi_awesome_woo_slider_carousel'),
								'min'     => '1',
								'max'     => '20',
								'default' => '5',
						),
						array(
											'type' => 'radiobutton',
											'name' => 'twi_upsell_woo_nav',
											'label' => __('Navigation', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												array(
													'value' => 'true',
													'label' => 'Yes'
												),
												array(
													'value' => 'false',
													'label' => 'No'
											),
											),
											'default' => 'true',
							),
						array(
											'type' => 'radiobutton',
											'name' => 'twi_upsell_woo_page',
											'label' => __('Pagination', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												array(
													'value' => 'true',
													'label' => 'Yes'
												),
												array(
													'value' => 'false',
													'label' => 'No'
											),
											),
											'default' => 'true',
						),

						array(
											'type' => 'radiobutton',
											'name' => 'twi_upsell_fw',
											'label' => __('Forced Full Width', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												array(
													'value' => 'true',
													'label' => 'Yes'
												),
												array(
													'value' => 'false',
													'label' => 'No'
											),
											),
											'default' => 'false',
						),

						array(
								'type'    => 'slider',
								'name'    => 'upsell_pro_gap',
								'label'   => __('Gap Between Grids', 'twi_awesome_woo_slider_carousel'),
								'description' => __('Gap Between Grids (px)', 'twi_awesome_woo_slider_carousel'),
								'min'     => '0',
								'max'     => '100',
								'default' => '10',
						),
					),

                    	
					
					
					
				),
				
				
				
				array(
					'type' => 'section',
					'title' => __('Product show options', 'twi_awesome_woo_slider_carousel'),
					'name' => 'twi_upsell_pro_showcase',
					'dependency' => array(
						'field' => 'twi_woo_upsell_off_on',
						'function' => 'vp_dep_boolean',
					),
					
					
					'fields' => array(
						array(
								'type'    => 'slider',
								'name'    => 'desktop_pro',
								'label'   => __('Desktop', 'twi_awesome_woo_slider_carousel'),
								'description' => __('How many products show', 'twi_awesome_woo_slider_carousel'),
								'min'     => '1',
								'max'     => '12',
								'default' => '3',
							),
						array(
								'type'    => 'slider',
								'name'    => 'tablet_pro',
								'label'   => __('Tablet', 'twi_awesome_woo_slider_carousel'),
								'description' => __('How many products show', 'twi_awesome_woo_slider_carousel'),
								'min'     => '1',
								'max'     => '12',
								'default' => '2',
							),
						array(
								'type'    => 'slider',
								'name'    => 'mobile_pro',
								'label'   => __('Mobile', 'twi_awesome_woo_slider_carousel'),
								'description' => __('How many products show', 'twi_awesome_woo_slider_carousel'),
								'min'     => '1',
								'max'     => '12',
								'default' => '1',
							),
					),
					
					
					
				),		
				
				
				
				
				
				
			),
		),
		
		array(
			'title' => __('Cross-sells Slider', 'twi_awesome_woo_slider_carousel'),
			'name' => 'crosssell_pro_settings',
			'icon' => 'font-awesome:fa-leaf',
			'controls' => array(
		
			array(
					'type' => 'section',
					'title' => __('Cross Sell Slider Options', 'twi_awesome_woo_slider_carousel'),
					'name' => 'twi_crosssells_options',
					'fields' => array(
						array(
							'type' => 'toggle',
							'name' => 'twi_woo_crosssells_off_on',
							'label' => __('Do you want to active Up sells slider/Carousel ?', 'twi_awesome_woo_slider_carousel'),
							'description' => __('Enable/Disable options', 'twi_awesome_woo_slider_carousel'),
							'default' => 0,
						),
					),
				),
				
				
				
				array(
					'type' => 'section',
					'title' => __('Caroseul/Slider options', 'twi_awesome_woo_slider_carousel'),
					'name' => 'twi_woo_crosssells_carousel_options',
					'dependency' => array(
						'field' => 'twi_woo_crosssells_off_on',
						'function' => 'vp_dep_boolean',
					),
					
					
					'fields' => array(
						array(
											'type' => 'radiobutton',
											'name' => 'twi_crosssells_woo_autoplay',
											'label' => __('Autoplay', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												array(
													'value' => 'true',
													'label' => 'Yes'
												),
												array(
													'value' => 'false',
													'label' => 'No'
											),
											),
											'default' => 'true',
					     ),
						array(
								'type'    => 'slider',
								'name'    => 'crosssells_au_time',
								'label'   => __('Autoplay Timeout', 'twi_awesome_woo_slider_carousel'),
								'description' => __('Autoplay Timeout (Second)', 'twi_awesome_woo_slider_carousel'),
								'min'     => '1',
								'max'     => '20',
								'default' => '5',
						),
						array(
											'type' => 'radiobutton',
											'name' => 'twi_crosssells_woo_nav',
											'label' => __('Navigation', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												array(
													'value' => 'true',
													'label' => 'Yes'
												),
												array(
													'value' => 'false',
													'label' => 'No'
											),
											),
											'default' => 'true',
							),
						array(
											'type' => 'radiobutton',
											'name' => 'twi_crosssells_woo_page',
											'label' => __('Pagination', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												array(
													'value' => 'true',
													'label' => 'Yes'
												),
												array(
													'value' => 'false',
													'label' => 'No'
											),
											),
											'default' => 'true',
						),

						array(
								'type'    => 'slider',
								'name'    => 'crosssells_pro_gap',
								'label'   => __('Gap Between Grids', 'twi_awesome_woo_slider_carousel'),
								'description' => __('Gap Between Grids (px)', 'twi_awesome_woo_slider_carousel'),
								'min'     => '0',
								'max'     => '100',
								'default' => '10',
						),
					),
					
					
					
				),
				
				
				
				array(
					'type' => 'section',
					'title' => __('Product show options', 'twi_awesome_woo_slider_carousel'),
					'name' => 'twi_crosssells_pro_showcase',
					'dependency' => array(
						'field' => 'twi_woo_crosssells_off_on',
						'function' => 'vp_dep_boolean',
					),
					
					
					'fields' => array(
						array(
								'type'    => 'slider',
								'name'    => 'crosssells_desktop_pro',
								'label'   => __('Desktop', 'twi_awesome_woo_slider_carousel'),
								'description' => __('How many products show', 'twi_awesome_woo_slider_carousel'),
								'min'     => '1',
								'max'     => '12',
								'default' => '3',
							),
						array(
								'type'    => 'slider',
								'name'    => 'crosssells_tablet_pro',
								'label'   => __('Tablet', 'twi_awesome_woo_slider_carousel'),
								'description' => __('How many products show', 'twi_awesome_woo_slider_carousel'),
								'min'     => '1',
								'max'     => '12',
								'default' => '2',
							),
						array(
								'type'    => 'slider',
								'name'    => 'crosssells_mobile_pro',
								'label'   => __('Mobile', 'twi_awesome_woo_slider_carousel'),
								'description' => __('How many products show', 'twi_awesome_woo_slider_carousel'),
								'min'     => '1',
								'max'     => '12',
								'default' => '1',
							),
					),
					
					
					
				),		
				
				
			),
		),
		
		
		
		
		
		
		array(
			'title' => __('Related Products Slider', 'twi_awesome_woo_slider_carousel'),
			'name' => 'related_pro_settings',
			'icon' => 'font-awesome:fa-usd',
			'controls' => array(
		
			array(
					'type' => 'section',
					'title' => __('Related Products Slider Options', 'twi_awesome_woo_slider_carousel'),
					'name' => 'twi_related_options',
					'fields' => array(
						array(
							'type' => 'toggle',
							'name' => 'twi_woo_related_off_on',
							'label' => __('Do you want to active Up sells slider/Carousel ?', 'twi_awesome_woo_slider_carousel'),
							'description' => __('Enable/Disable options', 'twi_awesome_woo_slider_carousel'),
							'default' => 0,
						),
					),
				),
				
				
				
				array(
					'type' => 'section',
					'title' => __('Caroseul/Slider options', 'twi_awesome_woo_slider_carousel'),
					'name' => 'twi_woo_related_carousel_options',
					'dependency' => array(
						'field' => 'twi_woo_related_off_on',
						'function' => 'vp_dep_boolean',
					),
					
					
					'fields' => array(
						array(
											'type' => 'radiobutton',
											'name' => 'twi_related_woo_autoplay',
											'label' => __('Autoplay', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												array(
													'value' => 'true',
													'label' => 'Yes'
												),
												array(
													'value' => 'false',
													'label' => 'No'
											),
											),
											'default' => 'true',
					     ),
						array(
								'type'    => 'slider',
								'name'    => 'related_au_time',
								'label'   => __('Autoplay Timeout', 'twi_awesome_woo_slider_carousel'),
								'description' => __('Autoplay Timeout (Second)', 'twi_awesome_woo_slider_carousel'),
								'min'     => '1',
								'max'     => '20',
								'default' => '5',
						),
						array(
											'type' => 'radiobutton',
											'name' => 'twi_related_woo_nav',
											'label' => __('Navigation', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												array(
													'value' => 'true',
													'label' => 'Yes'
												),
												array(
													'value' => 'false',
													'label' => 'No'
											),
											),
											'default' => 'true',
							),
						array(
											'type' => 'radiobutton',
											'name' => 'twi_related_woo_page',
											'label' => __('Pagination', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												array(
													'value' => 'true',
													'label' => 'Yes'
												),
												array(
													'value' => 'false',
													'label' => 'No'
											),
											),
											'default' => 'true',
						),
						array(
											'type' => 'radiobutton',
											'name' => 'twi_related_fw',
											'label' => __('Forced Full Width', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												array(
													'value' => 'true',
													'label' => 'Yes'
												),
												array(
													'value' => 'false',
													'label' => 'No'
											),
											),
											'default' => 'false',
						),
						array(
								'type'    => 'slider',
								'name'    => 'related_pro_gap',
								'label'   => __('Gap Between Grids', 'twi_awesome_woo_slider_carousel'),
								'description' => __('Gap Between Grids (px)', 'twi_awesome_woo_slider_carousel'),
								'min'     => '0',
								'max'     => '100',
								'default' => '10',
						),
					),
					
					
					
				),
				
				
				
				array(
					'type' => 'section',
					'title' => __('Product show options', 'twi_awesome_woo_slider_carousel'),
					'name' => 'twi_related_pro_showcase',
					'dependency' => array(
						'field' => 'twi_woo_related_off_on',
						'function' => 'vp_dep_boolean',
					),
					
					
					'fields' => array(
					    
					    array(
								'type'    => 'slider',
								'name'    => 'related_total_pro',
								'label'   => __('Total display', 'twi_awesome_woo_slider_carousel'),
								'description' => __('How many (total) products show', 'twi_awesome_woo_slider_carousel'),
								'min'     => '1',
								'max'     => '25',
								'default' => '6',
						),
							
						array(
								'type'    => 'slider',
								'name'    => 'related_desktop_pro',
								'label'   => __('Desktop', 'twi_awesome_woo_slider_carousel'),
								'description' => __('How many products show', 'twi_awesome_woo_slider_carousel'),
								'min'     => '1',
								'max'     => '12',
								'default' => '3',
							),
						array(
								'type'    => 'slider',
								'name'    => 'related_tablet_pro',
								'label'   => __('Tablet', 'twi_awesome_woo_slider_carousel'),
								'description' => __('How many products show', 'twi_awesome_woo_slider_carousel'),
								'min'     => '1',
								'max'     => '12',
								'default' => '2',
							),
						array(
								'type'    => 'slider',
								'name'    => 'related_mobile_pro',
								'label'   => __('Mobile', 'twi_awesome_woo_slider_carousel'),
								'description' => __('How many products show', 'twi_awesome_woo_slider_carousel'),
								'min'     => '1',
								'max'     => '12',
								'default' => '1',
							),
					),
					
					
					
				),		
				
				
			),
		),

		
		
		
		
		
		
	)
);

/**
 *EOF
 */