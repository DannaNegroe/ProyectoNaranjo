<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitorRecord extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'entry', 'exit', 'plate', 'motive', 'house_id'];

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
