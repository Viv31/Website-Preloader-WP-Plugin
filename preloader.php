<?php
/*
* Plugin Name: Website Preloader
* Author:Vaibhav Gangrade
* Version:1.0
* Description:Preloader is used when pages are loding whie processing it displays a loader.
* Author URI:
* Author URL:
* Tested upto:6.1
*/

if(!defined('ABSPATH')) exit;
if(!function_exists('WebsitePreloader_PreloaderSection')){
	function WebsitePreloader_PreloaderSection(){
		$jquery_path = plugin_dir_url( __FILE__ ).'assets/jquery.js';
		$preloader_script_path = plugin_dir_url( __FILE__ ).'assets/script.js';
		include_once('admin-menu.php');//calling setting menu
		/*
        * Getting inserted values from options table and passing into our css
        */
        $preloader_img = get_option('preloader_img');
        $preloader_color = get_option('preloader_color');
        //Getting color and converting with rgba
        $split = str_split($preloader_color, 2);
		$r = hexdec($split[0]);
		$g = hexdec($split[1]);
		$b = hexdec($split[2]);
		$preloader_color = "rgb(" . $r . ", " . $g . ", " . $b . ")";
		//echo $preloader_color;die();

        $background_transparency = get_option('background_transparency');
       	$preloader_color_with_overlay = "rgba(" . $r . ", " . $g . ", " . $b . ",".$background_transparency.")";
       	//echo $preloader_color_with_overlay;die();

         if(empty($preloader_img) || empty($preloader_color) || empty($background_transparency) ){
         	
	         $preloader_img = sanitize_text_field('https://miro.medium.com/v2/resize:fit:640/0*U2RiSXJx8U9K4thZ.gif');//Default image url
	         $preloader_color = sanitize_hex_color('0,0,0,0.5');
	         $background_transparency = sanitize_text_field('0.5');

         	 add_option('preloader_img', $preloader_img, '', 'yes');
           	 add_option('preloader_color', $preloader_color, '', 'yes');
           	 add_option('background_transparency', $background_transparency, '', 'yes');
         }

?>
<!--Preoader scripts -->
<script src="<?php echo $jquery_path; ?>"></script>
<script src="<?php echo $preloader_script_path; ?>"></script>
<!-- Preloader CSS -->
<style>
	.preloader {
   position: absolute;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   z-index: 9999;
   background-image: url('<?php echo $preloader_img; ?>');
   background-repeat: no-repeat; 
   background-color: <?php echo $preloader_color_with_overlay; ?>;
   background-position: center;
}
</style>
<!-- Preloader div -->
<div class="preloader"></div>
<?php 
	#######################################  FUNCTIONS FOR SETTINGS OF PRELOADER  ###################################################

//Register a callback for our specific plugin's actions
add_filter('plugin_action_links_' . plugin_basename(__FILE__) , 'Preloader_section_MY_PLUGIN_SLUG');
function Preloader_section_MY_PLUGIN_SLUG($links)
    {
        $links[] = '<a href="' . menu_page_url(Preloader_section_MY_PLUGIN_SLUG, false) . '">Preloader Settings</a>';
        return $links;
    }
	####################################### END OF FUNCTIONS FOR SETTINGS OF PRELOADER  ##################################################
	}
}
add_action('init','WebsitePreloader_PreloaderSection');





