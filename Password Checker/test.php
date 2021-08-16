<?php
	if ( ! defined('ABSPATH') ){ die(); }
	
	global $avia_config;
	
	$lightbox_option = avia_get_option( 'lightbox_active' );
	$avia_config['use_standard_lightbox'] = empty( $lightbox_option ) || ( 'lightbox_active' == $lightbox_option ) ? 'lightbox_active' : 'disabled';

	/**
	 * Allow to overwrite the option setting for using the standard lightbox
	 * Make sure to return 'disabled' to deactivate the standard lightbox - all checks are done against this string
	 * 
	 * @added_by GГјnter
	 * @since 4.2.6
	 * @param string $use_standard_lightbox				'lightbox_active' | 'disabled'
	 * @return string									'lightbox_active' | 'disabled'
	 */
	$avia_config['use_standard_lightbox'] = apply_filters( 'avf_use_standard_lightbox', $avia_config['use_standard_lightbox'] );

	$style 					= $avia_config['box_class'];
	$responsive				= avia_get_option( 'responsive_active' ) != 'disabled' ? 'responsive' : 'fixed_layout';
	$blank 					= isset( $avia_config['template'] ) ? $avia_config['template'] : '';	
	$av_lightbox			= $avia_config['use_standard_lightbox'] != 'disabled' ? 'av-default-lightbox' : 'av-custom-lightbox';
	$preloader				= avia_get_option( 'preloader' ) == 'preloader' ? 'av-preloader-active av-preloader-enabled' : 'av-preloader-disabled';
	$sidebar_styling 		= avia_get_option( 'sidebar_styling' );
	$filterable_classes 	= avia_header_class_filter( avia_header_class_string() );
	$av_classes_manually	= 'av-no-preview'; /*required for live previews*/
	
	/**
	 * If title attribute is missing for an image default lightbox displays the alt attribute
	 * 
	 * @since 4.7.6.2
	 * @param bool
	 * @return false|mixed			anything except false will activate this feature
	 */
	$mfp_alt_text = false !== apply_filters( 'avf_lightbox_show_alt_text', false ) ? 'avia-mfp-show-alt-text' : '';

	/**
	 * Allows to alter default settings Enfold-> Main Menu -> General -> Menu Items for Desktop
	 * @since 4.4.2
	 */
	$is_burger_menu = apply_filters( 'avf_burger_menu_active', avia_is_burger_menu(), 'header' );
	$av_classes_manually   .= $is_burger_menu ? ' html_burger_menu_active' : ' html_text_menu_active';

	/**
	 * Add additional custom body classes
	 * e.g. to disable default image hover effect add av-disable-avia-hover-effect
	 * 
	 * @since 4.4.2
	 */
	$custom_body_classes = apply_filters( 'avf_custom_body_classes', '' );

	/**
	 * @since 4.2.3 we support columns in rtl order (before they were ltr only). To be backward comp. with old sites use this filter.
	 */
	$rtl_support = 'yes' == apply_filters( 'avf_rtl_column_support', 'yes' ) ? ' rtl_columns ' : '';
	
	
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo "html_{$style} {$responsive} {$preloader} {$av_lightbox} {$filterable_classes} {$av_classes_manually}" ?> ">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php

/*
 * outputs a rel=follow or nofollow tag to circumvent google duplicate content for archives
 * located in framework/php/function-set-avia-frontend.php
 */
 if( function_exists( 'avia_set_follow' ) ) 
 { 
	 echo avia_set_follow();
 }

?>


<!-- mobile setting -->
<?php

$meta_viewport = ( strpos( $responsive, 'responsive' ) !== false ) ?  '<meta name="viewport" content="width=device-width, initial-scale=1">' : '';

/**
 * @since 4.7.6.4
 * @param string
 * @return string
 */
echo apply_filters( 'avf_header_meta_viewport', $meta_viewport );

?>


<!-- Scripts/CSS and wp_head hook -->
<?php
/* Always have wp_head() just before the closing </head>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to add elements to <head> such
 * as styles, scripts, and meta tags.
 */

