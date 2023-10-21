<?php
/*
 * Plugin Name: GDrive WP
 * Description: An image display for Google Drive images
 */


class GDriveWP
{
    function __construct(){
        add_action('init', array($this, 'register_shortcode'));
    }

    function register_shortcode(): void
    {
        add_shortcode('drive-img', array($this, 'shortcode'));
    }

    function shortcode($attrs, $content, $tag){
        $file_id = explode('/view', explode('/file/d/', $content)[1])[0]; // GET File ID
        $download_link =  "https://drive.google.com/uc?export=download&id=$file_id"; // Craft download link
        // Display the final image
        if(!is_array($attrs)) return "Something went wrong in params!";
        $img_attrs = "";
        if(isset($attrs["width"])) $img_attrs .= 'width="'.$attrs["width"].'" ';
        if(isset($attrs["height"])) $img_attrs .= 'height="'.$attrs["height"].'"';
        return '<img '.$img_attrs.' src="'.$download_link.'"></img>';
    }
}

new GDriveWP();