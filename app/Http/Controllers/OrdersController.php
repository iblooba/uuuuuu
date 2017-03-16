<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class OrdersController extends Controller
{

    public function index()
      {
        if (Auth::check())
        {
          $orders =  DB::table('users')
                    ->leftJoin('shops', 'users.id', '=', 'shops.id')
                    ->leftJoin('orders', 'shops.ShopContract', '=', 'orders.seller')
                    ->where('users.id', '=', Auth::user()->id )
                    ->get();

                   return view('backend/orders', ['orders' => $orders]);
        }
          else{
              return Redirect('/home');
          }
      }

      public function totalincome()
        {
          if (Auth::check())
          {
              $orders_cp  =  DB::table('users')
                          ->leftJoin('shops', 'users.id', '=', 'shops.id')
                          ->leftJoin('orders', 'shops.ShopContract', '=', 'orders.seller')
                          ->select('shops.ShopContract', 'orders.Total')
                          ->where([['users.id', '=', Auth::user()->id],['orders.Status', '=', 'CP'],] )
                          ->sum('Total');
              $orders_wa =  DB::table('users')
                          ->leftJoin('shops', 'users.id', '=', 'shops.id')
                          ->leftJoin('orders', 'shops.ShopContract', '=', 'orders.seller')
                          ->select('shops.ShopContract', 'orders.Total')
                          ->where([['users.id', '=', Auth::user()->id],['orders.Status', '=', 'WA'],] )
                          ->sum('Total');
              $orders_ho = DB::table('users')
                          ->leftJoin('shops', 'users.id', '=', 'shops.id')
                          ->leftJoin('orders', 'shops.ShopContract', '=', 'orders.seller')
                          ->select('shops.ShopContract', 'orders.Total')
                          ->where([['users.id', '=', Auth::user()->id],['orders.Status', '=', 'HO'],] )
                          ->sum('Total');
              $orders_ns = DB::table('users')
                          ->leftJoin('shops', 'users.id', '=', 'shops.id')
                          ->leftJoin('orders', 'shops.ShopContract', '=', 'orders.seller')
                          ->select('shops.ShopContract', 'orders.Total')
                          ->where([['users.id', '=', Auth::user()->id],['orders.Status', '=', 'NS'],] )
                          ->sum('Total');

                    $data = array(
                      'orders_cp' => $orders_cp,
                      'orders_wa' => $orders_wa,
                      'orders_ho' => $orders_ho,
                      'orders_ns' => $orders_ns
                    );
                    return view('backend/totalincome',$data);
          }
        else{
            return Redirect('/home');
        }
      }

      public function detail($id)
           {
              $orders = DB::table('orders')->where('OrderID', $id)->first();
                 return view('backend/orderdetail', compact('orders'));
             }
             

}