wp_head();

?>

</head>




<body id="top" <?php body_class( $custom_body_classes . ' ' . $mfp_alt_text .' ' . $rtl_support . $style . ' ' . $avia_config['font_stack'] . ' ' . $blank . ' ' . $sidebar_styling); avia_markup_helper( array( 'context' => 'body' ) ); ?>>

	<?php 
	
	/**
	 * WP 5.2 add a new function - stay backwards compatible with older WP versions and support plugins that use this hook
	 * https://make.wordpress.org/themes/2019/03/29/addition-of-new-wp_body_open-hook/
	 * 
	 * @since 4.5.6
	 */
	if( function_exists( 'wp_body_open' ) )
	{
		wp_body_open();
	}
	else
	{
		do_action( 'wp_body_open' );
	}
	
	do_action( 'ava_after_body_opening_tag' );
		
	if( 'av-preloader-active av-preloader-enabled' === $preloader )
	{
		echo avia_preload_screen(); 
	}
		
	?>

	<div id='wrap_all'>

	<?php 
	if( ! $blank ) //blank templates dont display header nor footer
	{ 
		//fetch the template file that holds the main menu, located in includes/helper-menu-main.php
		get_template_part( 'includes/helper', 'main-menu' );

	} ?>
		
	<div id='main' class='all_colors' data-scroll-offset='<?php echo avia_header_setting( 'header_scroll_offset' ); ?>'>

	<?php 
		
		if( isset( $avia_config['temp_logo_container'] ) ) 
		{
			echo $avia_config['temp_logo_container'];
		}
		
		do_action( 'ava_after_main_container' ); 
		





























        <?php 
if ( ! defined( 'ABSPATH' ) ) {  exit;  }    // Exit if accessed directly


global $avia_config;

$responsive		= avia_get_option('responsive_active') != "disabled" ? "responsive" : "fixed_layout";
$headerS 		= avia_header_setting();
$social_args 	= array('outside'=>'ul', 'inside'=>'li', 'append' => '');
$icons 			= !empty($headerS['header_social']) ? avia_social_media_icons($social_args, false) : "";
$alternate_menu_id = ! empty( $headerS['alternate_menu'] ) && is_numeric( $headerS['alternate_menu'] ) && empty( $headerS['menu_display'] ) ? $headerS['alternate_menu'] : false;

/**
 * For sidebar menus this filter allows to activate alternate menus - are disabled by default
 * 
 * @since 4.5
 * @param int|false $alternate_menu_id 
 * @param array $headerS
 * @return int|false
 */
$alternate_menu_id = apply_filters( 'avf_alternate_mobile_menu_id', $alternate_menu_id, $headerS );

if( isset( $headerS['disabled'] ) ) 
{    
	return;   
}

?>

<header id='header' class='all_colors header_color <?php avia_is_dark_bg('header_color'); echo " ".$headerS['header_class']; ?>' <?php avia_markup_helper(array('context' => 'header','post_type'=>'forum'));?>>

<?php

