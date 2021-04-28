<?php

namespace App\Http\Controllers;

use Hash;
use Exception;
use App\Entities\User;
use App\Entities\FrUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Entities\MkApi;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    protected $api;

    public function __construct(MkApi $api)
    {
        $this->api = $api;
    }

     /**Diret to login page */
     public function login(){
        Cookie::queue('remembered', 'remembered', 1);
        return view('auth.login');
    }

  /**Diret to login page if logout */
  public function logout(){
      Auth::logout();
      return redirect()->route('login');
  }

  /**Diret to register page */
  public function register(){
      return view('register');
  }

//   public function auth(Request $request){
//     $username = $request->get('email');
//     $password = $request->get('password');

//     $response = $this->api->getTokenAuth($username, $password);
    
//     if($response->status == "OK") {

//         try {
//             $token_acesso = $response->TokenAutenticacao;
//             $frUsuario = FrUsuario::where('token_acesso', $token_acesso )->first();

//             $user = new User();
//             $user->name  = $frUsuario->usr_nome;
//             $user->username  = $frUsuario->usr_login;
//             $user->email = $frUsuario->usr_email;
//             $user->password = Hash::make($frUsuario->usr_senha); 
            
//             Auth::login($user);
//             // return redirect()->route('welcome'); 
//             return view('welcome');

//         } catch (Exception $e) {
//             return redirect()->back()->with(['message'=> $e->getMessage()]);
//         }
         
//     }
//     else {
//         return redirect()->back()->with(['message'=> $response->Mensagem]);
//     }

//   }

  public function auth(Request $request ){

      $data =
      [
          'email' => $request->get('email'),
          'password' => $request->get('password'),
      ];

      try {
          if(env('PASSWORD_HASH')){
              Auth::attempt($data, false);
          }else{
              $user = User::where('email', $request->email)->first();
              if(!$user){
                  throw new Exception("Email inválido");
                  return redirect()->back()->with(['message'=> "Email inválido"]);
              }
              if($user->password != $request->get('password')){
                  throw new Exception("Senha inválida");
              }

              Auth::login($user);
              return redirect()->route('welcome');
          }
      } catch (Exception $e) {
          //throw $th;
          return redirect()->back()->with(['message'=> $e->getMessage()]);
      }

  }
}
