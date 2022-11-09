<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    use HasFactory;

    public function faskes()
    {
        return $this->belongsToMany(Faskes::class,'vaccine_faskes','vaccine_id','faskes_id')->select('*');
    }
}