//subheader, only display when the user chooses a social header
if($headerS['header_topbar'] == true)
{
?>
		<div id='header_meta' class='container_wrap container_wrap_meta <?php echo avia_header_class_string(array('header_social', 'header_secondary_menu', 'header_phone_active'), 'av_'); ?>'>
		
			      <div class='container'>
			      <?php
			            /*
			            *	display the themes social media icons, defined in the wordpress backend
			            *   the avia_social_media_icons function is located in includes/helper-social-media-php
			            */
						$nav = "";
						
						//display icons
			            if(strpos( $headerS['header_social'], 'extra_header_active') !== false) echo $icons;
					
						//display navigation
						if(strpos( $headerS['header_secondary_menu'], 'extra_header_active') !== false )
						{
			            	//display the small submenu
			                $avia_theme_location = 'avia2';
			                $avia_menu_class = $avia_theme_location . '-menu';
			                $args = array(
			                    'theme_location'=>$avia_theme_location,
			                    'menu_id' =>$avia_menu_class,
			                    'container_class' =>$avia_menu_class,
			                    'fallback_cb' => '',
			                    'container'=>'',
			                    'echo' =>false
			                );
			                
			                $nav = wp_nav_menu($args);
						}
			                
						if(!empty($nav) || apply_filters('avf_execute_avia_meta_header', false))
						{
							echo "<nav class='sub_menu' ".avia_markup_helper(array('context' => 'nav', 'echo' => false)).">";
							echo $nav;
		                    do_action('avia_meta_header'); // Hook that can be used for plugins and theme extensions (currently: the wpml language selector)
							echo '</nav>';
						}
						
						
						//phone/info text	
						$phone			= $headerS['header_phone_active'] != "" ? $headerS['phone'] : "";
						$phone_class 	= !empty($nav) ? "with_nav" : "";
						if($phone) 		{ echo "<div class='phone-info {$phone_class}'><span>".do_shortcode($phone)."</span></div>"; }
							
							
			        ?>
			      </div>
		</div>

<?php } 
	
	
	
	$output 	 = "";
	$temp_output = "";
	$icon_beside = "";
	
	if($headerS['header_social'] == 'icon_active_main' && empty($headerS['bottom_menu']))
	{
		$icon_beside = " av_menu_icon_beside"; 
	}
	
	
	
	
	
	
?>
		<div  id='header_main' class='container_wrap container_wrap_logo'>
	
        <?php
        /*
        * Hook that can be used for plugins and theme extensions (currently:  the woocommerce shopping cart)
        */
        do_action( 'ava_main_header' );
        
        if( $headerS['header_position'] != "header_top" ) 
		{
			do_action('ava_main_header_sidebar');
		}
	
				 $output .= "<div class='container av-logo-container'>";
				 
					$output .= "<div class='inner-container'>";
						
						/*
						*	display the theme logo by checking if the default logo was overwritten in the backend.
						*   the function is located at framework/php/function-set-avia-frontend-functions.php in case you need to edit the output
						*/
						$addition = false;
						if( ! empty( $headerS['header_transparency'] ) && ! empty( $headerS['header_replacement_logo'] ) )
						{
							$resp = array(
										0			=> $headerS['header_replacement_logo'],
										'srcset'	=> $headerS['header_replacement_logo_srcset'],
										'sizes'		=> $headerS['header_replacement_logo_sizes']
									);
							
							$resp = Av_Responsive_Images()->html_attr_image_src( $resp, true );
							
							$addition = "<img {$resp} class='alternate' alt='{$headerS['header_replacement_logo_alt']}' title='{$headerS['header_replacement_logo_title']}' />";
						}
						
						$output .= avia_logo( AVIA_BASE_URL . 'images/layout/logo.png', $addition, 'span', true );
						
						if( ! empty( $headerS['bottom_menu'] ) )
						{
							ob_start();
							do_action( 'ava_before_bottom_main_menu' ); // todo: replace action with filter, might break user customizations
							$output .= ob_get_clean();
						}

						if( $headerS['header_social'] == 'icon_active_main' && ! empty( $headerS['bottom_menu'] ) )
						{
							$output .= $icons;
						}
						    
						
						/*
						*	display the main navigation menu
						*   modify the output in your wordpress admin backend at appearance->menus
						*/  
						    if( $headerS['bottom_menu'] )
						    { 
							    $output .= "</div>";  
								$output .= "</div>";
								
								if( ! empty( $headerS['header_menu_above'] ) )
								{
									$avia_config['temp_logo_container'] = "<div class='av-section-bottom-logo header_color'>".$output."</div>";
									$output = "";
								}
								
								$output .= "<div id='header_main_alternate' class='container_wrap'>";
								$output .= "<div class='container'>";
							}
						
							$avia_theme_location = 'avia';
							$avia_menu_class = $avia_theme_location . '-menu';
		
						    $main_nav = "<nav class='main_menu' data-selectname='".__('Select a page','avia_framework')."' ".avia_markup_helper(array('context' => 'nav', 'echo' => false)).">";
						        
							$args = array(
						            'theme_location'	=> $avia_theme_location,
						            'menu_id' 			=> $avia_menu_class,
						            'menu_class'		=> 'menu av-main-nav',
						            'container_class'	=> $avia_menu_class.' av-main-nav-wrap'.$icon_beside,
						            'fallback_cb' 		=> 'avia_fallback_menu',
						            'echo' 				=>	false, 
						            'walker' 			=> new avia_responsive_mega_menu()
						        );
						
						        $wp_main_nav = wp_nav_menu($args);
						        $main_nav .= $wp_main_nav;
						        
						      
						    /*
						    * Hook that can be used for plugins and theme extensions
						    */
						    ob_start();
						    do_action('ava_inside_main_menu'); // todo: replace action with filter, might break user customizations
						    $main_nav .= ob_get_clean();
						    
						    if($icon_beside)
						    {
							    $main_nav .= $icons; 
						    }
						        
						    $main_nav .= '</nav>';
							
							/**
							 * Allow to modify or remove main menu for special pages
							 * 
							 * @since 4.1.3
							 */
							$output .= apply_filters( 'avf_main_menu_nav', $main_nav );
						
						    /*
						    * Hook that can be used for plugins and theme extensions
						    */
						    ob_start();
						    do_action('ava_after_main_menu'); // todo: replace action with filter, might break user customizations
							$output .= ob_get_clean();
				
					 /* inner-container */
			        $output .= "</div>";
						
		        /* end container */
		        $output .= " </div> ";
		   		
		   		
		   		//output the whole menu     
		        echo $output; 
		        
		        
		   ?>

		<!-- end container_wrap-->
		</div>
