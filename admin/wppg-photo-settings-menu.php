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
        <?php
    }
    
} //end class