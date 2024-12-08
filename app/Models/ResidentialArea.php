<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentialArea extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'city', 'state'];

    public function clusters()
    {
        return $this->hasMany(Cluster::class);
    }
}
