<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MuaServiceCategory extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_mua_service_categories';
    protected $dates = ['deleted_at'];

    // protected static function boot() {
    //     parent::boot();
    //     static::deleting(function($data) {
    //     });
    // }

    //RELATION table
    public function services() {
        return $this->hasMany('App\Models\MuaService', 'category_id');
    }
    public function subCategories() {
        return $this->hasMany('App\Models\MuaServiceCategory', 'parent_id');
    }

    public function scopeParent($query) {
        return $query->where('parent_id', null);
    }
}
