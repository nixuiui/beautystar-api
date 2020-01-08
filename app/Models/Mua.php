<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mua extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_mua';
    protected $dates = ['deleted_at'];
    protected $appends = ['thumbnail', 'square_photo', 'full_address'];

    protected static function boot() {
        parent::boot();
        static::deleting(function ($data) {
        });
    }

    //RELATION table
    public function portfolios() {
        return $this->hasMany('App\Models\MuaPortfolio', 'mua_id');
    }
    public function services() {
        return $this->hasMany('App\Models\MuaService', 'mua_id');
    }
    public function downpayments() {
        return $this->hasMany('App\Models\MuaDP', 'mua_id');
    }
    public function orders() {
        return $this->hasMany('App\Models\MuaOrder', 'mua_id');
    }
    public function feedbacks() {
        return $this->hasMany('App\Models\MuaFeedback', 'mua_id');
    }
    public function schedules() {
        return $this->hasMany('App\Models\MuaSchedule', 'mua_id');
    }
    public function owner() {
        return $this->belongsTo('App\Models\User', 'user_id')->withDefault();
    }
    public function city() {
        return $this->belongsTo('App\Models\SetCity', 'city_id')->withDefault();
    }
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id')->withDefault();
    }
    public function province() {
        return $this->belongsTo('App\Models\SetProvince', 'province_id')->withDefault();
    }
    public function existingCategories() {
        return $this->belongsToMany('App\Models\MuaServiceCategory', 'tbl_mua_services', 'mua_id', 'category_id');
    }

    // ATTRIBUTE
    public function getThumbnailAttribute(){
        if($this->portfolios()->count() > 0)
            return $this->portfolios[0]->photo_thumbnail;
        return env('APP_URL_WEB') . '/image/noimage1.png';
    }
    public function getFullAddressAttribute(){
        $address = "";
        if($this->address)
            $address .= $this->address;
        if($this->city) {
            if($address) $address .= ", ";
            $address .= $this->city->name;
        }
        if($this->province) {
            if($address) $address .= ", ";
            $address .= $this->province->name;
        }
        return $address;
    }
    public function getSquarePhotoAttribute(){
        if($this->portfolios()->count() > 0)
            return $this->portfolios[0]->photo_square;
        return env('APP_URL_WEB') . '/image/noimage2.png';
    }

    // $data is Array Data
    // $additionalAttribute is Array Data
    public static function mapData($data, $additionalAttribute = null) {
        $result = [
            'id' => $data->id,
            'user_id' => $data->user_id,
            'rate' => $data->rate,
            'brand_name' => $data->brand_name,
            'province_id' => $data->province_id,
            'province' => $data->province->name,
            'city_id' => $data->city_id,
            'city' => $data->city->name,
            'address' => $data->address,
            'description' => $data->description,
            'instagram' => $data->instagram,
            'facebook' => $data->facebook,
            'is_verified' => (bool) $data->is_verified,
            'full_address' => $data->full_address
        ];
        if($additionalAttribute) {
            $result = array_merge($result, $additionalAttribute);
        }
        return $result;
    }
}
