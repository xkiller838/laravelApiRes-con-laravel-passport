<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use App\User;
use Validator;
use Response;
use Storage;

class AuthController extends Controller
{
     /** 
   * Login API 
   * 
   * @return \Illuminate\Http\Response 
   */ 
  public function login(Request $request){ 
    if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
      $user = Auth::user(); 
      $success['token'] =  $user->createToken('LaraPassport')->accessToken; 
      return response()->json([
        'status' => 'success',
        'data' => $success
      ]); 
    } else { 
      return response()->json([
        'status' => 'error',
        'data' => 'error de Access'
      ]); 
    } 
  }
    
    
     /** 
   * Register API 
   * 
   * @return \Illuminate\Http\Response 
   */ 
  public function register(Request $request) 
  { 
    $validator = Validator::make($request->all(), [ 
      'nombre' => 'required', 
      'apellido' => 'required', 
      'curp_pasaporte' => 'required', 
      'usuario' => 'required', 
      'rol' => 'required', 
      'email' => 'required|email', 
      'password' => 'required', 
      'c_password' => 'required|same:password', 
    ]);
    if ($validator->fails()) { 
      return response()->json(['error'=>$validator->errors()]);
    }
    $postArray = $request->all(); 
    $postArray['password'] = bcrypt($postArray['password']); 
    $user = User::create($postArray); 
    $success['token'] =  $user->createToken('LaraPassport')->accessToken; 
    $success['nombre'] =  $user->nombre;
      
    return response()->json(['status' => 'success','data' => $success,
    ]); 
  }
    
  /** 
   * details api 
   * 
   * @return \Illuminate\Http\Response 
   */ 
  public function details() 
  { 
    $user = Auth::user(); 
    return response()->json(['success' => $user]); 
  } 
    
    
    public function logout(Request $request)
    {
      $request->user()->token()->revoke();
      
        return response()->json(['message' => 
            'cerrar seccion exitoso']);
    }

    public function update(Request $r)
    {
       \App\User::find(auth()->user()->id)->update(['name'=>$r->name, 'email'=>$r->$email]);

       return response()->json(['success'=>'user usuario actualizado']);
    }
}
