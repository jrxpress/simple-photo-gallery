<?php

class WP_Photo_Gallery_Settings_Menu extends WP_Photo_Gallery_Admin_Menu
{
    var $menu_page_slug = WP_PHOTO_SETTINGS_MENU_SLUG;
    
    /* Specify all the tabs of this menu in the following array */
    var $menu_tabs = array(
        'tab1' => 'General Settings', 
        );

    var $menu_tabs_handler = array(
        'tab1' => 'render_tab1', 
        );

    function __construct() 
    {
        $this->render_menu_page();
    }

    function get_current_tab() 
    {
        $tab_keys = array_keys($this->menu_tabs);
        $tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $tab_keys[0];
        return $tab;
    }

    /*
     * Renders our tabs of this menu as nav items
     */
    function render_menu_tabs() 
    {
        $current_tab = $this->get_current_tab();

        echo '<h2 class="nav-tab-wrapper">';
        foreach ( $this->menu_tabs as $tab_key => $tab_caption ) 
        {
            $active = $current_tab == $tab_key ? 'nav-tab-active' : '';
            echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->menu_page_slug . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';	
        }
        echo '</h2>';
    }
    
    /*
     * The menu rendering goes here
     */
    function render_menu_page() 
    {
        $tab = $this->get_current_tab();
        ?>
        <div class="wrap">
        <div id="poststuff"><div id="post-body">
        <?php 
        $this->render_menu_tabs();
        //$tab_keys = array_keys($this->menu_tabs);
        call_user_func(array(&$this, $this->menu_tabs_handler[$tab]));
        ?>
        </div></div>
        </div><!-- end of wrap -->
        <?php
    }
    
    /*
     * The menu rendering goes here
     */
    function render_tab1() 
    {
        global $wp_photo_gallery;
        //Do form submission tasks
        if(isset($_POST['wppg_save_general_gallery_settings']))
        {
            $errors = '';
            $nonce=$_REQUEST['_wpnonce'];
            if (!wp_verify_nonce($nonce, 'wppg-save-general-gallery-settings-nonce'))
            {
                //TODO
                $wp_photo_gallery->debug_logger->log_debug("Nonce check failed on gallery general settings save!",4);
                die("Nonce check failed on gallery settings save!");
            }


            $gallery_selection_sort_order = $_POST['wppg_gallery_selection_sort_order'];
            $wp_photo_gallery->configs->set_value('wppg_gallery_home_sort_order', $gallery_selection_sort_order);
            $wp_photo_gallery->configs->save_config();

            echo '<div id="message" class="updated fade"><p><strong>';
            _e('Gallery general settings were successfully saved.','WPS');
            echo '</strong></p></div>';
        }
        $gallery_selection_sort_order = $wp_photo_gallery->configs->get_value('wppg_gallery_home_sort_order');
        ?>
        <div class="aio_grey_box">
 	<p>For information, updates and documentation, please visit the <a href="http://photography-solutions.tipsandtricks-hq.com/simple-wordpress-photo-gallery-plugin" target="_blank">Simple Photo Gallery Plugin</a> Page.</p>
        <p><a href="http://www.tipsandtricks-hq.com/development-center" target="_blank">Follow us</a> on Twitter, Google+ or via Email to stay up to date regarding new features and improvements to this plugin.</p>
        </div>
        
        <div class="postbox">
        <h3><label for="title"><?php _e('Getting Started', 'simple_photo_gallery'); ?></label></h3>
        <div class="inside">
            <div class="wppg_blue_box">
                <?php
                echo '<p>'.__('Using the <strong>Simple Photo Gallery</strong> Plugin is easy.', 'simple_photo_gallery').'</p>'; 
                $gallery_link = '<a href="admin.php?page='.WP_PHOTO_GALLERY_MENU_SLUG.'">gallery settings</a>';
                $info_msg = '<p>'.sprintf( __('Just go to the %s and upload your photos and create your gallery.', 'simple_photo_gallery'), $gallery_link).'</p>';
                echo $info_msg;
                echo '<p>'.__('After uploading your photos and saving your gallery the plugin will automatically create the required gallery pages on the front end of your site. It really is that simple!', 'simple_photo_gallery').'</p>'; 
                ?>
            </div>
        </div></div>
        
        <div class="postbox">
            <form action="" method="POST">
            <?php wp_nonce_field('wppg-save-general-gallery-settings-nonce'); ?>
            <h3><label for="title"><?php _e('General Gallery Settings', 'WPS'); ?></label></h3>
            <div class="inside">
                <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('Sort Order Of Gallery Selection', 'WPS');?>:</th>
                    <td>
                        <select id="wppg_gallery_selection_sort_order" name="wppg_gallery_selection_sort_order">
                            <option value="0" <?php selected( $gallery_selection_sort_order, '0' ); ?>><?php _e( 'By ID Ascending', 'WPS' ); ?></option>
                            <option value="1" <?php selected( $gallery_selection_sort_order, '1' ); ?>><?php _e( 'By ID Descending', 'WPS' ); ?></option>
                            <option value="2" <?php selected( $gallery_selection_sort_order, '2' ); ?>><?php _e( 'By Date Ascending', 'WPS' ); ?></option>
                            <option value="3" <?php selected( $gallery_selection_sort_order, '3' ); ?>><?php _e( 'By Date Descending', 'WPS' ); ?></option>
                            <option value="4" <?php selected( $gallery_selection_sort_order, '4' ); ?>><?php _e( 'By Name Ascending', 'WPS' ); ?></option>
                            <option value="5" <?php selected( $gallery_selection_sort_order, '5' ); ?>><?php _e( 'By Name Descending', 'WPS' ); ?></option>
                        </select>
                    <span class="description"><?php _e('Choose the sort order of your gallery selection images when they are displayed on the gallery page of the front end of your site', 'WPS'); ?></span>
                    </td>
                </tr>
                </table>
                <input type="submit" name="wppg_save_general_gallery_settings" value="Save Settings" class="button-primary" />
            </div>
            </form>
        </div>

        <?php
    }
    
} //end class