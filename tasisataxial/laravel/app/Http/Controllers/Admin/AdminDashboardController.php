<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\order;
use App\Models\order_detail;
use App\Models\product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\view;
use App\Self\Alert;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\DB;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // if(Auth::user()->role_as == 0){
        //     Auth::logout();
        //    return redirect()->route("login");
        // }


  
        $v=verta();
            for ($i=1; $i <= 12 ; $i++) {
                $date=$v->jalaliToGregorian("1403",$i,"1");
                $fromDate=implode("-",$date);
                if($i<=6){
                    $date=$v->jalaliToGregorian("1403",$i,"31");
                    $toDate=implode("-",$date) ;
                }else{
                    $date=$v->jalaliToGregorian("1403",$i,"30");
                    $toDate=implode("-",$date);
                } 

                $result=DB::table("views")->whereBetween("created_at",[$fromDate ." 00:00:00" ,$toDate . " 23:59:59"])->get();
                $data[]=count($result);
            }

                $dates=["فروردین","اردیهشت","خرداد","تیر","مرداد","شهریور","مهر","آبان","آذر","دی","بهمن"," اسفند"];
                $data=json_encode($data);
                $dates=json_encode($dates);

                $views=count(DB::table("views")->get());
            
 
       return view("admin.dashboard",compact(["views","dates","data"]));
    }


    public function users(){
        $users=User::where("role_as",">",0)->paginate(20);

        return view('admin.users',compact(['users']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    //    dd($event_places);
       return view("admin.userCreate");
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
            "username"=>"required|string|min:3|unique:users",
            "phoneNumber"=>"required|unique:users,phone_number",
            "email"=>'email|unique:users',
            "password"=>'required|min:8|confirmed',
            // "event_place"=>'required|min:1',
        
        ],[
            'firstName.required'=>"این فیلد الزامی است",
            'firstName.min'=>"حداقل 3 کاراکتر",
            'lastName.required'=>"این فیلد الزامی است",
            'lastName.min'=>"حداقل 3 کاراکتر",
            'username.required'=>"این فیلد الزامی است",
            'username.min'=>"کد ملی 3 کاراکتر",
            'username.unique'=>"نام کاربری قبلا ثبت شده است!",
            // 'email.required'=>"این فیلد الزامی است",
            'phoneNumber.required'=>"این فیلد الزامی است",
            'phoneNumber.unique'=>"تلفن قبلا ثبت شده است!",

            'email.email'=>"ایمیل درست نیست",
            'email.unique'=>"این ایمیل قبلا ثبت شده است!",
            'password.required'=>"این فیلد الزامی است",
            'password.min'=>"حداقل 8 کاراکتر",
            'password.confirmed'=>"رمز عبور و تکرار رمز یکسان نیست!",
            // 'event_place.required'=>"این فیلد الزامی است"
           

        ]);


        $firstName=$request->old('firstName');
        $lastName=$request->old('lastName');
        $username=$request->old('username');
        $phoneNumber=$request->old('phoneNumber');
        $email=$request->old('email');
        

        $user=new User;
        $user->firstName=$request->firstName;
        $user->lastName=$request->lastName;
        // $user->meli_code=$request->meli_code;
        $user->phone_number=$request->phoneNumber;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->gender=$request->gender;
        $user->username=$request->username;
        $user->role_as=4;
        $query=$user->save();

        if($query){
            Alert::message("success","ثبت نام با موفقیت انجام شد","success")->show();
            return back();
        }else{
            Alert::message("error","ثبت نام انجام نشد","error")->show();
            return back();
        }

    }


    public function orderPrint(){
        $products=session('products');
        $orders=session('orders');
        $myorder=session('myorder');
        session()->reflash();
        // dd(session()->all());
        return view("admin.orderPrint",compact(['products','orders','myorder']));
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

    public function orders(){
        if(Auth::user()->role_as<=1){
            
            $orders=DB::table("orders")->select(["orders.*","users.firstName","users.lastName"])->leftJoin('users','orders.user_id','=','users.id')->orderBy('orders.id',"desc")->paginate(15);
        }else{
            $orders=DB::table("orders")->select(["orders.*","users.firstName","users.lastName"])->leftJoin('users','orders.user_id','=','users.id')->where('users.id',Auth::user()->id)->orderBy('orders.id',"desc")->paginate(15);

        }
        // dd($orders);
        return view('admin.orders',compact(['orders']));
    }


    public function search(Request $request){
        $this->validate($request,[
            'search'=>"required"
        ],['search.required'=>"این فیلد اجباری است"]);


        $orders=DB::table('orders')->leftJoin("users",'orders.user_id',"=","users.id")->where('referenceId',$request->search)->orWhere('lastName','LIKE',"%$request->search%")->orWhere('firstName','LIKE',"%$request->search%")->paginate(15);
        // dd($orders);
        return view('admin.orders',compact(['orders']));


    }


    public function details(order $order){
        $products=[];
        $myorder=DB::table('orders')->leftJoin('users',"orders.user_id","=","users.id")->where('orders.id',$order->id)->first();
        $orders=order_detail::where("order_id",$order->id)->get();
        // dd($orders);
        foreach ($orders as $key=>$thisOrder){
            $products[$key]=product::where("id",$thisOrder->product_id)->first();
        }

        session()->flash("products",$products);
        session()->flash("orders",$orders);
        session()->flash("myorder",$myorder);
        return view('admin.order_detail',compact(['myorder','products','orders']));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $user)
    {
        // dd($request->input("action"));
        switch($request->input("action")){
            case 'role':
                $edit_items=['role_as'=>$request->access];
                $res=$user->update($edit_items);
                
                if($res){
                    Alert::message('success','کاربر ویرایش شد',"success")->show();
                    return back();
                }else{
                    Alert::message('error','ویرایش انجام نشد',"error")->show();
                    return back();
                }
            break;
            case null:
                $res=$user->delete();
                if($res){
                    Alert::message('success','کاربر حذف شد',"success")->show();
                    return back();
                }else{
                    Alert::message('error','حذف انجام نشد',"error")->show();
                    return back();
                }
            break;

        }
      

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
