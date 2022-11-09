<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faskes extends Model
{
    use HasFactory;

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function vaccines()
    {
        return $this->belongsToMany(Vaccine::class,'vaccine_faskes','faskes_id','vaccine_id')->select('*');
    }

    public function data_vaccines()
    {
        return $this->belongsToMany(Vaccine::class,'vaccine_faskes','faskes_id','vaccine_id')->select('vaccines.id as id', 'vaccines.name as name', 'quota');
    }
}
