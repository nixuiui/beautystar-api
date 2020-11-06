<?php

namespace App\Http\Controllers;

use App\Traits\BaseResponseTrait;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use BaseResponseTrait;

    public $adminFeePercentage = 0.1;
    public $useEmailNotification = false;
    
    public $defaultLimitPerPage = 20;
    public $maxLimitPerPage = 100;
    public function setLimit($limitRequest) {
        if($limitRequest <= $this->maxLimit)
            return $limitRequest;
        return $this->defaultLimit;
    }
}
