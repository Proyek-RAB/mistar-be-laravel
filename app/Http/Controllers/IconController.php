<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class IconController extends Controller
{
    public function getIcon($folder, $filename)
    {
        $iconsDirectory = public_path('icons/'.$folder);
        $path = $iconsDirectory . '/' . $filename;

        if (File::exists($path)) {
            $mime = File::mimeType($path);
            $response = Response::make(File::get($path), 200);
            $response->header('Content-Type', $mime);
            return $response;
        }

        return response('File not found.', 404);
    }
}
