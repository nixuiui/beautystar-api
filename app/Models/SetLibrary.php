<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SetLibrary extends Model {
    protected $table    = 'set_libraries';

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    //SCOPE
    public function scopeRole($query, $id = null) {
        $query = $query->where("category_id", 10)->get();
        if($id != null) $query = $query->where("id", $id)->first();
        return $query;
    }

    //RELATION TABLE
  	public function category() {
  		return $this->belongsTo('App\Models\SetCategory', 'category_id');
  	}
}
