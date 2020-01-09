<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, JWTSubject {

    use Authenticatable, CanResetPassword, SoftDeletes;

    protected $table        = 'tbl_users';
    protected $dates        = ['deleted_at'];
    protected $hidden       = [
        'password', 'remember_token',
    ];
    protected $append       = ['photo', 'phone', 'balance_formatted', 'gender_alias'];


    protected static function boot() {
        parent::boot();
        static::deleting(function($data) {
            // $data->method()->delete();
        });
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    //RELATION table
  	public function role() {
  		return $this->belongsTo('App\Models\SetPustaka', 'role_id')->withDefault();
    }
    public function defaultAddress() {
        return $this->belongsTo('App\Models\Address', 'user_id')->withDefault();
    }
    public function addresses() {
        return $this->hasMany('App\Models\Address', 'user_id');
    }
    public function mua() {
        return $this->hasOne('App\Models\Mua', 'user_id');
    }
    public function giveaway() {
        return $this->hasOne('App\Models\GiveawayParticipants', 'user_id');
    }
    public function muaOrders() {
      return $this->hasMany('App\Models\MuaOrder', 'user_id');
    }

    // ATTRIBUTE
    public function getPhotoAttribute(){
        if($this->profile_photo)
            return env('APP_URL_WEB') . '/storage/profile/' . $this->profile_photo;
        return env('APP_URL_WEB') . '/image/noimage2.png';
    }
    public function getPhoneAttribute(){
        if($this->no_hp)
            return "+62" . $this->no_hp;
        return null;
    }
    public function getBalanceFormattedAttribute(){
        return formatUang($this->balance);
    }
    public function getGenderAliasAttribute(){
        return $this->gender == 1101 ? "Laki-laki" : "Perempuan";
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    // $data is Array Data
    // $additionalAttribute is Array Data
    public static function mapData($data, $additionalAttribute = null) {
        $result = [
            'id' => $data->id,
            'name' => $data->name,
            'username' => $data->username,
            'email' => $data->email,
            'balance' => $data->balance,
            'balance_formatted' => $data->balance_formatted,
            'gender' => $data->gender,
            'gender_alias' => $data->gender_alias,
            'birth_date' => $data->birth_date,
            'birth_date_formatted' => tanggal($data->birth_date),
            'photo' => $data->photo,
            'address_id' => $data->address_id,
            'phone' => $data->phone,
            'phone_original' => $data->no_hp
        ];
        if($additionalAttribute) {
            $result = array_merge($result, $additionalAttribute);
        }
        return $result;
    }

}
