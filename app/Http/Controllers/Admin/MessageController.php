<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\MessageReader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('عرض الرسائل')) {
            $messages = Message::withCount(['readers' => function ($query) {
                $query->where('admin_id', Auth()->id());
            }])->orderBy('created_at', 'desc')->paginate(15);

            $usereadCount = Message::count() - MessageReader::where('admin_id', Auth::id())->count();

            // return $messages;
            return view('admin.messages.index', compact('messages', 'usereadCount'));
        } else {
            abort(401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->can('عرض الرسائل')) {
            $message = Message::select(['id', 'name', 'email', 'phone', 'message', 'created_at'])
                            ->withCount(['readers' => function ($query) {
                                $query->where('admin_id', Auth()->id());
                            }])->find($id);

            if (!$message) {
                abort(404);
            }

            if (!$message->readers_count) {
                MessageReader::create([
                    'message_id' => $message->id,
                    'admin_id' => Auth::id(),
                ]);
            }

            // return $message;
            return view('admin.messages.show', compact('message'));
        } else {
            abort(401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('حذف رسالة')) {
            $message = Message::find($id);

            if (!$message) {
                return abort(404);
            }

            $message -> delete();

            if ($message) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم حذف الرسالة بنجاح',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل الحذف - برجاء المحاولة مجدداً',
                ]);
            }
        } else {
            abort(401);
        }
    }

    /**
     * Display the search resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        if (Auth::user()->can('عرض الرسائل')) {
            switch (request()->get("selectBy")) {
                case '1':
                    $table = 'name';
                    break;
                case '2':
                    $table = 'email';
                    break;
                case '3':
                    $table = 'phone';
                    break;
                default:
                    $table = 'email';
                    break;
            }

            $messages = Message::withCount(['readers' => function ($query) {
                $query->where('admin_id', Auth()->id());
            }])->orderBy('created_at', 'desc')->where($table, 'LIKE', '%' . request()->get("search") . '%')->paginate(15);

            if (!$messages) {
                return abort(404);
            }

            // return $category;
            return view('admin.messages.index', compact('messages'));
        } else {
            abort(401);
        }
    }
}
