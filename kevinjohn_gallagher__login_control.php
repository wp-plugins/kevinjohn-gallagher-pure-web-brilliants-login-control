<?php
/*
	Plugin Name: 			Kevinjohn Gallagher: Pure Web Brilliant's Login Control
	Description: 			Adds the ability to style the WP Login page
	Version: 				2.1
	Author: 				Kevinjohn Gallagher
	Author URI: 			http://kevinjohngallagher.com/
	
	Contributors:			kevinjohngallagher, purewebbrilliant 
	Donate link:			http://kevinjohngallagher.com/
	Tags: 					kevinjohn gallagher, pure web brilliant, framework, cms, simple, multisite, style, login, images, branding
	Requires at least:		3.0
	Tested up to: 			3.4
	Stable tag: 			2.1
*/
/**
 *
 *	Kevinjohn Gallagher: Pure Web Brilliant's Login Control
 * ==============================================================
 *
 *	Adds the ability to style the WP Login page
 *
 *
 *	This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 *	General Public License as published by the Free Software Foundation; either version 3 of the License, 
 *	or (at your option) any later version.
 *
 * 	This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
 *	without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *	See the GNU General Public License (http://www.gnu.org/licenses/gpl-3.0.txt) for more details.
 *
 *	You should have received a copy of the GNU General Public License along with this program.  
 * 	If not, see http://www.gnu.org/licenses/ or http://www.gnu.org/licenses/gpl-3.0.txt
 *
 *
 *	Copyright (C) 2008-2012 Kevinjohn Gallagher / http://www.kevinjohngallagher.com
 *
 *
 *	@package				Pure Web Brilliant
 *	@version 				2.1
 *	@author 				Kevinjohn Gallagher <wordpress@kevinjohngallagher.com>
 *	@copyright 				Copyright (c) 2012, Kevinjohn Gallagher
 *	@link 					http://kevinjohngallagher.com
 *	@license 				http://www.gnu.org/licenses/gpl-3.0.txt
 *
 *
 */



	define( '_KEVINJOHN_GALLAGHER___login_control', '2.1' );



	if (class_exists('kevinjohn_gallagher')) 
	{
		
		
		class	kevinjohn_gallagher___login_control 
		extends kevinjohn_gallagher
		{
		
				/*
				**
				**		VARIABLES
				**
				*/
				const PM		=	'_kevinjohn_gallagher___login_control';
				
				var					$instance;
				var 				$plugin_name;
				var					$uniqueID;
				var					$plugin_dir;
				var					$plugin_url;
				var					$plugin_page_title; 
				var					$plugin_menu_title; 					
				var 				$plugin_slug;
				var 				$http_or_https;
				var 				$plugin_options;
				
				var 				$meta_array;
				var 				$post_type;

				var 				$is_login;

		
				/*
				**
				**		CONSTRUCT
				**
				*/
				public	function	__construct() 
				{
						$this->instance 					=&	$this;
						$this->plugin_name					=	"Kevinjohn Gallagher: Pure Web Brilliant's Login Control";
						$this->plugin_page_title			=	"login control"; 
						$this->plugin_menu_title			=	"login control"; 					
						$this->plugin_slug					=	"login-control";
						
						$this->meta_array					=	array();
						$this->meta_array['unique']			=	array();
						$this->meta_array['multiple']		=	array();
						
						
						add_action( 'init',				array( $this, 'init' ) );
						add_action( 'init',				array( $this, 'init_child' ) );
						add_action(	'admin_init',		array( $this, 'admin_init_register_settings'), 100);
						add_action( 'admin_menu',		array( $this, 'add_plugin_to_menu'));						
						
				}
				
				
				
				
				
				
				
				
				/*
				**
				**		INIT_CHILD
				**
				*/
			
				public function init_child() 
				{
						$this->plugin_dir										=	plugin_dir_path(__FILE__);	
						$this->plugin_url										=	plugin_dir_url(__FILE__);				
				
						$this->child_settings_sections 							=	array();
						$this->child_settings_array 							=	array();
						
						$this->is_login											= 	 in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
						
						add_action('login_head', 		array( $this, 'kjg_pwb_login_style'), 50);
						add_action('login_head', 		array( $this, 'kjg_pwb_passed_head'), 99);
						
						$this->groundhog_day 									= 	false;
						
						
						
				}
				
				
				
				
				
				public 	function 	define_child_settings_sections()
				{
				
						$this->child_settings_sections['section_logo']					= ' Logo: ';
						$this->child_settings_sections['section_background']			= ' Background: ';
						$this->child_settings_sections['section_colour']				= ' Colours: ';
						
				}		
				
				
				
				
				
				public 	function 	define_child_settings_array()
				{
					
						

						$this->child_settings_array['login_logo'] = array(
																				'id'      		=> 	'login_logo',
																				'title'   		=> 	'Login Logo',
																				'description'	=>	'',
																				'type'    		=>	'wp_image_upload',
																				'section' 		=>	'section_logo',
																				'choices' 		=> 	array(
																										'image-id'		=>	'',
																										'cpt'			=>	'',
																										'post-name'		=>	'',
																										'size'			=>	''
																									),
																				'class'   		=> 	''
																			);					


						$this->child_settings_array['login_rebox'] = array(
																				'id'      		=> 	'login_rebox',
																				'title'   		=> 	'Login  box',
																				'description'	=>	' This moves the nicely styles box around the login form to encompas the logo and the register/lost-password links. It also makes it more frienldy to mobiles, and makes it easier to read against background images.',
																				'type'    		=>	'select',
																				'section' 		=>	'section_logo',
																				'choices' 		=> 	array(
																										'0'				=>	' == Do not use == ',
																										'box-white'		=>	' White box',
																										'box-black'		=>	' Black box'			
																									),
																				'class'   		=> 	''
																			);


						

						$this->child_settings_array['login_background'] = array(
																				'id'      		=> 	'login_background',
																				'title'   		=> 	'Background image',
																				'description'	=>	'',
																				'type'    		=>	'wp_image_upload',
																				'section' 		=>	'section_background',
																				'choices' 		=> 	array(
																										'image-id'		=>	'',
																										'cpt'			=>	'',
																										'post-name'		=>	'',
																										'size'			=>	''
																									),
																				'class'   		=> 	''
																			);	
																		
					
				}
						
				

				/*
				**
				**		ADD_PLUGIN0_TO_MENU
				**
				*/				
				public 	function 	add_plugin_to_menu()
				{
						$this->framework_admin_menu_child(	$this->plugin_page_title, 
															$this->plugin_menu_title, 
															$this->plugin_slug, 
															array($this, 	'child_admin_page')
														);
				
				}
				
				
				
				

				/*
				**
				**		CHILD ADMIN PAGE
				**
				*/				
				public 	function 	child_admin_page()
				{
						$this->framework_admin_page_header('Login Control', 'icon_class');
					 
						$this->framework_admin_page_footer();				
				}
				
				
				public 	function 	kjg_pwb_passed_head()
				{
					
						$this->we_have_passed_the_head_part 		= 		true;
						
						//
						//	This is mental that its not go its own filter, but hey
						//
						//	I'll add a patch to trac
						//
						
						add_filter( 'option_blogname', 	array( $this, 'crazy_process_maze_of_filters_to_replace_one_bit_of_text'), 100, 2 );

						add_filter( 'login_headerurl', 	array( $this, 'cheeky_bastards_link'), 100, 2 );						

						add_filter( 'login_headertitle', 	array( $this, 'cheeky_bastards_title'), 100, 2 );						
						
						
						return 	$this->we_have_passed_the_head_part;
				}
				
				
				
				public 	function 	cheeky_bastards_link($something='something', $darkside='darkside')
				{
						return 	get_bloginfo('url');
					
				}


				public 	function 	cheeky_bastards_title($something='something', $darkside='darkside')
				{
						return 	get_bloginfo('name');					
				}
				
				
				
				public 	function 	make_body_style()
				{
						
						$this->body_style_output[]		=		' background-repeat:		no-repeat; ';
						$this->body_style_output[]		=		' background-position:		center top; ';
						$this->body_style_output[]		=		' background-size: 			cover; ';
						$this->body_style_output[]		=		' max-height:				100%; ';
						$this->body_style_output[]		=		' min-height:				100%; ';
						
						
						
						if( !empty( $this->plugin_options['login_background'] ) )
						{
								$this->body_style_output[]		=		' background-image:	url('. $this->plugin_options['login_background'] .');';							
							
						}

						if( !empty( $this->plugin_options['login_background_colour'] ) )
						{
								$this->body_style_output[]		=		' background-image:	url('. $this->plugin_options['login_background_colour'] .');';
						}						
					
				}
				
				
				
				public 	function 	convert_style_array_to_string($array)
				{
					
						foreach( $array as $value )
						{							
							$string	=	$string. $value . "\n";
						}
					
						return 	$string;
					
				}
				
				
				public 	function 	rebox_login_form($colour_scheme)
				{


						if( !empty( $this->plugin_options['login_rebox'] ) )
						{
						
								echo '
										body.login
										{
											padding-top:	150px;
										}

										.login #nav
										{
										    margin: 0 0 20px 0;
										    padding: 0px;
										    text-align: center;
										}																			


										
										.login #nav a
										{
											padding: 10px;
										}	
										
								
									';


								if( $this->plugin_options['login_rebox'] == "box-white" )
								{						
		
										echo '
										
													#login
													{
															padding-top:				20px;
															-moz-border-radius: 		11px;
															-khtml-border-radius: 		11px;
															-webkit-border-radius: 		11px;
															border-radius: 				10px;
															background: 				#fff;
															border: 					1px solid #E5E5E5;
															-moz-box-shadow: 			rgba(200,200,200,1) 0 4px 18px;
															-webkit-box-shadow: 		rgba(200, 200, 200, 1) 0 4px 18px;
															-khtml-box-shadow: 			rgba(200,200,200,1) 0 4px 18px;
															box-shadow: 				rgba(200, 200, 200, 1) 0 4px 18px;
													}
													
													#login form,
													.login form,													
													form
													{
															margin:						20px 0px 30px;
				
															border-width:				0px;
															border-bottom:				1px dashed #E5E5E5;
															border-top:					1px dashed #E5E5E5;
															
															-moz-border-radius: 		0px;
															-khtml-border-radius: 		0px;
															-webkit-border-radius: 		0px;
															border-radius: 				0px;											
				
															-moz-box-shadow: 			none;
															-webkit-box-shadow: 		none;
															-khtml-box-shadow: 			none;
															box-shadow: 				none;
															
													}
													
													#login_error, 
													.message 
													{
															margin:						20px 10px;
													}
										
											';	
									
									} else {
										

										echo '
										
													#login
													{
															padding-top:				20px;
															-moz-border-radius: 		11px;
															-khtml-border-radius: 		11px;
															-webkit-border-radius: 		11px;
															border-radius: 				10px;
															background: 				#111;
															border: 					1px solid #2b2b2b;
															-moz-box-shadow: 			rgba(50,50,50, 1) 0 4px 18px;
															-webkit-box-shadow: 		rgba(50,50,50, 1) 0 4px 18px;
															-khtml-box-shadow: 			rgba(50,50,50, 1) 0 4px 18px;
															box-shadow: 				rgba(50,50,50, 1) 0 4px 18px;
													}
													
													#login form,
													.login form,
													form
													{
															background:					none;
															margin:						20px 0px 30px;
															padding: 					25px 25px 45px;
				
															border-width:				0px;
															border-bottom:				1px dashed #333;
															border-top:					1px dashed #333;
															
															-moz-border-radius: 		0px;
															-khtml-border-radius: 		0px;
															-webkit-border-radius: 		0px;
															border-radius: 				0px;											
				
															-moz-box-shadow: 			none;
															-webkit-box-shadow: 		none;
															-khtml-box-shadow: 			none;
															box-shadow: 				none;
															
													}
													
													#login_error, 
													.message 
													{
															margin:						20px 10px;
													}
													


													#nav a,
													#nav,
													a
													{
															color:						#ccc !important;	
															text-shadow:				0 1px 0 #999;
															text-shadow:				none;
													}
										



											';	
										
										
										
									}	
							
							}	
			
					
				}
				
				public 	function 	logo_fix()
				{


						if( !empty( $this->plugin_options['login_logo'] ) )
						{
		
								echo '
								
											#login h1 a,
											.login h1 a,
											h1 a 
											{
													min-height:			70px;
													text-indent: 		0px;
													display:			block;
													height: 			auto;
													width:				100%;
													
													text-align: 		center;
													margin:				0px auto;
													background: 		none;
													padding-bottom:		20px;
											}


											.login h1 a img,
											h1 a img 
											{
													max-width:			80%;
													height:				auto;
													opacity:			0.9;
											}
								
									';		
							
							}
					
					
				}
				
				

				
				
				public 	function 	crazy_process_maze_of_filters_to_replace_one_bit_of_text($args)
				{
						$return_me 		= 		$args;
				
						if( $this->is_login )
						{
								if( $this->we_have_passed_the_head_part )
								{
										$this->second_time_is_the_charm++;
										
										if( $this->second_time_is_the_charm == 2 )
										{								
												if( $this->plugin_options['login_logo'] )
												{
		
														$image 			= 		'<img src="'. $this->plugin_options['login_logo'].'" alt="'. $args .'" />';									
				
														echo 					$image;
		
													//	$return_me 		= 		$image;	
													
														$this->groundhog_day 	= 	true;
														
														return false;
												}	
										}							
								}
							
						}
						
					
						return 	$return_me;
				}
				

				

				public 	function 	kjg_pwb_login_style()
				{
				
						$this->make_body_style();
				
						echo '
								<style>
									html,
									body,
									body.login
									{
											'. $this->convert_style_array_to_string( $this->body_style_output ) .'	
									}
									

									
							';
							
							
										$this->rebox_login_form($colour_scheme);
										
										$this->logo_fix();
										

						echo '
									.login #backtoblog,
									#backtoblog
									{
											display:				none;
									}
									
								</style>
						';
					
					
				}



				

		
		
		}	//	class
		
	
		$kevinjohn_gallagher___login_control			=	new kevinjohn_gallagher___login_control();
		
	
	} else {
	

			function kevinjohn_gallagher___login_control___parent_needed()
			{
					echo	"<div id='message' class='error'>";
					
					echo	"<p>";
					echo	"<strong>Kevinjohn Gallagher: Pure Web Brilliant's Login Control</strong> ";	
					echo	"requires the parent framework to be installed and activated";
					echo	"</p>";
			} 

			add_action('admin_footer', 'kevinjohn_gallagher___login_control___parent_needed');	
	
	}


