<?php

namespace App\Traits;


Trait FileTrait{
    function saveFile($photo, $folder, $file_prefix = "file")
    {
        $file_extension = $photo -> getClientOriginalExtension();
        $file_name = $file_prefix . '-' . uniqid() . '-' . now()->timestamp . $file_extension;
        $path  = $folder;
        $photo -> move($path, $file_name);
        return $file_name;
    }
}
