<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'house_id'];

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
