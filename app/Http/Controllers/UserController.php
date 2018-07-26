<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;

class UserController extends Controller
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
        return view('admin/userlist');
    }

    public function allusers(Request $request)
    {
        $columns = array( 
            0 => 'id',
            1 =>'fullname',
            2=> 'email',
            3=> 'mobile',
            4 =>'profile_image', 
            5 =>'license', 
            6=> 'action',
        );

        $totalData = DB::table('users')->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $posts = DB::table('users')->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $posts = DB::table('users')
                        ->where(function ($query) use ($search){
                            $query->where('id', 'LIKE', "%{$search}%");
                            $query->orWhere('firstname', 'LIKE',"%{$search}%");
                            $query->orWhere('lastname', 'LIKE',"%{$search}%");
                            $query->orWhere('email', 'LIKE',"%{$search}%");
                            $query->orWhere('mobile', 'LIKE',"%{$search}%");
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = DB::table('users')
                                ->where(function ($query) use ($search){
                                    $query->where('id', 'LIKE', "%{$search}%");
                                    $query->orWhere('firstname', 'LIKE',"%{$search}%");
                                    $query->orWhere('lastname', 'LIKE',"%{$search}%");
                                    $query->orWhere('email', 'LIKE',"%{$search}%");
                                    $query->orWhere('mobile', 'LIKE',"%{$search}%");
                                })
                                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $i = 1;
            foreach ($posts as $post)
            {
                //$show =  route('posts.show',$post->id);
                //$edit =  route('posts.edit',$post->id);
                $show =  '';
                $edit =  '';
                               
                $nestedData['id'] = $i;
                $nestedData['fullname'] = $post->firstname.' '.$post->lastname;
                $nestedData['email'] = $post->email;//substr(strip_tags(),0,50)."...";
                $nestedData['mobile'] = $post->mobile;
                if(trim($post->profile_image) == ''){
                    $nestedData['profile_image'] = '<img src="noimage.png" width="75px" >';
                }else{
                    $img = URL::to('/uploads/profile').'/'.$post->profile_image;
                    $nestedData['profile_image'] = "<img src='{$img}' width='75px' >";
                } 
                $nestedData['license'] = '<a href="'.$post->driving_licence_doc.'" target="_blanck">View License</a>';
                //$stat = ($post->status == 1) ? "&emsp;<a href='statusChange/1/{$post->id}' title='Active' ><span class='glyphicon glyphicon-ok'></span></a>" : "&emsp;<a href='statusChange/2/{$post->id}' title='Inactive' ><span class='glyphicon glyphicon-remove'></span></a>";
                $stat = ($post->status == 1) ? "&emsp;<a href='javascript:void(0);' onclick='statusChange(1,{$post->id})' title='Active' ><span class='glyphicon glyphicon-ok'></span></a>" : "&emsp;<a href='javascript:void(0);' title='Inactive' onclick='statusChange(2,{$post->id})' ><span class='glyphicon glyphicon-remove'></span></a>";
                // $nestedData['action'] = "&emsp;<a href='javescript:void(0);' title='SHOW' onclick='showUserDetails({$post->id})'><span class='glyphicon glyphicon-eye-open'></span></a>&emsp;";
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

    public function statusChange(Request $request)
    {
        if($request->status == '2' || $request->status == '0'){
            $status = '1';
        }else{
            $status = '0';
        }
        DB::table('users')->where('id', $request->id)->update(['status'=>$status]);
        echo json_encode('1');
    }
    
    public function showUserDetails(Request $request)
    {
        $user = DB::table('users')->where('id', $request->id)->first();
        echo json_encode($user);
    }
    
    public function subscribers(Request $request)
    {
        $columns = array( 
            0 =>'id', 
            1 =>'firstname',
            2=> 'lastname',
            3=> 'created_at',
            4=> 'action',
        );

        $totalData = DB::table('users')->where('is_subscribers',1)->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $posts = DB::table('users')
                    ->where('is_subscribers',1)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $posts = DB::table('users')
                        ->where('is_subscribers',1)
                        ->where('id','LIKE',"%{$search}%")
                        ->orWhere('firstname', 'LIKE',"%{$search}%")
                        ->orWhere('lastname', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = DB::table('users')
                        ->where('is_subscribers',1)
                        ->where('id','LIKE',"%{$search}%")
                        ->orWhere('firstname', 'LIKE',"%{$search}%")
                        ->orWhere('lastname', 'LIKE',"%{$search}%")
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

                $nestedData['id'] = $post->id;
                $nestedData['firstname'] = $post->firstname;
                $nestedData['lastname'] = substr(strip_tags($post->lastname),0,50)."...";
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($post->created_at));
                //$stat = ($post->status == 1) ? "&emsp;<a href='statusChange/1/{$post->id}' title='Active' ><span class='glyphicon glyphicon-ok'></span></a>" : "&emsp;<a href='statusChange/2/{$post->id}' title='Inactive' ><span class='glyphicon glyphicon-remove'></span></a>";
                $stat = ($post->status == 1) ? "&emsp;<a href='javascript:void(0);' onclick='statusChange(1,{$post->id})' title='Active' ><span class='glyphicon glyphicon-ok'></span></a>" : "&emsp;<a href='javascript:void(0);' title='Inactive' onclick='statusChange(2,{$post->id})' ><span class='glyphicon glyphicon-remove'></span></a>";
                $nestedData['action'] = "&emsp;<a href='javescript:void(0);' title='SHOW' onclick='showUserDetails({$post->id})'><span class='glyphicon glyphicon-eye-open'></span></a> 
                &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>$stat";
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
}
