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
        return asset('storage/portfolios/' . $this->photo);
    }
    public function getPhotoSquareAttribute(){
        return asset('storage/portfolio-squares/' . $this->photo);
    }
    public function getPhotoThumbnailAttribute(){
        return asset('storage/portfolio-thumbnails/' . $this->photo);
    }

}
