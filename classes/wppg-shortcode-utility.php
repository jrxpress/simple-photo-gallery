<?php

class WP_Photo_Gallery_Shortcode_Utility
{
    function __construct(){
        //NOP
    }
    
    //Handles output for the slider shortcode
    static function wppg_slider_output_sc($ids)
    {
        if (is_array($ids)){
            //get photos for each gallery id
            $image_data = array();
            foreach ($ids as $id){
                $image_data_temp = WPPGPhotoGallery::getGalleryItems($id);
                $image_data = array_merge($image_data, $image_data_temp);
            }
        }else{
            //get photos for single gallery
            $image_data = WPPGPhotoGallery::getGalleryItems($ids);
        }
        WP_Photo_Gallery_Utility::start_buffer();
        ?>
        <div class="wppg-slider-container flexslider">
            <ul class="wppg-slides slides">
        <?php
        foreach ($image_data as $image)
        {
            echo '<li><img src="'.$image['image_url'].'"/></li>';
        }
        ?>
            </ul>
        </div>
        <?php
        $output = WP_Photo_Gallery_Utility::end_buffer_and_collect();
        return $output;
        
    }
}