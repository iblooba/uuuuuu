<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
class TestController extends Controller
{

  public function index()
    {

    echo  $now = Carbon::now();
    echo "<br/>";
    echo  $nowA = Carbon::now();
    echo "<br/>";
   echo  $today = Carbon::today();
    echo "<br/>";




    echo  $asdf =   $now->year($now->year)->month($now->month)->day(1)->hour(00)->minute(00)->second(00)->toDateTimeString();
        echo "<br/>";

    echo  $nowA->year($nowA->year)->month($nowA->month)->day($nowA->day)->hour($nowA->hour)->minute($nowA->minute)->second($nowA->second)->toDateTimeString();
     echo "<br/>";

 echo "777777777777777777";


echo  $nowA->diffInDays($asdf);

 echo "<br/>";




}
}
