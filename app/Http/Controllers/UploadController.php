<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;

class UploadController extends Controller
{
    //
    public function uploadFile(Request $request) {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();

        Cloudder::upload($file, $fileName);

        return response()->json([
            'public_id' => Cloudder::getPublicId(),
            'url' => Cloudder::secureShow($fileName),
        ]);
    }
}
