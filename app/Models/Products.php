<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];

    public function groups(){
        return $this->belongsToMany(Campaigns::class, 'campaigns_product', 'product_id', 'campaign_id');
    }
    public function discount(){
        return $this->hasOne(Discounts::class, 'product_id', 'id');
    }
}
