<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ImageController extends Controller
{
    public function seed()
    {
        $response = Http::get('http://localhost:3001/getallphotos');

        if ($response->successful()) {
            $images = $response->json();

            foreach ($images as $image) {
                $imageData = [
                    'image_id' => $image['imageId'],
                    'user_id' => $image['userId'],
                    'taken_date' => $image['takenDate'],
                    'username' => $image['username'],
                    'real_name' => $image['realName'],
                    'title' => $image['title'],
                    'format' => $image['format'],
                    'image_secret' => $image['picSecret'],
                    'url' => $image['url'],
                    'page_type' => $image['pageType'],
                    'server_id' => $image['serverId'],
                ];

                $datetimeString = $image['takenDate'];
                $parts = explode('T', $datetimeString);
                $date = $parts[0];
                $imageData['taken_date'] = $date;

                Image::create($imageData);
            }
        }
        else {
            return response()->json(['error' => 'Could not seed images'], 500);
        }
    }
}
