<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function cities(){
        return $this->hasMany(Cities::class, "group_id", "id");
    }
    public function campaigns(){
        return $this->hasOne(Campaigns::class, "campaign_id");
    }
}
