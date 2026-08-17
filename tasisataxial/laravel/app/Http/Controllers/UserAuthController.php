<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;
// use Kavenegar;
use App\Models\User;
use App\Models\event_place;
use App\Models\view;
use App\Self\Alert;
use Mockery\Generator\StringManipulation\Pass\Pass;

class UserAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function login(){
        if(Auth::user()){
            if(Auth::user()->role_as==1 || Auth::user()->role_as==0){
                return redirect("admin/dashboard");
            }else{
                return redirect("user/dashboard");
            }
            
         }else{

            return view("login");
        }
    }

    public function logout(){
        Auth::logout();
        return redirect("/");
    }

    public function check(Request $request){
        $credentials =$request->validate([
            'username'=>'required|min:3',
            'password'=>'required|min:6'
        ],
        [
            'username.required'=>'این فیلد اجباری است',
            'username.min'=>'بیشتر از 3 کاراکتر باید باشد',
            'password.required'=>'این فیلد اجباری است',
            'password.min'=>'حداقل 6 کاراکتر'
        ]);

        
        if (request()->getMethod() == 'POST') {
            $rules = ['captcha' => 'required|captcha'];
            $validator = validator()->make(request()->all(), $rules);
            if ($validator->fails()) {
                Alert::message("error","تصویر امنیتی اشتباه است","error")->show();
                return redirect("/login");
            }
        }
        
        
        if(isset($request->remember)){
            
            $remember=true;
        }else{
            $remember=false;
        }
        
        // dd($credentials);
        // dd(Auth::attempt($credentials));
        if(Auth::attempt($credentials) || Auth::attempt(['phone_number'=>$request->username,'password'=>$request->password])){
            
            $user=User::where('phone_number',$request->username)->orWhere('username',$request->username)->first();
            
            if(Hash::check($request->password,$user->password)){
             $request->session()->regenerate();
             $request->session()->put("loggedUser",$user->id);
             if($user->role_as==1 || $user->role_as==0){
                 return redirect("admin/dashboard");
             }else{
                 return redirect("user/dashboard");
             }
         }
       }else{
         Alert::message("error","نام کاربری یا رمز عبور اشتباه است","error")->show();
         return redirect("/login");
       }

 }

    public function smsCode(Request $request){

        $this->validate($request,["phone_number"=>"required|digits:11|unique:users"],[
            'phone_number.required'=>'این فیلد اجباری است',
            'phone_number.digits'=>'تعداد 11 رقم باید باشد',
            'phone_number.unique'=>''
        ]);

        $phone_number=$request->phone_number;
        $rndNumber=rand(10000,99999);
        // $this->sendSms($phone_number,"کد تایید شما  : ".$rndNumber);
     
        return view("user.confirmCode",compact(['phone_number','rndNumber']));
    }

    // public function sendSms($phone_number,$rndNumber){
    //         // enter API KEY into config/kavenegar

    //         try{
    //             $sender = "10008663";		//This is the Sender number
            
    //             $message =  "سیستم گزارش خطای بیمارستان رسول اکرم- ". "می باشد".$rndNumber." کد تایید شما  ";		//The body of SMS
    //             $message=$message;
            
    //             $receptor = array($phone_number);			//Receptors numbers
            
    //             $result = Kavenegar::Send($sender,$receptor,$message);
    //             if($result){
    //                 foreach($result as $r){
    //                     echo "messageid = $r->messageid";
    //                     echo "message = $r->message";
    //                     echo "status = $r->status";
    //                     echo "statustext = $r->statustext";
    //                     echo "sender = $r->sender";
    //                     echo "receptor = $r->receptor";
    //                     echo "date = $r->date";
    //                     echo "cost = $r->cost";
    //                 }
    //             }
    //         }
    //         catch(\Kavenegar\Exceptions\ApiException $e){
    //             // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
    //             echo $e->errorMessage();
    //         }
    //         catch(\Kavenegar\Exceptions\HttpException $e){
    //             // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
    //             echo $e->errorMessage();
    //         }
    // }

    public function confirmcode(Request $request,$rndNumber)
    {
       
        $this->validate($request,['confirmCode'=>"required|digits:5"],[
            'confirmCode.required'=>"این فیلد الزامی است",
            'confirmCode.digits'=>" تعداد 5 رقم است !"
        ]);
      if($request->confirmCode == $rndNumber){
          $phone_number=$request->phone_number;
          Session::put("phoneNumber",$phone_number);
         return redirect()->route("user.create");
      }else{
          Alert::message("error","کد تایید اشتباه است","error")->show();
          return back();
      }
 
    }
 
    public function register(){

        return view("mobile");
    }

    public function forgetForm(){
       
        return view("user.forgetForm");
    }


    public function forgetCode(Request $request){
        $this->validate($request,["phone_number"=>"required"]);
        $user=User::where('phone_number',$request->phone_number)->first();
        if($user){
            session()->put("username",$user->username);
            $rndNumber=rand(10000,99999);
            return view("user.forgetConfirmCode",compact(['rndNumber']));
        }else{
            Alert::message("error","شماره تلفن وجود ندارد","error")->show();
            return back();
        }
    
    } 

    public function forgetConfirmCode(Request $request,$rndNumber){
        $this->validate($request,['confirmcode'=>"required|digits:5"],[
            'confirmCode.required'=>"این فیلد الزامی است",
            'confirmCode.digits'=>" تعداد 5 رقم است !"
        ]);
        if($request->confirmcode == $rndNumber){
            return redirect()->route("passwordForm");
        }else{
            Alert::message("error","کد تایید اشتباه است","error")->show();
            return back();
        }


    }

    public function passwordForm(){
        $username=session()->get("username");
        $user=User::where('username',$username)->first();
        $user_id=$user->id;
        return view("user.resetPassword",compact(['username','user_id']));
    }

    public function resetPassword(Request $request,User $user){
        $this->validate($request,[
            
            "password"=>['required','confirmed',Password::min(8)->letters()->numbers()],
        ],[
            'password.required'=>"این فیلد الزامی است",
            'password.min'=>"حداقل 8 کاراکتر",
            'password.confirmed'=>"پسورد ها یکی نیستند", 
        ]);
        $password=Hash::make($request->password);
        $update_items=['password'=>$password];
        if($user->update($update_items)){
                Alert::message("success","رمز عبور تغییر یافت","success")->show();
                $request->session()->put("loggedUser",$user->id);
                Auth::loginUsingId($user->id,true);
                if($user->role_as==1 || $user->role_as==0){
                    return redirect("admin/dashboard");
                }else{
                    return redirect("user/dashboard");
                }
            }else{
                Alert::message("error","مشکل در تغییر رمز","error")->show();
                return back();
            }

    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view("user.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        
        $this->validate($request,[
            "firstName"=>"required|string|min:3",
            "lastName"=>"required|string|min:3",
            "phoneNumber"=>"required",
            "email"=>"nullable|unique:users",
            "username"=>"unique:users|required|min:5",
            "password"=>['required','confirmed',Password::min(8)->letters()->numbers()],
        ],[
            'firstName.required'=>"این فیلد الزامی است",
            'firstName.min'=>"حداقل 3 کاراکتر",
            'lastName.required'=>"این فیلد الزامی است",
            'lastName.min'=>"حداقل 3 کاراکتر",
            'username.required'=>"این فیلد الزامی است",
            'username.min'=>"نام کاربری 5 کاراکتر",
            'username.unique'=>"این نام کاربری قبلا ثبت شده است!",
            'email.email'=>"ایمیل درست نیست",
            'email.unique'=>"این ایمیل قبلا ثبت شده است",


            'password.required'=>"این فیلد الزامی است",
            'password.min'=>"حداقل 8 کاراکتر",
            'password.confirmed'=>"پسورد ها یکی نیستند",

         
            
        ]);
        $firstName=$request->old('firstName');
        $lastName=$request->old('lastName');
        $phoneNumber=$request->old('phoneNumber');
        $email=$request->old('email');
        $username=$request->old("username");

        $user=new User;
        $user->firstName=$request->firstName;
        $user->lastName=$request->lastName;
        $user->username=$request->username;
        $user->phone_number=$request->phoneNumber;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->gender=$request->gender;
        $user->role_as=4;
        $user->address=$request->address;
        $query=$user->save();

        if($query){
            Alert::message("success","ثبت نام با موفقیت انجام شد","success")->show();
            $request->session()->put("loggedUser",$user->id);
            Auth::loginUsingId($user->id,true);
            return redirect()->route('user.dashboard');
        }else{
            Alert::message("error","ثبت نام انجام نشد","error")->show();
            return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
