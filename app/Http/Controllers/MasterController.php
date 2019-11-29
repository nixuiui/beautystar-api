<?php

namespace App\Http\Controllers;

use App\Models\MuaServiceCategory;
use App\Models\SetCity;
use App\Models\SetProvince;

class MasterController extends Controller
{
    
    public function muaServiceCategories() {
        $categories = MuaServiceCategory::whereNull("parent_id")->get();
        $categories = $categories->map(function($item){
            return [
                'id' => $item->id,
                'parent_id' => $item->parent_id,
                'name' => $item->name
            ];
        });
        return $this->responseOK(null, $categories);
    }

    public function province() {
        if(!isset($_GET['id'])) {
            $data = SetProvince::orderBy('name', 'asc')->get();
            $data = $data->map(function($item){
                return SetProvince::mapData($item);
            });
            return $this->responseOK(null, $data);
        }
        else {
            $id = $_GET['id'];
            $data = SetProvince::find($id);
            return $this->responseOK(null, $data);
        }
    }

    public function city() {
        if(!isset($_GET['province_id'])) {
            return $this->responseError("Gunakan param 'province_id' untuk mendapatkan data kota", null);
        }
        else {
            $province_id = $_GET['province_id'];
            $data = SetCity::where('province_id',$province_id)->get();
            $data = $data->map(function($item){
                return SetCity::mapData($item);
            });
            return $this->responseOK(null, $data);
        }
    }

}
