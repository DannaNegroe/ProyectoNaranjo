<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class House extends Model
{

    protected $fillable = [
        'label', 'owner', 'rooms', 'bathrooms',
        'square_footage', 'status', 'cluster_id'
    ];

    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }

    public function residents()
    {
        return $this->hasMany(Resident::class);
    }

    public function visitorRecords()
    {
        return $this->hasMany(VisitorRecord::class);
    }
}
