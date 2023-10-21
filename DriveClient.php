<?php
require __DIR__ . '/vendor/autoload.php';

use Google\Client;
use Google\Service\Drive;

class DriveClient
{
    private Client $client;
    private Drive $drive;

    public function __construct(){
        $this->init();
    }

    private function init(){
        $client = new Client();
        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));
        $client->setHttpClient($guzzleClient);
        $client->setApplicationName('Google Drive API PHP Quickstart');
        $client->setScopes('https://www.googleapis.com/auth/drive.readonly');
//        $client->addScope(Drive::DRIVE_FILE);
        $client->setAuthConfig(__DIR__.'/google-credentials.json');
        $client->useApplicationDefaultCredentials();
        $this->client = $client;
        $this->drive = new Drive($client);
    }

    public function download_file($file_id){
        $response = $this->drive->files->get($file_id, array(
            'alt' => 'media'));
        return $response->getBody()->getContents();
    }
}