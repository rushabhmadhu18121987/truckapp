<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;

class VehicleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/vehicle');
    }

    public function vehicleList(Request $request)
    {
      $columns = array( 
          0 =>'id', 
          1 =>'owner', 
          2 =>'title', 
          3 =>'vehicle_type',
          4=> 'make',
          5=> 'model',
          6=> 'color',
          7=> 'vehicle_condition',
          8=> 'hourly_price',
          9=> 'daily_price',
          10=> 'weekly_price',
          11=> 'monthly_price',
          12=> 'action',
      );

      $totalData = DB::table('vehicles as v')
                              ->select('v.*','v.id as vid','u.firstname','u.lastname','category_title')
                              ->leftJoin('users as u', 'u.id', 'v.user_id')
                              ->leftJoin('category as c', 'c.id', 'v.type')
                              ->count();

      $totalFiltered = $totalData; 

      $limit = $request->input('length');
      $start = $request->input('start');
      $order = $columns[$request->input('order.0.column')];
      $dir = $request->input('order.0.dir');

      if(empty($request->input('search.value')))
      {            
          $posts = DB::table('vehicles as v')
                  ->select('v.*','v.id as vid','u.firstname','u.lastname','category_title')
                  ->leftJoin('users as u', 'u.id', 'v.user_id')
                  ->leftJoin('category as c', 'c.id', 'v.type')
                  ->offset($start)
                  ->limit($limit)
                  ->orderBy($order,$dir)
                  ->get();
      }
      else {
          $search = $request->input('search.value'); 

          $posts = DB::table('vehicles as v')
                      ->select('v.*','v.id as vid','u.firstname','u.lastname','category_title')
                      ->leftJoin('users as u', 'u.id', 'v.user_id')
                      ->leftJoin('category as c', 'c.id', 'v.type')
                      ->where(function ($query) use ($search){
                          $query->where('u.firstname', 'LIKE',"%{$search}%");
                          $query->orWhere('u.lastname', 'LIKE',"%{$search}%");
                          $query->orWhere('v.title', 'LIKE',"%{$search}%");
                          $query->orWhere('v.make', 'LIKE',"%{$search}%");
                          $query->orWhere('v.model', 'LIKE',"%{$search}%");
                          $query->orWhere('v.color', 'LIKE',"%{$search}%");
                      })
                      ->offset($start)
                      ->limit($limit)
                      ->orderBy($order,$dir)
                      ->get();

          $totalFiltered = DB::table('vehicles as v')
                                ->select('v.*','v.id as vid','u.firstname','u.lastname','category_title')
                                ->leftJoin('users as u', 'u.id', 'v.user_id')
                                ->leftJoin('category as c', 'c.id', 'v.type')
                                ->where(function ($query) use ($search){
                                  $query->where('u.firstname', 'LIKE',"%{$search}%");
                                  $query->orWhere('u.lastname', 'LIKE',"%{$search}%");
                                  $query->orWhere('v.title', 'LIKE',"%{$search}%");
                                  $query->orWhere('v.make', 'LIKE',"%{$search}%");
                                  $query->orWhere('v.model', 'LIKE',"%{$search}%");
                                  $query->orWhere('v.color', 'LIKE',"%{$search}%");
                                })
                                ->count();
      }

      $data = array();
      if(!empty($posts))
      {
        $i = 1;
          foreach ($posts as $post)
          {
              $nestedData['id'] = $i;
              $nestedData['owner'] = $post->firstname.' '.$post->lastname;
              $nestedData['title'] = $post->title;
              $nestedData['vehicle_type'] = $post->category_title;
              $nestedData['make'] = $post->make;
              $nestedData['model'] = $post->model;
              $nestedData['color'] = $post->color;
              // if($post->status == '1'){
              //   $stats = '<lable class="badge badge-success">Active</lable>';
              // }else{
              //   $stats = '<lable class="badge badge-warning">Inactive</lable>';
              // }
              // $nestedData['status'] = $stats;
              $nestedData['vehicle_condition'] = $post->vehicle_condition;
              $nestedData['hourly_price'] = $post->hourly_price;
              $nestedData['daily_price'] = $post->daily_price;
              $nestedData['weekly_price'] = $post->weekly_price;
              $nestedData['monthly_price'] = $post->monthly_price;
              
              //$stat = ($post->status == 1) ? "&emsp;<a href='statusChange/1/{$post->vid}' title='Active' ><span class='glyphicon glyphicon-ok'></span></a>" : "&emsp;<a href='statusChange/2/{$post->vid}' title='Inactive' ><span class='glyphicon glyphicon-remove'></span></a>";
              $stat = ($post->status == 1) ? "&emsp;<a href='javascript:void(0);' onclick='statusChange(1,{$post->vid})' title='Active' ><span class='glyphicon glyphicon-ok'></span></a>" : "&emsp;<a href='javascript:void(0);' title='Inactive' onclick='statusChange(2,{$post->vid})' ><span class='glyphicon glyphicon-remove'></span></a>";
              //$nestedData['action'] = "&emsp;<a href='editPromocode/{$post->vid}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>$stat";
              $nestedData['action'] = $stat;
              $data[] = $nestedData;
              $i++;
          }
      } 

      $json_data = array(
          "draw"            => intval($request->input('draw')),  
          "recordsTotal"    => intval($totalData),  
          "recordsFiltered" => intval($totalFiltered), 
          "data"            => $data   
          );

      echo json_encode($json_data);
    }

    public function vehicleStatusChange(Request $request)
    {
        $id = $request->id;
        $sts = $request->sts;
        if($sts == '1'){
            $sts = '0';
        }else{
            $sts = '1';
        }
        DB::table('vehicles')
                      ->where('id',$id)
                      ->update(['status'=>$sts]);
        echo json_encode('1');
    }
    
    public function editPromocode($id){

        $data = DB::table('promocodes')
                      ->where('id',$id)->first();
        return view('admin/editPromocode',compact('data'));
    }

    public function updatePromocode(Request $request)
    {
        
        $id = $request->cid;
        $category_title = $request->category_name;
        //$category_img_url = $request->category_image;
        /*$this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
*/

        $image = $request->file('category_image');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('uploads\category');
        $image->move($destinationPath, $input['imagename']);

        DB::table('category')
                      ->where('id',$id)
                      ->update(['category_title'=>$category_title,'category_img_url'=>$input['imagename'],'updated_at'=>date('Y-m-d H:i:s')]);

        return redirect('vehicleCat');
    }

    public function newPromocode(Request $request){
        return view('admin/addPromocode');
    }

    public function addPromocode(Request $request)
    {
        $promocode_title = $request->promocode_title;
        $promo_code = $request->promo_code;
        $promotypes = $request->promotypes;
        $price = $request->price;
        $percentage = $request->percentage;
        $startdate = date('Y-m-d',strtotime($request->startdate));
        $enddate = date('Y-m-d',strtotime($request->enddate));
        if($promotypes == '1'){
            DB::table('promocodes')->insert(['title'=>$promocode_title,'promo_code'=>$promo_code,'price'=>$price,'start_date'=>$startdate,'end_date'=>$enddate,'status'=>'0','no_of_promo'=>0,'created_at'=>date('Y-m-d H:i:s')]);
        }else{
            DB::table('promocodes')->insert(['title'=>$promocode_title,'promo_code'=>$promo_code,'percentage'=>$percentage,'start_date'=>$startdate,'end_date'=>$enddate,'status'=>'0','no_of_promo'=>0,'created_at'=>date('Y-m-d H:i:s')]);
        }
        return Redirect::action('PromocodeController@index');
        //return view('admin/promocode');
    }

}
