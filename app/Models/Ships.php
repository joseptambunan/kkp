<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ships extends Model
{
    use HasFactory;
    protected $fillable = ['code','ship_name','ship_owner','address_owner','ship_size','captain','member','ship_images','permit_number','permit_document','created_by','approved_at','approved_by'];


    
}
