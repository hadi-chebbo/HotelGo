<?php

namespace App\Services;

use Illuminate\Support\Facades\Http ;

class GoogleMapsService
{
        protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('GOOGLE_MAPS_API_KEY');
        $this->baseUrl = 'https://maps.googleapis.com/maps/api/geocode/json';
    }


    public function getCoordinatesFromAddress($address)
    {
        $response = Http::get($this->baseUrl, [
            'address' => $address,
            'key' => $this->apiKey
        ]);

        $data = $response->json();

        if ($data['status'] !== 'OK') {
            return null;
        }

        return [
            'lat' => $data['results'][0]['geometry']['location']['lat'],
            'lng' => $data['results'][0]['geometry']['location']['lng'],
        ];
    }

}
