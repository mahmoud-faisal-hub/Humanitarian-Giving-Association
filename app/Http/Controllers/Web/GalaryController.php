<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Galary;
use Illuminate\Http\Request;

class GalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = null)
    {
        $image = ['png', 'jpeg', 'jpg', 'gif'];
        $video = ['mp4', 'ogv', 'webm', 'avi'];

        if ($type == 'images') {
            $galary = Galary::select(['file', 'extension', 'description'])->whereIn('extension', $image)->orderBy('created_at', 'desc')->paginate(40);
        } else if ($type == "videos") {
            $galary = Galary::select(['file', 'extension', 'description'])->whereIn('extension', $video)->orderBy('created_at', 'desc')->paginate(40);
        } else {
            $galary = Galary::select(['file', 'extension', 'description'])->orderBy('created_at', 'desc')->paginate(40);
        }

        // return ($galary);
        return view("web.galary.index", compact('galary'));
    }
}
