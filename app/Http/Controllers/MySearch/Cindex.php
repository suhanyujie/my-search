<?php

namespace App\Http\Controllers\MySearch;

use App\Models\MySearch\OilUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Cindex extends Controller
{
    /**
     * @desc: 入口方法
     * @author:Samuel Su(suhanyu)
     * @date:17/6/26
     * @param void
     * @return mixed
     */
    public function index() {

        $count = 0;
        for ($i=0;$i<=21;$i++) {
            $offset = 1000 * $i;
            echo $offset.PHP_EOL;
            $sql = 'select dealer_name from oil_user limit '.$offset.',1000';
            $users = DB::select($sql);
            foreach ($users as $k => $row) {
                if ($row->dealer_name != trim($row->dealer_name)){
                    $count++;
                }
            }
            sleep(0.5);
        }

        return $count;
    }
}
