<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cluster extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'total_units', 'common_areas',
        'maintenance_schedule', 'parking_spaces', 'residential_area_id'
    ];

    public function residentialArea()
    {
        return $this->belongsTo(ResidentialArea::class);
    }

    public function houses()
    {
        return $this->hasMany(House::class);
    }

    public function guards()
    {
        return $this->hasMany(Guard::class);
    }
}
