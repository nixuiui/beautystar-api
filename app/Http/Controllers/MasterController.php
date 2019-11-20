<?php

namespace App\Http\Controllers;

use App\Models\MuaServiceCategory;

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

}
