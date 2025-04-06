<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\StoreController;
use App\Models\User;
use App\Models\Store;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $primaryKey = 'message_id';
    public $timestamps = false;
    protected $fillable = ['sender_id', 'receiver_id', 'message_content', 'sent_at'];


    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // In Message model
    public function store()
    {
        return $this->belongsTo(Store::class, 'owner_id', 'user_id');
    }
}
