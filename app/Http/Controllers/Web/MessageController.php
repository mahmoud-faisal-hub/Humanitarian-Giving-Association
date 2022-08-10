<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(MessageRequest $request)
    {
        $message = Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ]);

        if ($message) {
            return response()->json([
                "status" => true,
                'msg' => "تم إرسالة الرسالة بنجاح"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'فشل فى إرسال الرسالة - برجاء المحاولة مجدداً',
            ]);
        }
    }
}
