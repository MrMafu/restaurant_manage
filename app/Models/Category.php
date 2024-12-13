<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = ['category_name'];

    public function menu(): HasMany
    {
        return $this->hasMany(Menu::class);
    }
}