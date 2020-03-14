<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorCategory extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_vendor_categories';
    protected $dates = ['deleted_at'];

    //RELATION table
    public function subCategories() {
        return $this->hasMany('App\Models\MuaServiceCategory', 'vendor_category_id');
    }
}
