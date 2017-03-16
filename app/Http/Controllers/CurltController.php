<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Curl;
use App\User;
use Auth;
class CurltController extends Controller
  {
      public function selectcurl(Request $Request)
          {

              $buyer = $Request->input('buyer'); // รับตัวแปร name จาก html form
              $seller = $Request->input('seller'); // รับตัวแปร name จาก html form
              $price = $Request->input('price'); // รับตัวแปร name จาก html form
              $paymentTerm = $Request->input('paymentTerm'); // รับตัวแปร name จาก html form
              if (Auth::check())
              {
              DB::table('orders')->insert(
                 [ 'contract_id' => 0,
                   'OrderNoCreate' => '',
                   'hashCreate' => '',
                   'DateCreate' => date("Y-m-d H:i:s"),
                   'OrderNoCofirm' => 0,
                   'hashConfirm' => '',
                   'DateConfirm' => '',
                   'ContractAddress' => '',
                   'total' => $price,
                   'paymentTerm' => $paymentTerm,
                   'OrderDateTime' => date("Y-m-d H:i:s"),
                   'ConfirmDateTime' => '',
                   'buyer' => $buyer,
                   'seller' => $seller,
                   'Status' => 'WA',
                   'users_id' => Auth::user()->id
                 ]
               );

            	$data = array(
            		'buyer' => $buyer,
                'seller' => $seller,
                'price' => $price,
                'paymentTerm' => $paymentTerm
            	);
                return view("step1",$data); // return ค่าออกไปแสดงที่ register view
              }
              else{
                    return Redirect('/home');
              }
          }
        public function step2(Request $Request)
          {
             $transactionHash = $Request->input('transactionHash'); // รับตัวแปร name จาก html form
             $id = $Request->input('id');
             $contract_id = $Request->input('contract_id');

              $orders = DB::table('orders')->orderBy('OrderID', 'desc')->first();
              $m = DB::table('orders');
                    $OrderID = $orders->OrderID;
                    $dataupdate = array(
                               'hashCreate'  => $transactionHash,
                               'OrderNoCreate' => $id,
                               'contract_id' => $contract_id);
                               $m->where('OrderID',$OrderID)->update($dataupdate);

                 $data = array(
                   'transactionHash' => $transactionHash,
                   'id' => $id,
                   'contract_id' => $contract_id,
                   'OrderID' => $OrderID
                 );
                return view("step2",$data); // return ค่าออกไปแสดงที่ register view
        }
      public function step3(Request $Request)
        {
            $contract_id = $Request->input('contract_id');
            $contractAddress = $Request->input('contractAddress');
            $DateCreate = date("Y-m-d H:i:s");

              $orders = DB::table('orders')->orderBy('OrderID', 'desc')->first();
              $m=DB::table('orders');
              $OrderID = $orders->OrderID;
              $dataupdate = array(
                              'contractAddress' => $contractAddress,
                              'DateCreate' => $DateCreate);
                              $m->where('OrderID',$OrderID)->update($dataupdate);

                $data = array(
                      'contract_id' => $contract_id
                    );
                      return view("step3",$data); // return ค่าออกไปแสดงที่ register view
        }

        public function insertconfirm(Request $Request)
          {
            $transactionHash = $Request->input('transactionHash'); // รับตัวแปร name จาก html form
            $id = $Request->input('id');
            $DateConfirm = date("Y-m-d H:i:s");

                $orders = DB::table('orders')->orderBy('OrderID', 'desc')->first();
                $m = DB::table('orders');
                $OrderID = $orders->OrderID;
                $dataupdate = array(
                              'hashConfirm' => $transactionHash,
                              'OrderNoCofirm' => $id,
                              'DateConfirm' => $DateConfirm);
                              $m->where('OrderID',$OrderID)->update($dataupdate);

                return Redirect('/payment'); // return ค่าออกไปแสดงที่ register view
          }

      public function step4(Request $Request)
        {
            $keydata = $Request->input('keydata'); // รับตัวแปร name จาก html form
            $medthod_name = $Request->input('medthod_name'); // รับตัวแปร name จาก html form

            $data = array(
                'keydata' => $keydata,
                'medthod_name' => $medthod_name);
              return view("step4",$data); // return ค่าออกไปแสดงที่ register view
        }
      public function stepconfirm(Request $Request)
        {
          //  $keydata = $Request->input('keydata'); // รับตัวแปร name จาก html form
            $contract_id = $Request->input('contract_id'); // รับตัวแปร name จาก html form
            $ConfirmDateTime = date("Y-m-d H:i:s");

              $orders = DB::table('orders')->orderBy('OrderID', 'desc')->first();
              $m = DB::table('orders');
              $OrderID = $orders->OrderID;

              $datetimeupdate = array(
                'status' => 'CP',
                'ConfirmDateTime' => $ConfirmDateTime);
                $m->where('OrderID',$OrderID)->update($datetimeupdate);

              $data = array(
                'contract_id' => $contract_id
                );

              return view("stepconfirm",$data); // return ค่าออกไปแสดงที่ register view
        }
      public function redirect(Request $Request)
        {
            $result = $Request->input('result'); // รับตัวแปร name จาก html form
            $data = array(
                    'result' => $result
                   );
              return view("getpost",$data); // return ค่าออกไปแสดงที่ register view
        }
      public function updatecontract(Request $Request)
        {
            $contractAddress = $Request->input('contractAddress'); // รับตัวแปร name จาก html form
            $orders = DB::table('orders')->orderBy('OrderID', 'desc')->first();

            $m=DB::table('orders');
                  $OrderID = $orders->OrderID;
                  $dataupdate = array(
                                 'contractAddress'  => $contractAddress);
                                 $m->where('OrderID',$OrderID)->update($dataupdate);
                 $data = array(
                        'contractAddress' => $contractAddress
                        );
              return view("contractaddress",$data); // return ค่าออกไปแสดงที่ register view
        }

        public function payment()
          {
            if (Auth::check()) {
                return view("payment"); // return ค่าออกไปแสดงที่ register view
            }
            else{
                return Redirect('/home');
            }
          }
  }

?>
