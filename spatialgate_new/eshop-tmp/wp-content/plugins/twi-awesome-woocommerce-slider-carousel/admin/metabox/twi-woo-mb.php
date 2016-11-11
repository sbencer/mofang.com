<?php
return array(
 'id'          => 'twi_woo_mb_main',
 'types'       => array('twi_woo_g_car'),
 'title'       => __('Woocommerce Grid/Slider/Carousel', 'twi_awesome_woo_slider_carousel'),
 'priority'    => 'high',
 'is_dev_mode' => false,
 'template'    => array(
						array(
							'name'    => 'cat',
							'type'    => 'multiselect',
							'label'   => __('Select Categories,if you want to show all categories,plase leave it blank.', 'twi_awesome_woo_slider_carousel'),
										'items'   => array(
										'data' => array(
												array(
														'source' => 'function',
														'value'  => 'twi_get_categories',
													),
										),
								),
						  ),
                                array(
											'type'    => 'slider',
											'name'    => 'per_page',
											'label'   => __('Show per page', 'twi_awesome_woo_slider_carousel'),
											'min'     => '1',
											'max'     => '100',
											'default' => '10'
								       ),

 	      			 array(
							'type' => 'radiobutton',
							'name' => 'twi_woo_g_c_style',
							'label' => __('Your Style', 'twi_awesome_woo_slider_carousel'),
							'items' => array(
											array(
												'value' => 'twi_woo_grid',
												'label' => __('Responsive Grid', 'twi_awesome_woo_slider_carousel'),
											),
											array(
												'value' => 'twi_woo_mansonry',
												'label' => __('Masonry Grid (Pinterest Style)', 'twi_awesome_woo_slider_carousel'),
											),
											array(
												'value' => 'twi_woo_slider',
												'label' => __('Slider/Carousel', 'twi_awesome_woo_slider_carousel'),
											),
																	
										),
							'default' => array('twi_woo_grid'),
						),

 	      			   array(
							'type' => 'slider',
							'name' => 'items_gap',
							'dependency' => array(
									'field' => 'twi_woo_g_c_style',
									'function' => 'twi_woo_car_gap',
								),
							'label' => __('Items Between Gap', 'twi_awesome_woo_slider_carousel'),
							'min' => '0',
							'max' => '200',
							'step' => '1',
							'default' => '10',
						),

 	      			    array(
								'type'    => 'slider',
								'dependency' => array(
									'field' => 'twi_woo_g_c_style',
									'function' => 'twi_woo_gutter',
								),
								'name'    => 'woo_gutter',
								'label'   => __('Gap Between Grids (px)', 'twi_awesome_woo_slider_carousel'),
								'min'     => '1',
								'max'     => '200',
								'default' => '10'
					    ),

                                            array(
												'type' => 'radiobutton',
												'dependency' => array(
														'field' => 'twi_woo_g_c_style',
														'function' => 'twi_woo_gap',
												),
												'name' => 'twi_woo_grid_gap',
												'label' => __('Gap Between Grids', 'twi_awesome_woo_slider_carousel'),
												'items' => array(
																array(
																	'value' => 'normal',
																	'label' => __('Normal', 'twi_awesome_woo_slider_carousel'),
																),
																array(
																	'value' => 'medium',
																	'label' => __('Medium', 'twi_awesome_woo_slider_carousel'),
																),
																array(
																	'value' => 'small',
																	'label' => __('Small', 'twi_awesome_woo_slider_carousel'),
																),
																array(
																	'value' => 'collapse',
																	'label' => __('Collapse', 'twi_awesome_woo_slider_carousel'),
																),
																						
															),
												'default' => array('normal'),
											    ),

 	      			 array(
							    'type' => 'group',
							    'repeating' => false,
							    'length' => 1,
							    'name' => 'twi_woo_grid_group',
							    'title' => __('Grid Settings', 'twi_awesome_woo_slider_carousel'),
							    'dependency' => array(
										'field' => 'twi_woo_g_c_style',
										'function' => 'twi_woo_st_dep_grid',
								),
							    'fields' => array(
									    array(
											'type' => 'select',
											'name' => 'twi_woo_grid_desktop_big',
											'label' => __('Large Desktops', 'twi_awesome_woo_slider_carousel'),
											'description' => __('Xlarge (1200px and larger)','twi_awesome_woo_slider_carousel'),
											'items' => array(
															array(
																'value' => '1',
																'label' => __('1', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '2',
																'label' => __('2', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '3',
																'label' => __('3', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '4',
																'label' => __('4', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '5',
																'label' => __('5', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '6',
																'label' => __('6', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '10',
																'label' => __('10', 'twi_awesome_woo_slider_carousel'),
															),
																					
														),
											'default' => array('5'),
										    ),
                                            
                                            array(
											'type' => 'select',
											'name' => 'twi_woo_grid_desktop',
											'label' => __('Desktops & tablets landscape', 'twi_awesome_woo_slider_carousel'),
											'description' => __('Large (960px to 1199px)','twi_awesome_woo_slider_carousel'),
											'items' => array(
															array(
																'value' => '1',
																'label' => __('1', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '2',
																'label' => __('2', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '3',
																'label' => __('3', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '4',
																'label' => __('4', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '5',
																'label' => __('5', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '6',
																'label' => __('6', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '10',
																'label' => __('10', 'twi_awesome_woo_slider_carousel'),
															),
																					
														),
											'default' => array('4'),
										    ),
       

                                         array(
											'type' => 'select',
											'name' => 'twi_woo_grid_tablet',
											'label' => __('Tablets portrait', 'twi_awesome_woo_slider_carousel'),
											'description' => __('Medium (768px to 959px)','twi_awesome_woo_slider_carousel'),
											'items' => array(
															array(
																'value' => '1',
																'label' => __('1', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '2',
																'label' => __('2', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '3',
																'label' => __('3', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '4',
																'label' => __('4', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '5',
																'label' => __('5', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '6',
																'label' => __('6', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '10',
																'label' => __('10', 'twi_awesome_woo_slider_carousel'),
															),
																					
														),
											'default' => array('3'),
										    ),

                                            array(
											'type' => 'select',
											'name' => 'twi_woo_grid_phone_big',
											'label' => __('Phones landscape', 'twi_awesome_woo_slider_carousel'),
											'description' => __('Small (480px to 767px)','twi_awesome_woo_slider_carousel'),
											'items' => array(
															array(
																'value' => '1',
																'label' => __('1', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '2',
																'label' => __('2', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '3',
																'label' => __('3', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '4',
																'label' => __('4', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '5',
																'label' => __('5', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '6',
																'label' => __('6', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '10',
																'label' => __('10', 'twi_awesome_woo_slider_carousel'),
															),
																					
														),
											'default' => array('2'),
										    ),
                                            
                                            array(
											'type' => 'select',
											'name' => 'twi_woo_grid_phone',
											'label' => __('Phones portrait', 'twi_awesome_woo_slider_carousel'),
											'description' => __('Mini (up to 479px)','twi_awesome_woo_slider_carousel'),
											'items' => array(
															array(
																'value' => '1',
																'label' => __('1', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '2',
																'label' => __('2', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '3',
																'label' => __('3', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '4',
																'label' => __('4', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '5',
																'label' => __('5', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '6',
																'label' => __('6', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => '10',
																'label' => __('10', 'twi_awesome_woo_slider_carousel'),
															),
																					
														),
											'default' => array('1'),
										    ),
                                          
                                           array(
											'type' => 'radiobutton',
											'name' => 'pagination',
											'label' => __('Pagination', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												            array(
																'value' => 'yes',
																'label' => __('Yes', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => 'no',
																'label' => __('No', 'twi_awesome_woo_slider_carousel'),
															),					
														),
											'default' => array('yes'),
										    ),

                                           array(
										    'type'      => 'group',
										    'repeating' => false,
										    'length'    => 1,
										    'name'      => 'grid_pagi_settings',
										    'dependency' => array(
													'field' => 'pagination',
													'function' => 'pagi_show_fun',
											),
										    'title'     => __('Pagination Style', 'twi_awesome_woo_slider_carousel'),
										    'fields'    => array(
										    	     array(
														'type' => 'html',
														'name' => 'grid_pagi_preview',	                        
														'binding' => array(
														'field' => 'grid_pagi_pos,text1,bg1,bor_col1,bor_width1,text2,bg2,bor_col2,bor_width2,bor_rad,pad',
														'function' => 'woo_grid_pagi_fun',
														),
													),
										    	   array(
														'type' => 'radiobutton',
														'name' => 'grid_pagi_pos',
														'label' => __('Pagination Position', 'twi_awesome_woo_slider_carousel'),
														'items' => array(
																		array(
																			'value' => 'left',
																			'label' => __('Left', 'twi_awesome_woo_slider_carousel'),
																		),
																		array(
																			'value' => 'center',
																			'label' => __('Center', 'twi_awesome_woo_slider_carousel'),
																		),
																		array(
																			'value' => 'right',
																			'label' => __('Right', 'twi_awesome_woo_slider_carousel'),
																		),						
																	),
														'default' => array('center'),
													),
										    	    array(
												        'type' => 'color',
												        'name' => 'text1',
												        'label' => __('Text Color', 'twi_awesome_woo_slider_carousel'),
												        'default' => '#000',
												    ),
												    array(
												        'type' => 'color',
												        'name' => 'bg1',
												        'label' => __('Background Color', 'twi_awesome_woo_slider_carousel'),
												        'default' => '#fff',
												    ),
												    array(
												        'type' => 'color',
												        'name' => 'bor_col1',
												        'label' => __('Border Color', 'twi_awesome_woo_slider_carousel'),
												        'default' => '#000',
												    ),
												    array(
												    'type' => 'slider',
												        'name' => 'bor_width1',
												        'label' => __('Border Width', 'twi_awesome_woo_slider_carousel'),
												        'min' => '0',
												        'max' => '10',
												        'step' => '1',
												        'default' => '2',
												    ),
												    array(
												        'type' => 'color',
												        'name' => 'text2',
												        'label' => __('Text Color(Hover/Active)', 'twi_awesome_woo_slider_carousel'),
												        'default' => '#fff',
												    ),
												    array(
												        'type' => 'color',
												        'name' => 'bg2',
												        'label' => __('Background Color(Hover/Active)', 'twi_awesome_woo_slider_carousel'),
												        'default' => '#00a8e6',
												    ),
												    array(
												        'type' => 'color',
												        'name' => 'bor_col2',
												        'label' => __('Border Color(Hover/Active)', 'twi_awesome_woo_slider_carousel'),
												        'default' => '#00a8e6',
												    ),
												    array(
												    'type' => 'slider',
												        'name' => 'bor_width2',
												        'label' => __('Border Width(Hover/Active)', 'twi_awesome_woo_slider_carousel'),
												        'min' => '0',
												        'max' => '10',
												        'step' => '1',
												        'default' => '2',
												    ),
												    array(
                                                    'type' => 'slider',
												        'name' => 'bor_rad',
												        'label' => __('Border Radius(%)', 'twi_awesome_woo_slider_carousel'),
												        'min' => '0',
												        'max' => '50',
												        'step' => '1',
												        'default' => '10',
												    ),
												    array(
                                                    'type' => 'slider',
												        'name' => 'pad',
												        'label' => __('Padding', 'twi_awesome_woo_slider_carousel'),
												        'min' => '0',
												        'max' => '15',
												        'step' => '1',
												        'default' => '6',
												    ),
										       ),
										    ),
                                           

							        ),
							    ),

                        
                         	  array(
							    'type' => 'group',
							    'repeating' => false,
							    'length' => 1,
							    'name' => 'twi_carousel_group',
							    'title' => __('Slider/Carousel Settings', 'twi_awesome_woo_slider_carousel'),
							    'dependency' => array(
										'field' => 'twi_woo_g_c_style',
										'function' => 'twi_slider_dep',
								),
							    'fields' => array(
							    	      array(
											        'type' => 'slider',
											        'name' => 'large_desktop',
											        'label' => __('Large Desktops', 'twi_awesome_woo_slider_carousel'),
											        'description' => __('Xlarge (1200px and larger)','twi_awesome_woo_slider_carousel'),
											        'min' => '1',
											        'max' => '12',
											        'step' => '1',
											        'default' => '5',
											),
                                            array(
											        'type' => 'slider',
											        'name' => 'desktop',
											        'label' => __('Desktops & tablets landscape', 'twi_awesome_woo_slider_carousel'),
											        'description' => __('Large (960px to 1199px)','twi_awesome_woo_slider_carousel'),
											        'min' => '1',
											        'max' => '12',
											        'step' => '1',
											        'default' => '4',
											),
                                        
	                                        array(
											        'type' => 'slider',
											        'name' => 'tablet',
											        'label' => __('Tablets portrait', 'twi_awesome_woo_slider_carousel'),
												    'description' => __('Medium (768px to 959px)','twi_awesome_woo_slider_carousel'),
											        'min' => '1',
											        'max' => '12',
											        'step' => '1',
											        'default' => '3',
											),

                                            array(
										        'type' => 'slider',
										        'name' => 'phone_big',
										        'label' => __('Phones landscape', 'twi_awesome_woo_slider_carousel'),
										        'description' => __('Small (480px to 767px)', 'twi_awesome_woo_slider_carousel'),
										        'min' => '1',
										        'max' => '12',
										        'step' => '1',
										        'default' => '2',
										    ),

                                            array(
										        'type' => 'slider',
										        'name' => 'phone',
										        'label' => __('Phones portrait', 'twi_awesome_woo_slider_carousel'),
										        'description' => __('Mini (up to 479px)', 'twi_awesome_woo_slider_carousel'),
										        'min' => '1',
										        'max' => '6',
										        'step' => '1',
										        'default' => '1',
										    ),

										    array(
											'type' => 'radiobutton',
											'name' => 'autoplay',
											'label' => __('Autoplay', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												            array(
																'value' => 'true',
																'label' => __('Yes', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => 'false',
																'label' => __('No', 'twi_awesome_woo_slider_carousel'),
															),					
														),
											'default' => array('true'),
										    ),

										    array(
										        'type' => 'slider',
										        'name' => 'autoplaytime',
										        'label' => __('Autoplay Timeout (Sec)', 'twi_awesome_woo_slider_carousel'),
										        'min' => '0.1',
										        'max' => '20',
										        'step' => '0.1',
										        'default' => '5',
										    ),

										    array(
											'type' => 'radiobutton',
											'name' => 'car_hover',
											'label' => __('Autoplay Hover Pause', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												            array(
																'value' => 'true',
																'label' => __('Yes', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => 'false',
																'label' => __('No', 'twi_awesome_woo_slider_carousel'),
															),					
														),
											'default' => array('false'),
										    ),

										    array(
											'type' => 'radiobutton',
											'name' => 'car_nav',
											'label' => __('Navigation', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												            array(
																'value' => 'true',
																'label' => __('Yes', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => 'false',
																'label' => __('No', 'twi_awesome_woo_slider_carousel'),
															),					
														),
											'default' => array('true'),
										    ),

										 array(
										    'type' => 'group',
										    'repeating' => false,
										    'length' => 1,
										    'name' => 'car_nav_group',
										    'title' => __('Navigation Settings', 'twi_awesome_woo_slider_carousel'),
										    'dependency' => array(
										        'field' => 'car_nav',
												'function' => 'twi_car_nav_set',
											),
										    'fields' => array(
                                            
                                           array(
												'type' => 'html',
												'name' => 'grid_pagi_preview',
												'binding' => array(
													'field' => 'nav_bg,nav_txt,nav_border,nav_bor_wid,nav_bor_rad,nav_bg_h,nav_txt_h,nav_border_h',
													'function' => 'woo_car_nav_fun',
												),
											),
                                            array(
										        'type' => 'color',
										        'name' => 'nav_bg',
										        'label' => __('Background', 'twi_awesome_woo_slider_carousel'),
										        'default' => '#fff',
										    ),
										    array(
										        'type' => 'color',
										        'name' => 'nav_txt',
										        'label' => __('Arrow Color', 'twi_awesome_woo_slider_carousel'),
										        'default' => '#000',
										    ),
										    array(
										        'type' => 'color',
										        'name' => 'nav_border',
										        'label' => __('Border Color', 'twi_awesome_woo_slider_carousel'),
										        'default' => '#000',
										    ),
										    array(
										        'type' => 'slider',
										        'name' => 'nav_bor_wid',
										        'label' => __('Border Width', 'twi_awesome_woo_slider_carousel'),
										        'min' => '0',
										        'max' => '10',
										        'step' => '1',
										        'default' => '2',
										    ),
										    array(
										        'type' => 'slider',
										        'name' => 'nav_bor_rad',
										        'label' => __('Border Radius(%)', 'twi_awesome_woo_slider_carousel'),
										        'min' => '0',
										        'max' => '50',
										        'step' => '1',
										        'default' => '10',
										    ),



										    array(
										        'type' => 'color',
										        'name' => 'nav_bg_h',
										        'label' => __('Background(Hover)', 'twi_awesome_woo_slider_carousel'),
										        'default' => '#fff',
										    ),
										    array(
										        'type' => 'color',
										        'name' => 'nav_txt_h',
										        'label' => __('Arrow Color(Hover)', 'twi_awesome_woo_slider_carousel'),
										        'default' => '#000',
										    ),
										    array(
										        'type' => 'color',
										        'name' => 'nav_border_h',
										        'label' => __('Border Color(Hover)', 'twi_awesome_woo_slider_carousel'),
										        'default' => '#000',
										    ),

										   array(
											'type' => 'select',
											'name' => 'nav_pos',
											'label' => __('Nav Position', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
															array(
																'value' => 'nav_b_c',
																'label' => __('Bottom Center', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => 'nav_b_l',
																'label' => __('Bottom Left', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => 'nav_b_r',
																'label' => __('Bottom Right', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => 'nav_t_c',
																'label' => __('Top Center', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => 'nav_t_l',
																'label' => __('Top Left', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => 'nav_t_r',
																'label' => __('Top Right', 'twi_awesome_woo_slider_carousel'),
															),
																					
														),
											'default' => array('nav_b_c'),
										    ),

                                        ),
                                    ),
                                          
                                           array(
											'type' => 'radiobutton',
											'name' => 'car_page',
											'label' => __('Pagination', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
												            array(
																'value' => 'true',
																'label' => __('Yes', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => 'false',
																'label' => __('No', 'twi_awesome_woo_slider_carousel'),
															),					
														),
											'default' => array('false'),
										    ),

                                            array(
											    'type' => 'group',
											    'repeating' => false,
											    'length' => 1,
											    'name' => 'car_page_group',
											    'title' => __('Pagination Settings', 'twi_awesome_woo_slider_carousel'),
											    'dependency' => array(
												    'field' => 'car_page',
													'function' => 'twi_page_show_dep',
												),
											    'fields' => array(
											    	    array(
															'type' => 'html',
															'name' => 'pagination_preview',
															'binding' => array(
																'field' => 'pagi_bg,pagi_border,pagi_bor_wid,pagi_bor_rad,pagi_bg_h,pagi_border_h',
																'function' => 'woo_car_pagi_fun',
															),
														),
			                                            array(
													        'type' => 'color',
													        'name' => 'pagi_bg',
													        'label' => __('Background', 'twi_awesome_woo_slider_carousel'),
													        'default' => '#fff',
													    ),
													    array(
													        'type' => 'color',
													        'name' => 'pagi_border',
													        'label' => __('Border Color', 'twi_awesome_woo_slider_carousel'),
													        'default' => '#000',
													    ),
													    array(
													        'type' => 'slider',
													        'name' => 'pagi_bor_wid',
													        'label' => __('Border Width', 'twi_awesome_woo_slider_carousel'),
													        'min' => '0',
													        'max' => '10',
													        'step' => '1',
													        'default' => '2',
													    ),
													    array(
													        'type' => 'slider',
													        'name' => 'pagi_bor_rad',
													        'label' => __('Border Radius(%)', 'twi_awesome_woo_slider_carousel'),
													        'min' => '0',
													        'max' => '50',
													        'step' => '1',
													        'default' => '50',
													    ),

													    array(
													        'type' => 'color',
													        'name' => 'pagi_bg_h',
													        'label' => __('Background(Hover)', 'twi_awesome_woo_slider_carousel'),
													        'default' => '#000000',
													    ),
													    array(
													        'type' => 'color',
													        'name' => 'pagi_border_h',
													        'label' => __('Border Color(Hover)', 'twi_awesome_woo_slider_carousel'),
													        'default' => '#000000',
													    ),
											    ),
											),

							        ),
							    ),


 	      			   array(
							'type' => 'radiobutton',
							'name' => 'twi_pro_orderby',
							'label' => __('Product Orderby', 'twi_awesome_woo_slider_carousel'),
							'items' => array(
								            array(
												'value' => 'title',
												'label' => __('Title', 'twi_awesome_woo_slider_carousel'),
											),
											array(
												'value' => 'price',
												'label' => __('Price', 'twi_awesome_woo_slider_carousel'),
											),
											array(
												'value' => 'sku',
												'label' => __('SKU', 'twi_awesome_woo_slider_carousel'),
											),	
											array(
												'value' => 'date',
												'label' => __('Date', 'twi_awesome_woo_slider_carousel'),
											),	
											array(
												'value' => 'rand',
												'label' => __('Random', 'twi_awesome_woo_slider_carousel'),
											),	
											array(
												'value' => 'featured',
												'label' => __('Featured', 'twi_awesome_woo_slider_carousel'),
											),
											      
											array(
												'value' => 'pro_on_sale',
												'label' => __('Products on sale', 'twi_awesome_woo_slider_carousel'),
											), 
											
											array(
												'value' => 'recent_pro',
												'label' => __('Latest/Recent products', 'twi_awesome_woo_slider_carousel'),
										    ),
										   array(
												'value' => 'best_sellers',
												'label' => __('Best Sellers', 'twi_awesome_woo_slider_carousel'),
											),
											      
											array(
											    'value' => 'top_rated',
												'label' => __('Top rated products', 'twi_awesome_woo_slider_carousel'),
											),			
										),
							'default' => array('title'),
						),

 	      			   array(
							'type' => 'radiobutton',
							'name' => 'twi_pro_order',
							'label' => __('Product Order', 'twi_awesome_woo_slider_carousel'),
							'items' => array(
								            array(
												'value' => 'asc',
												'label' => __('Ascending', 'twi_awesome_woo_slider_carousel'),
											),
											array(
												'value' => 'desc',
												'label' => __('Descending', 'twi_awesome_woo_slider_carousel'),
											),					
										),
							'default' => array('desc'),
						),

 	      			   array(
									'type' => 'radiobutton',
									'name' => 'title',
									'label' => __('Title Show', 'twi_awesome_woo_slider_carousel'),
									'items' => array(
										            array(
														'value' => 'display',
														'label' => __('Yes', 'twi_awesome_woo_slider_carousel'),
													),
													array(
														'value' => 'none',
														'label' => __('No', 'twi_awesome_woo_slider_carousel'),
													),					
												),
									'default' => array('display'),
								),

 	      			   array(
									'type' => 'radiobutton',
									'name' => 'price_h_s',
									'label' => __('Price Show', 'twi_awesome_woo_slider_carousel'),
									'items' => array(
										            array(
														'value' => 'display',
														'label' => __('Yes', 'twi_awesome_woo_slider_carousel'),
													),
													array(
														'value' => 'none',
														'label' => __('No', 'twi_awesome_woo_slider_carousel'),
													),					
												),
									'default' => array('display'),
								),

 	      			   array(
									'type' => 'radiobutton',
									'name' => 'cart',
									'label' => __('Cart Show', 'twi_awesome_woo_slider_carousel'),
									'items' => array(
										            array(
														'value' => 'display',
														'label' => __('Yes', 'twi_awesome_woo_slider_carousel'),
													),
													array(
														'value' => 'none',
														'label' => __('No', 'twi_awesome_woo_slider_carousel'),
													),					
												),
									'default' => array('display'),
								),

 	      			   array(
									'type' => 'radiobutton',
									'name' => 'rating',
									'label' => __('Rating Show', 'twi_awesome_woo_slider_carousel'),
									'items' => array(
										            array(
														'value' => 'display',
														'label' => __('Yes', 'twi_awesome_woo_slider_carousel'),
													),
													array(
														'value' => 'none',
														'label' => __('No', 'twi_awesome_woo_slider_carousel'),
													),					
												),
									'default' => array('display'),
								),

 	      			   array(
									'type' => 'radiobutton',
									'name' => 'forced_full_screen',
									'label' => __('Forced Full Screen', 'twi_awesome_woo_slider_carousel'),
									'items' => array(
										            array(
														'value' => 'yes',
														'label' => __('Yes', 'twi_awesome_woo_slider_carousel'),
													),
													array(
														'value' => 'no',
														'label' => __('No', 'twi_awesome_woo_slider_carousel'),
													),					
												),
									'default' => array('no'),
					  ),

 	      			   array(
							    'type' => 'group',
							    'repeating' => false,
							    'length' => 1,
							    'name' => 'twi_woo_rib_main',
							    'title' => __('Ribbon/Label Settings', 'twi_awesome_woo_slider_carousel'),
							    'fields' => array(
							    	array(
										'type' => 'radiobutton',
										'name' => 'twi_rib_dis',
										'label' => __('Ribbon/Label Display', 'twi_awesome_woo_slider_carousel'),
										'items' => array(
											            array(
															'value' => 'yes',
															'label' => __('Yes', 'twi_awesome_woo_slider_carousel'),
														),
														array(
															'value' => 'no',
															'label' => __('No', 'twi_awesome_woo_slider_carousel'),
														),					
													),
										     'default' => array('yes'),
					                     ),
					    
					                array(
										'type' => 'radiobutton',
										'name' => 'twi_fe_lab_pos',
										'label' => __('Featured Label Position', 'twi_awesome_woo_slider_carousel'),
										'items' => array(
											            array(
															'value' => 'left',
															'label' => __('Left', 'twi_awesome_woo_slider_carousel'),
														),
														array(
															'value' => 'right',
															'label' => __('Right', 'twi_awesome_woo_slider_carousel'),
														),					
													),
										'default' => array('right'),
					                ),
					                
							    ),
							),

                               array(
									'type' => 'radiobutton',
									'name' => 'twi_temp_style',
									'label' => __('Template Styles With Live Preview', 'twi_awesome_woo_slider_carousel'),
									'items' => array(
												  array(
													'value' => 'normal',
													'label' => __('Normal Style', 'twi_awesome_woo_slider_carousel'),
												   ),
												   array(
														'value' => 'woo_style',
														'label' => __('Woocommerce Style (Not Suitable for all themes)', 'twi_awesome_woo_slider_carousel'),
													),
													array(
														'value' => 'hover',
														'label' => __('Hover Effects', 'twi_awesome_woo_slider_carousel'),
													),
													array(
													    'value' => 'overlay',
														'label' => __('Overlay', 'twi_awesome_woo_slider_carousel'),
													),
													// array(
													//     'value' => 'slide',
													// 	'label' => __('Slide Effects', 'twi_awesome_woo_slider_carousel'),
													// ),
													array(
													    'value' => 'img_only',
														'label' => __('Only Image', 'twi_awesome_woo_slider_carousel'),
													),
																						
															),
								    'default' => array('normal'),
								),


								array(
								    'type'      => 'group',
								    'repeating' => false,
								    'length'    => 1,
								    'name'      => 'nor_preview_group',
								    'title'     => __('Normal Style Preview', 'twi_awesome_woo_slider_carousel'),
								    'dependency' => array(
										'field' => 'twi_temp_style',
										'function' => 'woo_no_pre_fun',
									),
								    'fields'    => array(
								    	array(
											'type' => 'html',
											'name' => 'normal_live_preview',
											'binding' => array(
												'field' => 'font,style,weight,nor_bg,nor_border,nor_bor_col,nor_border_width,nor_con_pos,h3_col,h3_col_hover,h3_font_size,h3_txt_trans,fo_color,fo_size,star_color,cart_col,cart_col_hover,cart_bg,cart_bg_hover,cart_bor,cart_bor_hover,cart_bor_wid,cart_txt_trans,cart_bor_rad,cart_fo_size,sale_bg,sale_txt,out_bg,out_txt,fe_bg,fe_txt,st_si',
												'function' => 'woo_nor_live_preview',
										     ),
										),
										array(
										'type' => 'select',
										'name' => 'font',
										'label' => __('Font Face', 'twi_ad_tax_show'),
										'description' => __('<b>Default:</b> Roboto', 'twi_ad_tax_show'),
										'items' => array(
													'data' => array(
														array(
															'source' => 'function',
															'value' => 'vp_get_gwf_family',
														),
													),
												),
												'default' => array(
													'Roboto',
										    ),
										),

										array(
										'type' => 'radiobutton',
										'name' => 'style',
										'label' => __('Font Style', 'twi_ad_tax_show'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_style',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),
									array(
										'type' => 'radiobutton',
										'name' => 'weight',
										'label' => __('Font Weight', 'twi_ad_tax_show'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_weight',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),
									array(
											'type' => 'color',
											'name' => 'nor_bg',
											'label' => __('Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#eee',
									),
									array(
											'type' => 'radiobutton',
											'name' => 'nor_con_pos',
											'label' => __('Content Position', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
														  array(
															'value' => 'left',
															'label' => __('Left', 'twi_awesome_woo_slider_carousel'),
														   ),
														   array(
																'value' => 'center',
																'label' => __('Center', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => 'right',
																'label' => __('Right', 'twi_awesome_woo_slider_carousel'),
															),										
													),
										    'default' => array('left'),
									),
									array(
										    'type' => 'slider',
										    'name' => 'nor_border',
										    'label' => __('Border Radius', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),
									array(
											'type' => 'color',
											'name' => 'nor_bor_col',
											'label' => __('Border Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#eee',
									),
									array(
										    'type' => 'slider',
										    'name' => 'nor_border_width',
										    'label' => __('Border Thickness', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),

										array(
									        'type' => 'notebox',
									        'name' => 'nb_1',
									        'description' => __('<h3>Product Title Setting</h3>', 'vp_textdomain'),
									        'status' => 'success',
									    ),

										array(
											'type' => 'color',
											'name' => 'h3_col',
											'label' => __('Title Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
										),
										array(
											'type' => 'color',
											'name' => 'h3_col_hover',
											'label' => __('Title Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
										),
										array(
										    'type' => 'slider',
										    'name' => 'h3_font_size',
										    'label' => __('Title Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '75',
										    'step' => '1',
										    'default' => '16',
										),
										array(
											'type' => 'radiobutton',
											'name' => 'h3_txt_trans',
											'label' => __('Title Text Style', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
														  array(
															'value' => 'uppercase',
															'label' => __('Uppercase', 'twi_awesome_woo_slider_carousel'),
														   ),
														   array(
																'value' => 'lowercase',
																'label' => __('Lowercase', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => 'inherit',
																'label' => __('Inherit', 'twi_awesome_woo_slider_carousel'),
															),
															array(
															    'value' => 'capitalize',
																'label' => __('Capitalize', 'twi_awesome_woo_slider_carousel'),
															),
																								
													),
										    'default' => array('inherit'),
										),

										array(
									        'type' => 'notebox',
									        'name' => 'nb_2',
									        'description' => __('<h3>Product Price Setting</h3>', 'vp_textdomain'),
									        'status' => 'success',
									    ),

									array(
											'type' => 'color',
											'name' => 'fo_color',
											'label' => __('Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
										    'type' => 'slider',
										    'name' => 'fo_size',
										    'label' => __('Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '75',
										    'step' => '1',
										    'default' => '12',
										),
									array(
									        'type' => 'notebox',
									        'name' => 'nb_3',
									        'description' => __('<h3>Product Star Setting</h3>', 'vp_textdomain'),
									        'status' => 'success',
									    ),
									array(
										'type' => 'color',
										'name' => 'star_color',
										'label' => __('Star Color', 'twi_awesome_woo_slider_carousel'),
										'default' => '#000',
									),
									array(
										    'type' => 'slider',
										    'name' => 'st_si',
										    'label' => __('Star Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '25',
										    'step' => '1',
										    'default' => '12',
										),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_4',
									        'description' => __('<h3>Cart Settings</h3>', 'vp_textdomain'),
									        'status' => 'success',
									),
									array(
											'type' => 'color',
											'name' => 'cart_col',
											'label' => __('Cart Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
											'type' => 'radiobutton',
											'name' => 'cart_txt_trans',
											'label' => __('Title Text Style', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
														  array(
															'value' => 'uppercase',
															'label' => __('Uppercase', 'twi_awesome_woo_slider_carousel'),
														   ),
														   array(
																'value' => 'lowercase',
																'label' => __('Lowercase', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => 'inherit',
																'label' => __('Inherit', 'twi_awesome_woo_slider_carousel'),
															),
															array(
															    'value' => 'capitalize',
																'label' => __('Capitalize', 'twi_awesome_woo_slider_carousel'),
															),
																								
													),
										    'default' => array('inherit'),
										),

									array(
											'type' => 'color',
											'name' => 'cart_bg',
											'label' => __('Cart Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_fo_size',
										    'label' => __('Cart Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '50',
										    'step' => '1',
										    'default' => '14',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_bor_wid',
										    'label' => __('Cart Border Width', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '2',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bor',
											'label' => __('Cart Border Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
											'type' => 'color',
											'name' => 'cart_col_hover',
											'label' => __('Cart Text Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bg_hover',
											'label' => __('Cart Background (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bor_hover',
											'label' => __('Cart Border Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_bor_rad',
										    'label' => __('Cart Border Radius', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_5',
									        'description' => __('<h3>Label/Ribbon Settings</h3>', 'vp_textdomain'),
									        'status' => 'success',
									),
									array(
											'type' => 'color',
											'name' => 'sale_bg',
											'label' => __('Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'sale_txt',
											'label' => __('Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'out_bg',
											'label' => __('Out of Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#DC6868',
									),
									array(
											'type' => 'color',
											'name' => 'out_txt',
											'label' => __('Out of Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'fe_bg',
											'label' => __('Featured Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'fe_txt',
											'label' => __('Featured Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									


								    ),
								 ),



								array(
								    'type'      => 'group',
								    'repeating' => false,
								    'length'    => 1,
								    'name'      => 'img_preview_group',
								    'title'     => __('Image Only Preview', 'twi_awesome_woo_slider_carousel'),
								    'dependency' => array(
										'field' => 'twi_temp_style',
										'function' => 'woo_img_pre_fun',
									),
								    'fields'    => array(
								    	array(
											'type' => 'html',
											'name' => 'img_live_preview',
											'binding' => array(
												'field' => 'font,style,weight,nor_border,nor_bor_col,nor_border_width,sale_bg,sale_txt,out_bg,out_txt,fe_bg,fe_txt',
												'function' => 'woo_img_live_preview',
										     ),
										),
										array(
										'type' => 'select',
										'name' => 'font',
										'label' => __('Font Face', 'twi_ad_tax_show'),
										'description' => __('<b>Default:</b> Roboto', 'twi_ad_tax_show'),
										'items' => array(
													'data' => array(
														array(
															'source' => 'function',
															'value' => 'vp_get_gwf_family',
														),
													),
												),
												'default' => array(
													'Roboto',
										    ),
										),

										array(
										'type' => 'radiobutton',
										'name' => 'style',
										'label' => __('Font Style', 'twi_ad_tax_show'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_style',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),
									array(
										'type' => 'radiobutton',
										'name' => 'weight',
										'label' => __('Font Weight', 'twi_ad_tax_show'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_weight',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),
									array(
										    'type' => 'slider',
										    'name' => 'nor_border',
										    'label' => __('Border Radius', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),
									array(
											'type' => 'color',
											'name' => 'nor_bor_col',
											'label' => __('Border Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#eee',
									),
									array(
										    'type' => 'slider',
										    'name' => 'nor_border_width',
										    'label' => __('Border Thickness', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_5',
									        'description' => __('<h3>Label/Ribbon Settings</h3>', 'vp_textdomain'),
									        'status' => 'success',
									),
									array(
											'type' => 'color',
											'name' => 'sale_bg',
											'label' => __('Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'sale_txt',
											'label' => __('Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'out_bg',
											'label' => __('Out of Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#DC6868',
									),
									array(
											'type' => 'color',
											'name' => 'out_txt',
											'label' => __('Out of Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'fe_bg',
											'label' => __('Featured Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'fe_txt',
											'label' => __('Featured Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									


								    ),
								 ),

								array(
								    'type'      => 'group',
								    'repeating' => false,
								    'length'    => 1,
								    'name'      => 'hover_preview_group',
								    'title'     => __('Hover Style Preview', 'twi_awesome_woo_slider_carousel'),
								    'dependency' => array(
										'field' => 'twi_temp_style',
										'function' => 'woo_hover_pre_fun',
									),
								    'fields'    => array(
								    	array(
											'type' => 'html',
											'name' => 'hover_live_preview',
											'binding' => array(
												'field' => 'font,style,weight,nor_bg,nor_border,nor_bor_col,nor_border_width,h3_col,h3_col_hover,h3_font_size,h3_txt_trans,fo_color,fo_size,star_color,cart_col,cart_col_hover,cart_bg,cart_bg_hover,cart_bor,cart_bor_hover,cart_bor_wid,cart_txt_trans,cart_bor_rad,cart_fo_size,sale_bg,sale_txt,out_bg,out_txt,fe_bg,fe_txt,st_si,over_eff,img_eff,title_an,price_an,rating_an,cart_an',
												'function' => 'woo_hover_live_preview',
										     ),
										),
										array(
										'type' => 'select',
										'name' => 'font',
										'label' => __('Font Face', 'twi_ad_tax_show'),
										'description' => __('<b>Default:</b> Roboto', 'twi_ad_tax_show'),
										'items' => array(
													'data' => array(
														array(
															'source' => 'function',
															'value' => 'vp_get_gwf_family',
														),
													),
												),
												'default' => array(
													'Roboto',
										    ),
										),

										array(
										'type' => 'radiobutton',
										'name' => 'style',
										'label' => __('Font Style', 'twi_ad_tax_show'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_style',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),
									array(
										'type' => 'radiobutton',
										'name' => 'weight',
										'label' => __('Font Weight', 'twi_ad_tax_show'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_weight',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),

                                    array(
								        'type' => 'select',
								        'name' => 'over_eff',
								        'label' => __('Overlay Effects', 'twi_ad_tax_show'),
								        'items' => array(
								        	array(
								                'value' => 'fade',
								                'label' => __('Fade', 'twi_ad_tax_show'),
								            ),
								            array(
								                'value' => 'bottom-to-top',
								                'label' => __('Bottom To Top', 'twi_ad_tax_show'),
								            ),
								            array(
								                'value' => 'top-to-bottom',
								                'label' => __('Top to Bottom', 'twi_ad_tax_show'),
								            ),
								            array(
								                'value' => 'left-to-right',
								                'label' => __('Left to Right', 'twi_ad_tax_show'),
								            ),
								            array(
								                'value' => 'right-to-left',
								                'label' => __('Right to Left', 'twi_ad_tax_show'),
								            ),
								            array(
								                'value' => 'open-down',
								                'label' => __('Open Down', 'twi_ad_tax_show'),
								            ),
								            array(
								                'value' => 'open-left',
								                'label' => __('Open Left', 'twi_ad_tax_show'),
								            ),
								            array(
								                'value' => 'open-right',
								                'label' => __('Open Right', 'twi_ad_tax_show'),
								            ),
								            array(
								                'value' => 'come-right',
								                'label' => __('Come Right', 'twi_ad_tax_show'),
								            ),
								            array(
								                'value' => 'come-left',
								                'label' => __('Come Left', 'twi_ad_tax_show'),
								            ),
								        ),
								        'default' => array(
								            'fade',
								        ),
								    ),



                                    
                                    array(
								        'type' => 'radiobutton',
								        'name' => 'img_eff',
								        'label' => __('Overlay Effects', 'twi_ad_tax_show'),
								        'items' => array(
								        	array(
								                'value' => 'twi-img-normal',
								                'label' => __('Normal', 'twi_ad_tax_show'),
								            ),
								        	array(
								                'value' => 'twi-overlay-fade',
								                'label' => __('Fade', 'twi_ad_tax_show'),
								            ),
								            array(
								                'value' => 'twi-overlay-scale',
								                'label' => __('Scale', 'twi_ad_tax_show'),
								            ),
								            array(
								                'value' => 'twi-overlay-spin',
								                'label' => __('Spin', 'twi_ad_tax_show'),
								            ),
								            array(
								                'value' => 'twi-overlay-grayscale',
								                'label' => __('Grayscale (Before Hover)', 'twi_ad_tax_show'),
								            ),
								            array(
								                'value' => 'twi-overlay-twi-grayscale',
								                'label' => __('Grayscale (After Hover)', 'twi_ad_tax_show'),
								            ),
								        ),
								        'default' => array(
								            'twi-img-normal',
								        ),
								    ),

									array(
											'type' => 'color',
											'name' => 'nor_bg',
											'label' => __('Background', 'twi_awesome_woo_slider_carousel'),
											'default' => 'rgba(44, 62, 80, 0.5)',
											'format' => 'rgba',
									),
									
									array(
										    'type' => 'slider',
										    'name' => 'nor_border',
										    'label' => __('Border Radius(%)', 'twi_awesome_woo_slider_carousel'),
										    'description' => __('50% --> Circle', 'twi_ad_tax_show'),
										    'min' => '0',
										    'max' => '50',
										    'step' => '1',
										    'default' => '0',
									),
									array(
											'type' => 'color',
											'name' => 'nor_bor_col',
											'label' => __('Border Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#eee',
									),
									array(
										    'type' => 'slider',
										    'name' => 'nor_border_width',
										    'label' => __('Border Thickness', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),

										array(
									        'type' => 'notebox',
									        'name' => 'nb_1',
									        'description' => __('<h3>Product Title Setting</h3>', 'vp_textdomain'),
									        'status' => 'success',
									    ),

										array(
											'type' => 'color',
											'name' => 'h3_col',
											'label' => __('Title Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
										),
										array(
											'type' => 'color',
											'name' => 'h3_col_hover',
											'label' => __('Title Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
										),
										array(
										    'type' => 'slider',
										    'name' => 'h3_font_size',
										    'label' => __('Title Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '75',
										    'step' => '1',
										    'default' => '16',
										),
										array(
											'type' => 'radiobutton',
											'name' => 'h3_txt_trans',
											'label' => __('Title Text Style', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
														  array(
															'value' => 'uppercase',
															'label' => __('Uppercase', 'twi_awesome_woo_slider_carousel'),
														   ),
														   array(
																'value' => 'lowercase',
																'label' => __('Lowercase', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => 'inherit',
																'label' => __('Inherit', 'twi_awesome_woo_slider_carousel'),
															),
															array(
															    'value' => 'capitalize',
																'label' => __('Capitalize', 'twi_awesome_woo_slider_carousel'),
															),
																								
													),
										    'default' => array('inherit'),
										),

										array(
										 'name'  => 'title_an',
										 'type'  => 'select',
										 'label' => __('Title animation', 'twi_awesome_woo_slider_carousel'),
										 'items' => array(
										    array(
														'value' => 'no-animtion',
														'label' => __('No animation', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											array(
														'value' => 'bounce',
														'label' => __('Bounce', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											array(
														'value' => 'flash',
														'label' => __('Flash', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											array(
														'value' => 'pulse',
														'label' => __('Pulse', 'twi_awesome_woo_slider_carousel'),
											      ),  
											      
											 array(
														'value' => 'rubberBand',
														'label' => __('Rubber Band', 'twi_awesome_woo_slider_carousel'),
											      ), 
											      
											 array(
														'value' => 'shake',
														'label' => __('Shake', 'twi_awesome_woo_slider_carousel'),
											      ), 
											      
											 array(
														'value' => 'swing',
														'label' => __('Swing', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											 array(
														'value' => 'tada',
														'label' => __('Tada', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'wobble',
														'label' => __('Wobble', 'twi_awesome_woo_slider_carousel'),
											      ),
											   
											   array(
														'value' => 'bounceIn',
														'label' => __('Bounce In', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'bounceInDown',
														'label' => __('Bounce In Down', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'bounceInLeft',
														'label' => __('Bounce In Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'bounceInRight',
														'label' => __('Bounce In Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'bounceInUp',
														'label' => __('Bounce In Up', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											    array(
														'value' => 'fadeIn',
														'label' => __('Fade In', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											    array(
														'value' => 'fadeInDown',
														'label' => __('Fade In Down', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'fadeInDownBig',
														'label' => __('Fade In Down Big', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											    array(
														'value' => 'fadeInLeft',
														'label' => __('Fade In Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'fadeInLeftBig',
														'label' => __('Fade In Left Big', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'fadeInRight',
														'label' => __('Fade In Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'fadeInRightBig',
														'label' => __('Fade In Right Big', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'fadeInUp',
														'label' => __('Fade In Up', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'fadeInUpBig',
														'label' => __('Fade In Up Big', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'flip',
														'label' => __('Flip', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'flipInX',
														'label' => __('Flip In X', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'flipInY',
														'label' => __('Flip In Y', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'lightSpeedIn',
														'label' => __('Light Speed In', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rotateIn',
														'label' => __('Rotate In', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rotateInDownLeft',
														'label' => __('Rotate In Down Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rotateInDownRight',
														'label' => __('Rotate In Down Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rotateInUpLeft',
														'label' => __('Rotate In Up Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rotateInUpRight',
														'label' => __('Rotate In Up Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'slideInDown',
														'label' => __('Slide In Down', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'slideInLeft',
														'label' => __('Slide In Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'slideInRight',
														'label' => __('Slide In Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'hinge',
														'label' => __('Hinge', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rollIn',
														'label' => __('Roll In', 'twi_awesome_woo_slider_carousel'),
											      ),
											  											      
											   ),
											    'default' => 'no-animtion',
										    ),
										    

										array(
									        'type' => 'notebox',
									        'name' => 'nb_2',
									        'description' => __('<h3>Product Price Setting</h3>', 'vp_textdomain'),
									        'status' => 'success',
									    ),

									array(
											'type' => 'color',
											'name' => 'fo_color',
											'label' => __('Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
										    'type' => 'slider',
										    'name' => 'fo_size',
										    'label' => __('Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '75',
										    'step' => '1',
										    'default' => '12',
										),

									array(
										 'name'  => 'price_an',
										 'type'  => 'select',
										 'label' => __('Price animation', 'twi_awesome_woo_slider_carousel'),
										 'items' => array(
										    array(
														'value' => 'no-animtion',
														'label' => __('No animation', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											array(
														'value' => 'bounce',
														'label' => __('Bounce', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											array(
														'value' => 'flash',
														'label' => __('Flash', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											array(
														'value' => 'pulse',
														'label' => __('Pulse', 'twi_awesome_woo_slider_carousel'),
											      ),  
											      
											 array(
														'value' => 'rubberBand',
														'label' => __('Rubber Band', 'twi_awesome_woo_slider_carousel'),
											      ), 
											      
											 array(
														'value' => 'shake',
														'label' => __('Shake', 'twi_awesome_woo_slider_carousel'),
											      ), 
											      
											 array(
														'value' => 'swing',
														'label' => __('Swing', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											 array(
														'value' => 'tada',
														'label' => __('Tada', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'wobble',
														'label' => __('Wobble', 'twi_awesome_woo_slider_carousel'),
											      ),
											   
											   array(
														'value' => 'bounceIn',
														'label' => __('Bounce In', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'bounceInDown',
														'label' => __('Bounce In Down', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'bounceInLeft',
														'label' => __('Bounce In Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'bounceInRight',
														'label' => __('Bounce In Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'bounceInUp',
														'label' => __('Bounce In Up', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											    array(
														'value' => 'fadeIn',
														'label' => __('Fade In', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											    array(
														'value' => 'fadeInDown',
														'label' => __('Fade In Down', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'fadeInDownBig',
														'label' => __('Fade In Down Big', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											    array(
														'value' => 'fadeInLeft',
														'label' => __('Fade In Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'fadeInLeftBig',
														'label' => __('Fade In Left Big', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'fadeInRight',
														'label' => __('Fade In Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'fadeInRightBig',
														'label' => __('Fade In Right Big', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'fadeInUp',
														'label' => __('Fade In Up', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'fadeInUpBig',
														'label' => __('Fade In Up Big', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'flip',
														'label' => __('Flip', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'flipInX',
														'label' => __('Flip In X', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'flipInY',
														'label' => __('Flip In Y', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'lightSpeedIn',
														'label' => __('Light Speed In', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rotateIn',
														'label' => __('Rotate In', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rotateInDownLeft',
														'label' => __('Rotate In Down Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rotateInDownRight',
														'label' => __('Rotate In Down Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rotateInUpLeft',
														'label' => __('Rotate In Up Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rotateInUpRight',
														'label' => __('Rotate In Up Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'slideInDown',
														'label' => __('Slide In Down', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'slideInLeft',
														'label' => __('Slide In Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'slideInRight',
														'label' => __('Slide In Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'hinge',
														'label' => __('Hinge', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rollIn',
														'label' => __('Roll In', 'twi_awesome_woo_slider_carousel'),
											      ),
											  											      
											   ),
											    'default' => 'no-animtion',
										    ),
									array(
									        'type' => 'notebox',
									        'name' => 'nb_3',
									        'description' => __('<h3>Product Star Setting</h3>', 'vp_textdomain'),
									        'status' => 'success',
									    ),
									array(
										'type' => 'color',
										'name' => 'star_color',
										'label' => __('Star Color', 'twi_awesome_woo_slider_carousel'),
										'default' => '#fff',
									),
									array(
										    'type' => 'slider',
										    'name' => 'st_si',
										    'label' => __('Star Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '25',
										    'step' => '1',
										    'default' => '12',
										),

									array(
										 'name'  => 'rating_an',
										 'type'  => 'select',
										 'label' => __('Rating animation', 'twi_awesome_woo_slider_carousel'),
										 'items' => array(
										    array(
														'value' => 'no-animtion',
														'label' => __('No animation', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											array(
														'value' => 'animated bounce',
														'label' => __('Bounce', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											array(
														'value' => 'animated flash',
														'label' => __('Flash', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											array(
														'value' => 'animated pulse',
														'label' => __('Pulse', 'twi_awesome_woo_slider_carousel'),
											      ),  
											      
											 array(
														'value' => 'animated rubberBand',
														'label' => __('Rubber Band', 'twi_awesome_woo_slider_carousel'),
											      ), 
											      
											 array(
														'value' => 'animated shake',
														'label' => __('Shake', 'twi_awesome_woo_slider_carousel'),
											      ), 
											      
											 array(
														'value' => 'animated swing',
														'label' => __('Swing', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											 array(
														'value' => 'animated tada',
														'label' => __('Tada', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'animated wobble',
														'label' => __('Wobble', 'twi_awesome_woo_slider_carousel'),
											      ),
											   
											   array(
														'value' => 'animated bounceIn',
														'label' => __('Bounce In', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'animated bounceInDown',
														'label' => __('Bounce In Down', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'animated bounceInLeft',
														'label' => __('Bounce In Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'animated bounceInRight',
														'label' => __('Bounce In Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'animated bounceInUp',
														'label' => __('Bounce In Up', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											    array(
														'value' => 'animated fadeIn',
														'label' => __('Fade In', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											    array(
														'value' => 'animated fadeInDown',
														'label' => __('Fade In Down', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'animated fadeInDownBig',
														'label' => __('Fade In Down Big', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											    array(
														'value' => 'animated fadeInLeft',
														'label' => __('Fade In Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated fadeInLeftBig',
														'label' => __('Fade In Left Big', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated fadeInRight',
														'label' => __('Fade In Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated fadeInRightBig',
														'label' => __('Fade In Right Big', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated fadeInUp',
														'label' => __('Fade In Up', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated fadeInUpBig',
														'label' => __('Fade In Up Big', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated flip',
														'label' => __('Flip', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated flipInX',
														'label' => __('Flip In X', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated flipInY',
														'label' => __('Flip In Y', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated lightSpeedIn',
														'label' => __('Light Speed In', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated rotateIn',
														'label' => __('Rotate In', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated rotateInDownLeft',
														'label' => __('Rotate In Down Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated rotateInDownRight',
														'label' => __('Rotate In Down Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated rotateInUpLeft',
														'label' => __('Rotate In Up Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated rotateInUpRight',
														'label' => __('Rotate In Up Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated slideInDown',
														'label' => __('Slide In Down', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated slideInLeft',
														'label' => __('Slide In Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated slideInRight',
														'label' => __('Slide In Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated hinge',
														'label' => __('Hinge', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'animated rollIn',
														'label' => __('Roll In', 'twi_awesome_woo_slider_carousel'),
											      ),
											  											      
											   ),
											    'default' => 'no-animtion',
										    ),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_4',
									        'description' => __('<h3>Cart Settings</h3>', 'vp_textdomain'),
									        'status' => 'success',
									),
									array(
											'type' => 'color',
											'name' => 'cart_col',
											'label' => __('Cart Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
											'type' => 'radiobutton',
											'name' => 'cart_txt_trans',
											'label' => __('Title Text Style', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
														  array(
															'value' => 'uppercase',
															'label' => __('Uppercase', 'twi_awesome_woo_slider_carousel'),
														   ),
														   array(
																'value' => 'lowercase',
																'label' => __('Lowercase', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => 'inherit',
																'label' => __('Inherit', 'twi_awesome_woo_slider_carousel'),
															),
															array(
															    'value' => 'capitalize',
																'label' => __('Capitalize', 'twi_awesome_woo_slider_carousel'),
															),
																								
													),
										    'default' => array('inherit'),
										),

									array(
											'type' => 'color',
											'name' => 'cart_bg',
											'label' => __('Cart Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
											'format' => 'rgba',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_fo_size',
										    'label' => __('Cart Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '50',
										    'step' => '1',
										    'default' => '12',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_bor_wid',
										    'label' => __('Cart Border Width', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '2',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bor',
											'label' => __('Cart Border Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
											'type' => 'color',
											'name' => 'cart_col_hover',
											'label' => __('Cart Text Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bg_hover',
											'label' => __('Cart Background (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
											'format' => 'rgba',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bor_hover',
											'label' => __('Cart Border Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_bor_rad',
										    'label' => __('Cart Border Radius', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),

									array(
										 'name'  => 'cart_an',
										 'type'  => 'select',
										 'label' => __('Cart button animation', 'twi_awesome_woo_slider_carousel'),
										 'items' => array(
										    array(
														'value' => 'no-animtion',
														'label' => __('No animation', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											array(
														'value' => 'bounce',
														'label' => __('Bounce', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											array(
														'value' => 'flash',
														'label' => __('Flash', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											array(
														'value' => 'pulse',
														'label' => __('Pulse', 'twi_awesome_woo_slider_carousel'),
											      ),  
											      
											 array(
														'value' => 'rubberBand',
														'label' => __('Rubber Band', 'twi_awesome_woo_slider_carousel'),
											      ), 
											      
											 array(
														'value' => 'shake',
														'label' => __('Shake', 'twi_awesome_woo_slider_carousel'),
											      ), 
											      
											 array(
														'value' => 'swing',
														'label' => __('Swing', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											 array(
														'value' => 'tada',
														'label' => __('Tada', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'wobble',
														'label' => __('Wobble', 'twi_awesome_woo_slider_carousel'),
											      ),
											   
											   array(
														'value' => 'bounceIn',
														'label' => __('Bounce In', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'bounceInDown',
														'label' => __('Bounce In Down', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'bounceInLeft',
														'label' => __('Bounce In Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'bounceInRight',
														'label' => __('Bounce In Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'bounceInUp',
														'label' => __('Bounce In Up', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											    array(
														'value' => 'fadeIn',
														'label' => __('Fade In', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											    array(
														'value' => 'fadeInDown',
														'label' => __('Fade In Down', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											   array(
														'value' => 'fadeInDownBig',
														'label' => __('Fade In Down Big', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											    array(
														'value' => 'fadeInLeft',
														'label' => __('Fade In Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'fadeInLeftBig',
														'label' => __('Fade In Left Big', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'fadeInRight',
														'label' => __('Fade In Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'fadeInRightBig',
														'label' => __('Fade In Right Big', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'fadeInUp',
														'label' => __('Fade In Up', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'fadeInUpBig',
														'label' => __('Fade In Up Big', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'flip',
														'label' => __('Flip', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'flipInX',
														'label' => __('Flip In X', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'flipInY',
														'label' => __('Flip In Y', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'lightSpeedIn',
														'label' => __('Light Speed In', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rotateIn',
														'label' => __('Rotate In', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rotateInDownLeft',
														'label' => __('Rotate In Down Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rotateInDownRight',
														'label' => __('Rotate In Down Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rotateInUpLeft',
														'label' => __('Rotate In Up Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rotateInUpRight',
														'label' => __('Rotate In Up Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'slideInDown',
														'label' => __('Slide In Down', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'slideInLeft',
														'label' => __('Slide In Left', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'slideInRight',
														'label' => __('Slide In Right', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'hinge',
														'label' => __('Hinge', 'twi_awesome_woo_slider_carousel'),
											      ),
											      
											      array(
														'value' => 'rollIn',
														'label' => __('Roll In', 'twi_awesome_woo_slider_carousel'),
											      ),
											  											      
											   ),
											    'default' => 'no-animtion',
										    ),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_5',
									        'description' => __('<h3>Label/Ribbon Settings</h3>', 'vp_textdomain'),
									        'status' => 'success',
									),
									array(
											'type' => 'color',
											'name' => 'sale_bg',
											'label' => __('Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'sale_txt',
											'label' => __('Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'out_bg',
											'label' => __('Out of Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#DC6868',
									),
									array(
											'type' => 'color',
											'name' => 'out_txt',
											'label' => __('Out of Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'fe_bg',
											'label' => __('Featured Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'fe_txt',
											'label' => __('Featured Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									


								    ),
								 ),



								array(
								    'type'      => 'group',
								    'repeating' => false,
								    'length'    => 1,
								    'name'      => 'over_preview_group',
								    'title'     => __('Overlay Style Preview', 'twi_awesome_woo_slider_carousel'),
								    'dependency' => array(
										'field' => 'twi_temp_style',
										'function' => 'woo_over_pre_fun',
									),
								    'fields'    => array(
								    	array(
											'type' => 'html',
											'name' => 'over_live_preview',
											'binding' => array(
												'field' => 'font,style,weight,nor_bg,nor_border,nor_bor_col,nor_border_width,h3_col,h3_col_hover,h3_font_size,h3_txt_trans,fo_color,fo_size,star_color,cart_col,cart_col_hover,cart_bg,cart_bg_hover,cart_bor,cart_bor_hover,cart_bor_wid,cart_txt_trans,cart_bor_rad,cart_fo_size,sale_bg,sale_txt,out_bg,out_txt,fe_bg,fe_txt,st_si',
												'function' => 'woo_over_live_preview',
										     ),
										),
										array(
										'type' => 'select',
										'name' => 'font',
										'label' => __('Font Face', 'twi_ad_tax_show'),
										'description' => __('<b>Default:</b> Roboto', 'twi_ad_tax_show'),
										'items' => array(
													'data' => array(
														array(
															'source' => 'function',
															'value' => 'vp_get_gwf_family',
														),
													),
												),
												'default' => array(
													'Roboto',
										    ),
										),

										array(
										'type' => 'radiobutton',
										'name' => 'style',
										'label' => __('Font Style', 'twi_ad_tax_show'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_style',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),
									array(
										'type' => 'radiobutton',
										'name' => 'weight',
										'label' => __('Font Weight', 'twi_ad_tax_show'),
													'items' => array(
														'data' => array(
															array(
																'source' => 'binding',
																'field' => 'font',
																'value' => 'vp_get_gwf_weight',
															),
														),
													),
													'default' => array(
														'{{first}}',
													),
									),


									array(
											'type' => 'color',
											'name' => 'nor_bg',
											'label' => __('Background', 'twi_awesome_woo_slider_carousel'),
											'default' => 'rgba(44, 62, 80, 0.5)',
											'format' => 'rgba',
									),
									
									array(
										    'type' => 'slider',
										    'name' => 'nor_border',
										    'label' => __('Border Radius(%)', 'twi_awesome_woo_slider_carousel'),
										    'description' => __('50% --> Circle', 'twi_ad_tax_show'),
										    'min' => '0',
										    'max' => '50',
										    'step' => '1',
										    'default' => '0',
									),
									array(
											'type' => 'color',
											'name' => 'nor_bor_col',
											'label' => __('Border Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#eee',
									),
									array(
										    'type' => 'slider',
										    'name' => 'nor_border_width',
										    'label' => __('Border Thickness', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),

										array(
									        'type' => 'notebox',
									        'name' => 'nb_1',
									        'description' => __('<h3>Product Title Setting</h3>', 'vp_textdomain'),
									        'status' => 'success',
									    ),

										array(
											'type' => 'color',
											'name' => 'h3_col',
											'label' => __('Title Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
										),
										array(
											'type' => 'color',
											'name' => 'h3_col_hover',
											'label' => __('Title Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
										),
										array(
										    'type' => 'slider',
										    'name' => 'h3_font_size',
										    'label' => __('Title Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '75',
										    'step' => '1',
										    'default' => '16',
										),
										array(
											'type' => 'radiobutton',
											'name' => 'h3_txt_trans',
											'label' => __('Title Text Style', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
														  array(
															'value' => 'uppercase',
															'label' => __('Uppercase', 'twi_awesome_woo_slider_carousel'),
														   ),
														   array(
																'value' => 'lowercase',
																'label' => __('Lowercase', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => 'inherit',
																'label' => __('Inherit', 'twi_awesome_woo_slider_carousel'),
															),
															array(
															    'value' => 'capitalize',
																'label' => __('Capitalize', 'twi_awesome_woo_slider_carousel'),
															),
																								
													),
										    'default' => array('inherit'),
										),
										    

										array(
									        'type' => 'notebox',
									        'name' => 'nb_2',
									        'description' => __('<h3>Product Price Setting</h3>', 'vp_textdomain'),
									        'status' => 'success',
									    ),

									array(
											'type' => 'color',
											'name' => 'fo_color',
											'label' => __('Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
										    'type' => 'slider',
										    'name' => 'fo_size',
										    'label' => __('Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '10',
										    'max' => '75',
										    'step' => '1',
										    'default' => '12',
										),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_3',
									        'description' => __('<h3>Product Star Setting</h3>', 'vp_textdomain'),
									        'status' => 'success',
									    ),
									array(
										'type' => 'color',
										'name' => 'star_color',
										'label' => __('Star Color', 'twi_awesome_woo_slider_carousel'),
										'default' => '#fff',
									),
									array(
										    'type' => 'slider',
										    'name' => 'st_si',
										    'label' => __('Star Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '12',
										    'max' => '25',
										    'step' => '1',
										    'default' => '13',
										),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_4',
									        'description' => __('<h3>Cart Settings</h3>', 'vp_textdomain'),
									        'status' => 'success',
									),
									array(
											'type' => 'color',
											'name' => 'cart_col',
											'label' => __('Cart Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
											'type' => 'radiobutton',
											'name' => 'cart_txt_trans',
											'label' => __('Title Text Style', 'twi_awesome_woo_slider_carousel'),
											'items' => array(
														  array(
															'value' => 'uppercase',
															'label' => __('Uppercase', 'twi_awesome_woo_slider_carousel'),
														   ),
														   array(
																'value' => 'lowercase',
																'label' => __('Lowercase', 'twi_awesome_woo_slider_carousel'),
															),
															array(
																'value' => 'inherit',
																'label' => __('Inherit', 'twi_awesome_woo_slider_carousel'),
															),
															array(
															    'value' => 'capitalize',
																'label' => __('Capitalize', 'twi_awesome_woo_slider_carousel'),
															),
																								
													),
										    'default' => array('inherit'),
										),

									array(
											'type' => 'color',
											'name' => 'cart_bg',
											'label' => __('Cart Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
											'format' => 'rgba',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_fo_size',
										    'label' => __('Cart Font Size', 'twi_awesome_woo_slider_carousel'),
										    'min' => '10',
										    'max' => '50',
										    'step' => '1',
										    'default' => '12',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_bor_wid',
										    'label' => __('Cart Border Width', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '2',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bor',
											'label' => __('Cart Border Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
											'type' => 'color',
											'name' => 'cart_col_hover',
											'label' => __('Cart Text Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#fff',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bg_hover',
											'label' => __('Cart Background (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
											'format' => 'rgba',
									),
									array(
											'type' => 'color',
											'name' => 'cart_bor_hover',
											'label' => __('Cart Border Color (Hover)', 'twi_awesome_woo_slider_carousel'),
											'default' => '#000',
									),
									array(
										    'type' => 'slider',
										    'name' => 'cart_bor_rad',
										    'label' => __('Cart Border Radius', 'twi_awesome_woo_slider_carousel'),
										    'min' => '0',
										    'max' => '10',
										    'step' => '1',
										    'default' => '0',
									),

									array(
									        'type' => 'notebox',
									        'name' => 'nb_5',
									        'description' => __('<h3>Label/Ribbon Settings</h3>', 'vp_textdomain'),
									        'status' => 'success',
									),
									array(
											'type' => 'color',
											'name' => 'sale_bg',
											'label' => __('Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'sale_txt',
											'label' => __('Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'out_bg',
											'label' => __('Out of Sales Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#DC6868',
									),
									array(
											'type' => 'color',
											'name' => 'out_txt',
											'label' => __('Out of Sales Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									array(
											'type' => 'color',
											'name' => 'fe_bg',
											'label' => __('Featured Background', 'twi_awesome_woo_slider_carousel'),
											'default' => '#00C4BC',
									),
									array(
											'type' => 'color',
											'name' => 'fe_txt',
											'label' => __('Featured Text Color', 'twi_awesome_woo_slider_carousel'),
											'default' => '#FFF',
									),
									


								    ),
								 ),




             
 	),
 );
?>