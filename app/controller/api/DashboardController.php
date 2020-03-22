<?php

namespace App\controller\api;

use App\system\controller\Controller;

class DashboardController extends Controller
{

    function dashboard($param)
    {
        return [
            "name" => "ANDORRA",
            "short_name" => "AD",
            "code" => "376",
            "id" => $param['id'],
            "config" => config('environment')  === 'local' ? config('endpoints.summery') : config('production_endpoints.summery')
        ];
    }

}
