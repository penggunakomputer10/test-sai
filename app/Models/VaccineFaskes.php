<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineFaskes extends Model
{
    use HasFactory;

    protected $fillable = ['faskes_id','vaccine_id','quota'];
}
