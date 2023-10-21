<?php

class ImageRestService
{
    private DriveClient $drive;

    public function __construct(DriveClient $drive){
        $this->drive = $drive;
    }

    public function register(){
        register_rest_route('gdrive/v1', '/image', array(
            "methods" => 'GET',
            'callback' => array($this, 'on_get')
        ));
    }

    public function on_get(WP_REST_Request $request){
        $url_params = $request->get_params();
        if(!isset($url_params["file"])) return new WP_Error('missing_file', 'You must pass the file id!', array('status' => 400));
        try{
            $file = $this->drive->download_file($url_params["file"]);
            $resp = new WP_REST_Response($file);
            $resp->set_headers([
                'Content-Type' => 'image/jpg',
                'Content-Length' => strlen($file)
            ]);
            add_filter('rest_pre_serve_request', array($this, 'serve_image'), 0, 2);
            return $resp;
        } catch (Exception $e){
            return new WP_Error('gdrive-error', $e->getMessage(), array('status' => 502));
        }
    }

    /**
     * Action handler that is used by `serve_image()` to serve a binary image
     * instead of a JSON string.
     *
     * @return bool Returns true, if the image was served; this will skip the
     *              default REST response logic.
     */
    public function serve_image($served, $result): bool
    {
        $is_image   = false;
        $image_data = null;

        // Check the "Content-Type" header to confirm that we really want to return
        // binary image data.
        foreach ( $result->get_headers() as $header => $value ) {
            if ( 'content-type' === strtolower( $header ) ) {
                $is_image   = 0 === strpos( $value, 'image/' );
                $image_data = $result->get_data();
                break;
            }
        }

        // Output the binary data and tell the REST server to not send any other
        // details (via "return true").
        if ( $is_image && is_string( $image_data ) ) {
            echo $image_data;

            return true;
        }

        return $served;
    }
}