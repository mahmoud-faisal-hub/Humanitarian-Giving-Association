<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;


class FilepondController extends Controller
{
    public function load($load, Request $request)
    {

        /*return response()->file(Storage::disk('public')->path($request->header('file-path') . $load), [
            'Content-Disposition' =>  "inline; filename={$load}"
        ]);*/

        if (Storage::disk('public')->exists($request->header('file-path') . $load)) {
            $file = Storage::disk('public')->path($request->header('file-path') . $load);
            $response = Response::file($file, ['Content-Disposition' =>  "inline; filename={$load}"]);

            return $response;
        }

        return abort(404);
    }
}
