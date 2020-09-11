<?php

namespace App\Http\Controllers;

use App\Models\PasswordSecurity;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;

class PasswordSecurityController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
         $user=\Auth::user();
         $secret='';
         $google2fa_url='';
         if($user->password_security()->exists()){
         $google2fa=new \PragmaRX\Google2FAQRCode\Google2FA();
         $google2fa_url=$google2fa->getQRCodeInline(
             'Testing 2FA',
              $user->email,
             $user->password_security->google2fa_secret
         );
         $secret=$user->password_security->google2fa_secret;
         }

         $data= array('google2fa_url' => $google2fa_url,'google2fa_secret'=>$secret,'user'=>$user);
        return view('google2fa',compact('data'));
    }
    public function generate(){
         $user=\Auth::user();
         $google2fa=new \PragmaRX\Google2FAQRCode\Google2FA();
         $passwordsecurity=PasswordSecurity::firstOrNew(['user_id'=>$user->id]);
          $passwordsecurity->user_id=$user->id;
          $passwordsecurity->google2fa_enable=0;
          $passwordsecurity->google2fa_secret=$google2fa->generateSecretKey();
          $passwordsecurity->save();
          return redirect()->route('2fa')->with('message','Successfully generated key');
    }
    public function enable2fa(Request $request){
                             $user=\Auth::user();
                             $google2fa=new \PragmaRX\Google2FAQRCode\Google2FA();
                             $request->validate(['verify_code'=>'required']);
                             $secret=$request->verify_code;
                             $verify=$google2fa->verifyKey($user->password_security->google2fa_secret,$secret);
                                    if($verify) {
                                    $passwordsecurity=$user->password_security;
                                    $passwordsecurity->google2fa_enable=1;
                                    $passwordsecurity->save();
                                    return redirect()->route('2fa')->with('message','Your 2FA has been successfully enabled');
                                    }
                                    return redirect()->route('2fa')->with('message','Incorrect Key ... Please Try again');
}
public function disable2fa(){
       $user=\Auth::user();
//       $user->password_security->google2fa_enable=0;
      $password2fa=$user->password_security;
       $password2fa->delete();

       return redirect()->route('2fa')->with('message','Your two factor authentication has been disabled');
}
}
