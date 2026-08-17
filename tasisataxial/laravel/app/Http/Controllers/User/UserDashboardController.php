<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\view;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Self\Alert;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $firstName=Auth::user()->firstName;
        $lastName=Auth::user()->lastName;
        $username=Auth::user()->username;
        $phone_number=Auth::user()->phone_number;
        $address=Auth::user()->address;
        $id=Auth::user()->id;
        // dd(session()->all());
        $price=session('pay.totalprice');
        return view("user.dashboard",compact(['firstName','lastName','username','phone_number','address','price','id']));
    }

    public function users(){
        $users=user::where("role_as",4)->get();
        return view("admin.users",compact(["users"]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // return view("admin.userCreate");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request,[
        //     "firstName"=>"required|string|min:3",
        //     "lastName"=>"required|string|min:3",
        //     "phone_Number"=>"required|unique:users",
        //     "email"=>'string|email|nullable',
        //     "password"=>'required|min:8|confirmed'
        // ],[
        //     'firstName.required'=>"این فیلد الزامی است",
        //     'firstName.min'=>"حداقل 3 کاراکتر",
        //     'lastName.required'=>"این فیلد الزامی است",
        //     'lastName.min'=>"حداقل 3 کاراکتر",
        //     'email.required'=>"این فیلد الزامی است",
        //     'email.email'=>"ایمیل درست نیست",
        //     'email.unique'=>"این ایمیل قبلا ثبت شده است!",
        //     'password.required'=>"این فیلد الزامی است",
        //     'password.min'=>"حداقل 8 کاراکتر",
        //     'password.confirmed'=>"رمز عبور و تکرار رمز یکسان نیست!",
        //     'phone_Number.unique'=>"این شماره قبلا ثبت شده است"
        // ]);
        //     $firstName=$request->old('firstName');
        //     $lastName=$request->old('lastName');
        //     $phone_Number=$request->old('phone_Number');
        //     $email=$request->old('email');

        //     $user=new User;
        //     $user->firstName=$request->firstName;
        //     $user->lastName=$request->lastName;
        //     $user->phone_number=$request->phone_Number;
        //     $user->email=$request->email;
        //     $user->password=Hash::make($request->password);
            
        //     if($user->save()){
        //         Alert::message("success","ثبت نام با موفقیت انجام شد","success")->show();
        //         return back();

        //     }else{
        //         Alert::message("error","ثبت نام انجام نشد","error")->show();
        //         return back();
        //     }


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
    public function edit(user $user)
    {
      
        return view('admin.user',compact(['user']));
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {

        // dd($request);
        $this->validate($request,[
            "firstName"=>"required|string|min:3",
            "lastName"=>"required|string|min:3",
            "phone_number"=>"required|unique:users,id,".$user->id,
            "email"=>'nullable|email|unique:users,id,'.$user->id,
            "username"=>"required|unique:users,id,".$user->id,
            'address'=>'required|min:10'
            
        ],[
            'firstName.required'=>"این فیلد الزامی است",
            'firstName.min'=>"حداقل 3 کاراکتر",
            'lastName.required'=>"این فیلد الزامی است",
            'lastName.min'=>"حداقل 3 کاراکتر",
            'email.email'=>"ایمیل درست نیست",
            'email.unique'=>"این ایمیل قبلا ثبت شده است!",
            'phone_number.required'=>"این فیلد الزامی است",
            'phone_number.unique'=>"این شماره قبلا ثبت شده است",
            'address.required'=>"آدرس الزامی است",
            'address.min'=>" آدرس حداقل 10 کاراکتر ",
        ]);

        session()->put('pay.desc',$request->desc);
        $update_items=[];
        $update_items=[
            'firstName'=>$request->firstName,
            'lastName'=>$request->lastName,
            'phone_number'=>$request->phone_number,
            'address'=>$request->address
        ];


        if($request->password){
            $this->validate($request,["password"=>'required|min:8|confirmed'],
            [
                'password.required'=>"این فیلد الزامی است",
                'password.min'=>"حداقل 8 کاراکتر",
                'password.confirmed'=>"رمز عبور و تکرار رمز یکسان نیست!",
            ]);
            $update_items['password']=Hash::make($request->password);
        }

        // dd($update_items);


        if($user->update($update_items)){
            Alert::message("success","بروز رسانی انجام شد","success")->show();
            // dd(session()->all());
            if(session('inPayment')){
                $card=json_encode(session('card'), JSON_UNESCAPED_UNICODE);
                return redirect('/payment');
            }else{
                // dd(session('card'));   
                return redirect()->route('home');
            }
        }else{
            Alert::message("error","بروز رسانی انجام نشد","error")->show();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        $user->delete();
        Alert::message("success","کاربر با موفقیت حذف شد","success")->show();

    }
}
