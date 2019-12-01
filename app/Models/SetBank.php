<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SetBank extends Model {
	protected $table    = 'set_banks';
	public $timestamps = false;

    protected static function boot() {
        parent::boot();
        static::deleting(function($data) {
        });
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }
}
