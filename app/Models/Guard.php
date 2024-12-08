<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guard extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'email', 'shift', 'cluster_id'];

    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }
}
