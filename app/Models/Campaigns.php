<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaigns extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active'
    ];

    public function groups(){
        return $this->hasMany(Groups::class, "campaign_id", "id");
    }
    public function products(){
        return $this->belongsToMany(Products::class, 'campaign_product', 'campaign_id', 'product_id');
    }
}
