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
    }

    function register_shortcode(): void
    {
        add_shortcode('drive-img', array($this, 'shortcode'));
    }


    function shortcode($attrs, $content, $tag){
        $file_id = explode('/view', explode('/file/d/', $content)[1])[0]; // GET File ID
        $download_link =  get_site_url()."/wp-json/gdrive/v1/image?file=$file_id"; // Craft download link
        // Display the final image
        if(!is_array($attrs)) return "Something went wrong in params!";
        $img_attrs = "";
        if(isset($attrs["width"])) $img_attrs .= 'width="'.$attrs["width"].'" ';
        if(isset($attrs["height"])) $img_attrs .= 'height="'.$attrs["height"].'"';
        return '<img '.$img_attrs.' src="'.$download_link.'"></img>';
    }
}

new GDriveWP();