<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function fileUpload(Request $request)
    {
        // file nama form input dan store adalah nama file di public storage
        $path = $request->file('avatar')->store('avatars');
        $data = [
            'message' => 'file uplaod',
            'path' => $path,
        ];

        return response()->json($data, 200);
    }
}
