<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Google_Client;
use Google_Service_Drive;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use Illuminate\Filesystem\Filesystem;

class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // $client = new Google_Client;
        // dd($client);
        Storage::extend("google", function($app, $config) {
            $client = new Google_Client();
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->refreshToken($config['refreshToken']);
            
            $service = new Google_Service_Drive($client);
            $adapter = new GoogleDriveAdapter($service, $config['folderId']);
            return new Filesystem($adapter);

            // dd($service);

        });
    }
}
