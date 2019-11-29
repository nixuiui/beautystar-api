<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class MuaPortfolio extends Model
{
    use SoftDeletes;
    protected $table    = 'tbl_mua_portfolios';
    protected $dates 	= ['deleted_at'];

    protected $appends = ['photo_square', 'photo_thumbnail', 'photo_url'];

    protected static function boot() {
        parent::boot();
        static::deleting(function($data) {
        });
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }

    //RELATION table
  	public function mua() {
        return $this->belongsTo('App\Models\Mua', 'mua_id')->withDefault();
    }
  	public function service() {
        return $this->belongsTo('App\Models\MuaService', 'service_id')->withDefault();
    }
    
    public function getPhotoUrlAttribute(){
        return env('APP_URL_WEB') . '/storage/portfolios/' . $this->photo;
    }
    public function getPhotoSquareAttribute(){
        return env('APP_URL_WEB') . '/storage/portfolio-squares/' . $this->photo;
    }
    public function getPhotoThumbnailAttribute(){
        return env('APP_URL_WEB') . '/storage/portfolio-thumbnails/' . $this->photo;
    }

    public static function mapData($data, $additionalAttribute = null) {
        $result = [
            'id' => $data->id,
            'mua_id' => $data->mua_id,
            'service_id' => $data->service_id,
            'service' => $data->service->name,
            'photo' => $data->photo,
            'photo_square' => $data->photo_square,
            'photo_thumbnail' => $data->photo_thumbnail,
            'photo_url' => $data->photo_url
        ];
        if($additionalAttribute) {
            $result = array_merge($result, $additionalAttribute);
        }
        return $result;
    }

}
