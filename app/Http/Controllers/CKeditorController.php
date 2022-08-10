<?php

namespace App\Http\Controllers;

use App\Traits\FileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CKeditorController extends Controller
{
    use FileTrait;

    public function store(Request $request)
    {
        $file = $this->saveFile($request->upload, "storage/images/CKeditor", "ckeditor");
        return response()->json([
            'url' =>  Storage::url('public/images/CKeditor/' . $file),
        ]);
    }
}
