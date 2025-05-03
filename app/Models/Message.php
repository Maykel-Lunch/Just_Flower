<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'message_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;


    // Specify custom timestamp fields
    const CREATED_AT = 'sent_at';
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message_content',
        'sent_at',
    ];

    /**
     * Relationship with the sender (User model).
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Relationship with the receiver (User model).
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}