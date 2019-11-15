<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetGeneral extends Model {
	protected $table    = 'set_general';
	public $timestamps = false;

	public function scopeDefault($query) {
        return $query->where('id', 1)->first();
    }
}
