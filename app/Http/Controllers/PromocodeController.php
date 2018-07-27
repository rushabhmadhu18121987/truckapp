<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;

class PromocodeController extends Controller
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
        return view('admin/promocode');
    }

    public function promocodeList(Request $request)
    {
      $columns = array( 
          0 =>'id', 
          1 =>'title', 
          2 =>'promo_code',
          3=> 'price',
          4=> 'percentage',
          5=> 'start_date',
          6=> 'end_date',
          7=> 'action',
      );

      $totalData = DB::table('promocodes')
                              ->count();

      $totalFiltered = $totalData; 

      $limit = $request->input('length');
      $start = $request->input('start');
      $order = $columns[$request->input('order.0.column')];
      $dir = $request->input('order.0.dir');

      if(empty($request->input('search.value')))
      {            
          $posts = DB::table('promocodes')
                  ->offset($start)
                  ->limit($limit)
                  ->orderBy($order,$dir)
                  ->get();
      }
      else {
          $search = $request->input('search.value'); 

          $posts = DB::table('promocodes')
                      ->where(function ($query) use ($search){
                          $query->where('title', 'LIKE',"%{$search}%");
                          $query->orWhere('promo_code', 'LIKE',"%{$search}%");
                          $query->orWhere('price', 'LIKE',"%{$search}%");
                          $query->orWhere('percentage', 'LIKE',"%{$search}%");
                      })
                      ->offset($start)
                      ->limit($limit)
                      ->orderBy($order,$dir)
                      ->get();

          $totalFiltered = DB::table('orders as o')
                                ->where(function ($query) use ($search){
                                  $query->where('title', 'LIKE',"%{$search}%");
                                  $query->orWhere('promo_code', 'LIKE',"%{$search}%");
                                  $query->orWhere('price', 'LIKE',"%{$search}%");
                                  $query->orWhere('percentage', 'LIKE',"%{$search}%");
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
              $nestedData['title'] = $post->title;
              $nestedData['promo_code'] = $post->promo_code;
              $nestedData['price'] = $post->price;
              $nestedData['percentage'] = $post->percentage;
              // if($post->status == '1'){
              //   $stats = '<lable class="badge badge-success">Active</lable>';
              // }else{
              //   $stats = '<lable class="badge badge-warning">Inactive</lable>';
              // }
              // $nestedData['status'] = $stats;
              $nestedData['start_date'] = date('j M Y',strtotime($post->start_date));
              $nestedData['end_date'] = date('j M Y',strtotime($post->end_date));
              //$stat = ($post->status == 1) ? "&emsp;<a href='statusChange/1/{$post->id}' title='Active' ><span class='glyphicon glyphicon-ok'></span></a>" : "&emsp;<a href='statusChange/2/{$post->id}' title='Inactive' ><span class='glyphicon glyphicon-remove'></span></a>";
              $stat = ($post->status == 1) ? "&emsp;<a href='javascript:void(0);' onclick='statusChange(1,{$post->id})' title='Active' ><span class='glyphicon glyphicon-ok'></span></a>" : "&emsp;<a href='javascript:void(0);' title='Inactive' onclick='statusChange(2,{$post->id})' ><span class='glyphicon glyphicon-remove'></span></a>";
              //$nestedData['action'] = "&emsp;<a href='editPromocode/{$post->id}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>$stat";
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

    public function promocodeStatusChange(Request $request)
    {
        $id = $request->id;
        $sts = $request->sts;
        if($sts == '1'){
            $sts = '0';
        }else{
            $sts = '1';
        }
        DB::table('promocodes')
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
