<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageReader extends Model
{
    use HasFactory;

    protected $table = "messages_readers";

    protected $fillable = [
        'message_id',
        'admin_id',
    ];

    protected $hidden = [];

    ########## Begin Relations ##########

    public function message()
    {
        return $this -> belongsTo(Message::class, 'message_id');
    }

    public function reader()
    {
        return $this -> belongsTo(Admin::class, 'admin_id');
    }

    ########## End Relations ##########
}
