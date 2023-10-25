<?php
/*
 * Plugin Name: GDrive WP
 * Description: An image display for Google Drive images
 */


require_once __DIR__."/DriveClient.php";
require_once __DIR__ . "/ImageRestService.php";

class GDriveWP
{
    private DriveClient $driveClient;
    private ImageRestService $imageRestService;

    function __construct(){
        $this->driveClient = new DriveClient();
        $this->imageRestService = new ImageRestService($this->driveClient);
        add_action('init', array($this, 'register_shortcode'));
        add_action('rest_api_init', array($this->imageRestService, 'register'));
        add_action('wp_enqueue_scripts', function (){
            wp_enqueue_style('img-load-anim', plugin_dir_url(__FILE__) . 'gdrive-imgs.css');
            wp_enqueue_script('drive-images', plugin_dir_url(__FILE__).'drive-image-loader.js', array('jquery'));
        });
    }

    function register_shortcode(): void
    {
        add_shortcode('drive-img', array($this, 'shortcode'));
    }


    function shortcode($attrs, $content, $tag){
        $file_id = explode('/view', explode('/file/d/', $content)[1])[0]; // GET File ID
        $download_link = get_site_url()."/wp-json/gdrive/v1/image?file=$file_id"; // Craft download link
        // Display the final image
        $img_attrs = "";
        if(is_array($attrs)) {
            if (isset($attrs["width"])) $img_attrs .= 'data-width="' . $attrs["width"] . '" ';
            if (isset($attrs["height"])) $img_attrs .= 'data-height="' . $attrs["height"] . '"';
        }
        return '<figure class="drive-img" data-src="'.$download_link.'" '.$img_attrs.'></figure>';
    }
}

new GDriveWP();