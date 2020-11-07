<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait BaseResponseTrait {

    public function responseOK($message = null, $data = null, $responseCode = 200) {
        $attribue = [
            "status"    => "OK",
            "message"   => $message,
            "data"      => $data
        ];
        return response()->json($attribue, $responseCode, [], JSON_NUMERIC_CHECK);
    }
    
    public function responseOKAddAttr($message = null, $data = null, $arr, $responseCode = 200) {
        $attribue = [
            "status"    => "OK",
            "message"   => $message
        ];
        $data = ["data" => $data];
        if(is_array($arr))
        $attribue = array_merge($attribue, $arr);
        $attribue = array_merge($attribue, $data);
        return response()->json($attribue, $responseCode, [], JSON_NUMERIC_CHECK);
    }

    public function responseError($message = null, $data = null, $responseCode = 400) {
        $attribue = [
            "status"    => "ERROR",
            "message"   => $message,
            "data"      => $data
        ];
        return response()->json($attribue, $responseCode, [], JSON_NUMERIC_CHECK);
    }
    
    public function responseNotValidInput($message = null, $data = null, $responseCode = 402) {
        $attribue = [
            "status"    => "INVALID_INPUT",
            "message"   => $message,
            "data"      => $data
        ];
        return response()->json($attribue, $responseCode, [], JSON_NUMERIC_CHECK);
    }
    
}