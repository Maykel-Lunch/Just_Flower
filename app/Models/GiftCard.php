<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GiftCard extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'gift_cards';
    protected $fillable = [
        'member_id',
        'user_id',
        'membership_lvl',
        'member_since',
        'birthday_discount',
        'membership_requirements',
        'member_code',
    ];
    
    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}
}
