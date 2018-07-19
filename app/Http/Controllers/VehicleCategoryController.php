<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class VehicleCategoryController extends Controller
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
        return view('admin/vehicleCategory');
    }

    public function categoryList(Request $request)
    {
      $columns = array( 
          0 =>'category_title', 
          1 =>'category_image',
          2=> 'created_at',
          3=> 'status',
          4=> 'action',
      );

      $totalData = DB::table('category')->count();

      $totalFiltered = $totalData; 

      $limit = $request->input('length');
      $start = $request->input('start');
      $order = $columns[$request->input('order.0.column')];
      $dir = $request->input('order.0.dir');

      if(empty($request->input('search.value')))
      {            
          $posts = DB::table('category')
                  ->offset($start)
                  ->limit($limit)
                  ->orderBy($order,$dir)
                  ->get();
      }
      else {
          $search = $request->input('search.value'); 

          $posts = DB::table('category')
                      ->where('id','LIKE',"%{$search}%")
                      ->orWhere('category_title', 'LIKE',"%{$search}%")
                      ->offset($start)
                      ->limit($limit)
                      ->orderBy($order,$dir)
                      ->get();

          $totalFiltered = DB::table('category')
                      ->where('id','LIKE',"%{$search}%")
                      ->orWhere('category_title', 'LIKE',"%{$search}%")
                      ->count();
      }

      $data = array();
      if(!empty($posts))
      {
          foreach ($posts as $post)
          {
              //$show =  route('posts.show',$post->id);
              //$edit =  route('posts.edit',$post->id);
              $show =  '';
              $edit =  '';

              $nestedData['category_title'] = $post->category_title;
              $nestedData['category_image'] = '<img src="uploads/category/'.$post->category_img_url.'" width="75px" >';
              if($post->status == '1'){
                $stats = '<lable class="badge badge-success">Active</lable>';
              }else{
                $stats = '<lable class="badge badge-warning">Inactive</lable>';
              }
              $nestedData['status'] = $stats;
              $nestedData['created_at'] = date('j M Y',strtotime($post->created_at));
              //$stat = ($post->status == 1) ? "&emsp;<a href='statusChange/1/{$post->id}' title='Active' ><span class='glyphicon glyphicon-ok'></span></a>" : "&emsp;<a href='statusChange/2/{$post->id}' title='Inactive' ><span class='glyphicon glyphicon-remove'></span></a>";
              $stat = ($post->status == 1) ? "&emsp;<a href='javascript:void(0);' onclick='statusChange(1,{$post->id})' title='Active' ><span class='glyphicon glyphicon-ok'></span></a>" : "&emsp;<a href='javascript:void(0);' title='Inactive' onclick='statusChange(2,{$post->id})' ><span class='glyphicon glyphicon-remove'></span></a>";
              $nestedData['action'] = "&emsp;<a href='editCategory/{$post->id}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>$stat";
              $data[] = $nestedData;

          }
      }

      $json_data = array(
          "draw"            => intval($request->input('draw')),  
          "recordsTotal"    => intval($totalData),  
          "recordsFiltered" => intval($totalFiltered), 
          "data"            => $data   
          );

          
      $user = DB::table('users')->where('is_subscribers','1')->first();
      echo json_encode($json_data);
    }

    public function categoryStatusChange(Request $request)
    {
        $id = $request->id;
        $sts = $request->sts;
        if($sts == '1'){
            $sts = '0';
        }else{
            $sts = '1';
        }
        DB::table('category')
                      ->where('id',$id)
                      ->update(['status'=>$sts]);
        echo json_encode('1');
    }
    
    public function editCategory($id){

        $data = DB::table('category')
                      ->where('id',$id)->first();
        return view('admin/editVehicleCategory',compact('data'));
    }

    public function updateCategory(Request $request)
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

    public function newCategory(Request $request){
        return view('admin/addVehicleCategory');
    }

    public function addCategory(Request $request)
    {
        $category_title = $request->category_name;
        $image = $request->file('category_image');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('uploads\category');
        $image->move($destinationPath, $input['imagename']);
        DB::table('category')->insert(['category_title'=>$category_title,'category_img_url'=>$input['imagename'],'status'=>'0','created_at'=>date('Y-m-d H:i:s')]);

        return view('admin/vehicleCategory');
    }

}