<?php
		/**
		 * Add a hidden container for alternate mobile menu
		 * 
		 * We use the same structure as main menu to be able to use same logic in js to build burger menu
		 * 
		 * @added_by GГјnter
		 * @since 4.5
		 */
		$out_alternate = '';
		$avia_alternate_location = 'avia_alternate';
		$avia_alternate_menu_class = $avia_alternate_location . '_menu';
		
		if( false !== $alternate_menu_id && is_nav_menu( $alternate_menu_id ) )
		{
			$out_alternate .= '<div id="avia_alternate_menu_container" style="display: none;">';
			
			$alternate_nav =	"<nav class='main_menu' data-selectname='" . __( 'Select a page', 'avia_framework' ) . "' " . avia_markup_helper( array( 'context' => 'nav', 'echo' => false ) ) . ">";
			
			$args = array(
							'menu'				=> $alternate_menu_id,
							'menu_id' 			=> $avia_alternate_menu_class,
							'menu_class'		=> 'menu av-main-nav',
							'container_class'	=> $avia_alternate_menu_class.' av-main-nav-wrap',
							'fallback_cb' 		=> 'avia_fallback_menu',
							'echo' 				=> false, 
							'walker' 			=> new avia_responsive_mega_menu()
						);

			$wp_nav_alternate = wp_nav_menu( $args );
			
			/**
			 * Hook that can be used for plugins and theme extensions
			 * 
			 * @since 4.5
			 * @return string
			 */
			$alternate_nav .=		apply_filters( 'avf_inside_alternate_main_menu_nav', $wp_nav_alternate, $avia_alternate_location, $avia_alternate_menu_class );
			
			$alternate_nav .=	'</nav>';

			/**
			 * Allow to modify or remove alternate menu for special pages.
			 * 
			 * @since 4.5
			 * @return string
			 */
			$out_alternate .= apply_filters( 'avf_alternate_main_menu_nav', $alternate_nav );

			$out_alternate .= '</div>';
		}
		
		/**
		 * Hook to remove or modify alternate mobile menu
		 * 
		 * @since 4.5
		 * @return string
		 */
		$out_alternate = apply_filters( 'avf_alternate_mobile_menu', $out_alternate );
		
		if( ! empty ( $out_alternate ) )
		{
			echo $out_alternate; 
		}
?>
		<div class='header_bg'></div>

<!-- end header -->
</header>
