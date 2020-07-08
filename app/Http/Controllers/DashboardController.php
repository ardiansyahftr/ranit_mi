<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function getDashboard()
    {
        //First, Add an auth
        //Create your own query
        $data = [];
        $data['page_title'] = 'DASHBOARD';
        //$data['result'] = DB::table('products')->orderby('id','desc')->get();

        //Create a view. Please use `cbView` method instead of view method from laravel.        
        return view('Page.dashboard',$data);
    }


    public function statistik(Request $request)
    {
    	$data = [];

        $role     = $request->session()->get('role');
        $id     = $request->session()->get('id');
        if ($role == "Administrator") {
        $data['reguler'] = DB::table('tb_pembelian')
                            ->where('id_category','1')
                            ->whereMonth('date',date('m'))
                            ->count();
        $data['non_reguler'] = DB::table('tb_pembelian')
                            ->where('id_category','2')
                            ->whereMonth('date',date('m'))
                            ->count();
        $data['biaya_tol'] = DB::table('tb_pembelian') 
                            ->where('id_category','1')
                            ->whereMonth('date',date('m'))                       
                            ->sum('total_harga');
         $data['biaya_fuel'] = DB::table('tb_pembelian')   
                            ->where('id_category','2')
                            ->whereMonth('date',date('m'))                       
                            ->sum('total_harga');
        }else{
        $data['reguler'] = DB::table('tb_pembelian')
                            ->where('id_category','1')
                            ->where('id_user',$id)
                            ->whereMonth('date',date('m'))
                            ->count();
        $data['non_reguler'] = DB::table('tb_pembelian')
                            ->where('id_category','2')
                            ->where('id_user',$id)
                            ->whereMonth('date',date('m'))
                            ->count();
        $data['biaya_tol'] = DB::table('tb_pembelian') 
                            ->where('id_category','1')
                            ->where('id_user',$id)
                            ->whereMonth('date',date('m'))                       
                            ->sum('total_harga');
         $data['biaya_fuel'] = DB::table('tb_pembelian')   
                            ->where('id_category','2')
                            ->where('id_user',$id)
                            ->whereMonth('date',date('m'))                       
                            ->sum('total_harga');
        }


    	return $data;

    }

    public function chart_tol()
    {
        $data =[];            

        for ($i=1; $i < 13 ; $i++) { 
            $data[] = DB::table("tb_pembelian")    
            ->whereMonth('created_at', '=', $i)
            ->whereYear('created_at', '=', date('Y'))
            ->where('id_category','1')
            ->sum('total_harga');           
        }          
        return [
            'biaya_tol' => $data,            
        ];
    }

     public function chart_bensin()
    {
        $data =[];            

        for ($i=1; $i < 13 ; $i++) { 
            $data[] = DB::table("tb_pembelian") 
            ->where('id_category','2')   
            ->whereMonth('created_at', '=', $i)
            ->whereYear('created_at', '=', date('Y'))
            ->sum('total_harga');           
        }           

        return [
            'biaya_tol' => $data            
        ];
    }
}
