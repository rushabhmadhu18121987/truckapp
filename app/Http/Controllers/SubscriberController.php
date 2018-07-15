<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SubscriberController extends Controller
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
        return view('admin/subscriber');
    }

    public function subscribersList(Request $request)
    {
      $columns = array( 
          0 =>'id', 
          1 =>'firstname',
          2=> 'lastname',
          3=> 'created_at',
          //4=> 'action',
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
              //$stat = ($post->status == 1) ? "&emsp;<a href='javascript:void(0);' onclick='statusChange(1,{$post->id})' title='Active' ><span class='glyphicon glyphicon-ok'></span></a>" : "&emsp;<a href='javascript:void(0);' title='Inactive' onclick='statusChange(2,{$post->id})' ><span class='glyphicon glyphicon-remove'></span></a>";
              //$nestedData['action'] = "&emsp;<a href='javescript:void(0);' title='SHOW' onclick='showUserDetails({$post->id})'><span class='glyphicon glyphicon-eye-open'></span></a>&emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>$stat";
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

    public function subscribers(Request $request)
    {
        
    }
}
