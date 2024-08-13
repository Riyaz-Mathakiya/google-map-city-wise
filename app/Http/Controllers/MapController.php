<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MapController extends Controller
{
    public function index()
    {
        $cities = ['Ahmedabad', 'Gandhinagar', 'Mumbai']; // Example city names
        $initialMarkers = [];

        foreach ($cities as $index => $city) {
            $geocodeUrl = "https://maps.googleapis.com/maps/api/geocode/json";
            $response = Http::get($geocodeUrl, [
                'address' => $city,
                'key' => 'AIzaSyA3k-BUtdbWY_lDCK_S4yE1M0hyJqeQu0I',
            ]);

            $responseJson = $response->json();

            if ($responseJson['status'] == 'OK') {
                $location = $responseJson['results'][0]['geometry']['location'];

                $initialMarkers[] = [
                    'position' => [
                        'lat' => $location['lat'],
                        'lng' => $location['lng'],
                    ],
                    'label' => [
                        'color' => 'white',
                        'text' => 'P' . ($index + 1) . ' ' . $city,
                    ],
                    'draggable' => true,
                ];
            }
        }

        return view('welcome', compact('initialMarkers'));
    }
}
