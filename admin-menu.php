<?php
define('Preloader_section_MY_PLUGIN_SLUG', 'Preloader-plugin-slug');
//Create a normal admin menu
    add_action('admin_menu', 'PL_section_plugin_settings_options');
    function PL_section_plugin_settings_options()
    {
        add_options_page('Preloader Settings', 'Preloader Settings', 'manage_options', Preloader_section_MY_PLUGIN_SLUG, 'PL_section_plugin_settings_page');

    }

//Creating plugin setting page form
    function PL_section_plugin_settings_page(){
        //Getting options values from options table and passing into our form for update 
         $preloader_img = get_option('preloader_img');
        $preloader_color = get_option('preloader_color');
        $background_transparency = get_option('background_transparency');
    ?>
    	<h2>Preloader Settings</h2>
    	<form action="" method="POST">
    		<label>Preloader Image:</label>
            <input type="text" class="" name="preloader_img" id="preloder_img" value="<?php echo $preloader_img; ?>"><br><br>
            <label>Preloader Overlay Color:</label>
            <input type="color" name="preloader_color" id="preloader_color" value="<?php echo $preloader_color; ?>"><br><br>
            <label>Background Transparency:</label>
            <input type="range" name="background_transparency" id="background_transparency" min="0" max="1" step="0.1"><br><br>
    		<?php 
    		if(!empty($preloader_color) || !empty($preloader_img)){ ?>
    			<input type="hidden" name="_nonce" value="<?php echo wp_create_nonce('update-settings') ?>">
				<input type="submit" name="update_preloader_setting" value="Update Setting">

    		<?php }else{ ?>
    			<br><input type="submit" name="save_preloader_settings" id="save_settings" value="Save Settings" class="btn btn-primary">
        <?php } ?>	
		</form>
    <?php }

if(isset($_POST['save_preloader_settings'])){
    $preloader_color = sanitize_hex_color($_POST['preloader_color']);
	$preloader_img = sanitize_text_field($_POST['preloader_img']);
    $background_transparency = sanitize_text_field($_POST['background_transparency']);
	if(isset($preloader_color) || isset($preloader_img) || isset($background_transparency)){
			add_option('preloader_color', $preloader_color);
        	add_option('preloader_img', $preloader_img);
            add_option('background_transparency', $background_transparency);
        	echo "Setting inserted successfully";
    }else{
		$preloader_color = sanitize_hex_color('#3a5b7f');
		$preloader_img = sanitize_text_field('https://miro.medium.com/v2/resize:fit:640/0*U2RiSXJx8U9K4thZ.gif');
        $background_transparency = sanitize_text_field('0.5');
		}

}
        //Updating plugin setting data
        if (isset($_POST['update_preloader_setting']))
        {
            if (wp_verify_nonce($_POST['_nonce'], 'update-settings'))
            {
               $preloader_color = sanitize_hex_color($_POST['preloader_color']);
                $preloader_img = sanitize_text_field($_POST['preloader_img']);
                $background_transparency = sanitize_text_field($_POST['background_transparency']);
                
                if (!empty($preloader_color) || !empty($preloader_img) || !empty($background_transparency))
                {
                    update_option('preloader_img', $preloader_img, '', 'yes');
                    update_option('preloader_color', $preloader_color, '', 'yes');
                    update_option('background_transparency', $background_transparency, '', 'yes');
                    echo "Updated Successfully!!";
                }
            }
        }