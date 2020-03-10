<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;


class ApiController extends Controller
{
	public function register(Request $request){
		   $validator = Validator::make($request->all(), [
			   'name' => 'required',
			   'email' => 'required|email|unique:users',
			   'password' => 'required',
			   'password_valid' => 'required|same:password'
		   ]);
		   if ($validator->fails()) {
			   return response()->json($validator->errors(), 400);
		   }
		   $input = $request->all();
		   $input['password'] = bcrypt($input['password']);
		   $user = User::create($input);
		   if ($user->save()) {
			   return response()->json(array('message'=>'user_register_ok'), 200);
		   } else {
			   return response()->json(array('message'=>'user_register_fail'), 400);
		   }
	}
	public function login(){
		   if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
			   $user = Auth::user();
			   $success['token'] = $user->createToken('RahatlaticiMuzikler')->accessToken;
			   $success['user_id'] = $user->id;
			   $success['email'] = $user->email;
			   $success['name'] = $user->name;
			   return response()->json($success, 200);
		   } else {
			   return response()->json(array('message'=>'login_fields_error'), 401);
		   }
	}
	public function service(){
		return 'test OK!';
	}
	public function check(Request $request){
		if($request->aplication_version != '1.6'){
			return response()->json(array('message'=>'force_update'), 401);
		}
		if($request->language_version != '2.1'){
			return response()->json(array('message'=>'soft_update'), 401);
		}
		
		return response()->json(array('message'=>'check_ok'), 200);
	} 
	public function categoryList(){
		$category_list = DB::table('category')->get();
		return response()->json($category_list);
	
	}	
	public function categorySongs($id){
		$songs = DB::table('songs')->where('category_id', $id)->get();
		return response()->json($songs);
	}	
	public function favorite(Request $request){
		$favorite_check = DB::table('users_favorite')->where('user_id', $request->user()->id)->where('song_id', $request->song_id)->count();
		if($favorite_check){
			DB::table('users_favorite')->where('user_id', $request->user()->id)->where('song_id', $request->song_id)->delete();
			return response()->json(array('message'=>'favorite_song_removed'), 200);
		}
		else{
			DB::table('users_favorite')->insert(
				['user_id' => $request->user()->id, 'song_id' => $request->song_id]
			);
			return response()->json(array('message'=>'favorite_song_added'), 200);
		}
	}
}