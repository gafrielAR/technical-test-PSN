<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'name', 'gender', 'phone_number', 'image', 'email'];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
