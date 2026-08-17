<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\order_detail;
use App\Self\Alert;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use Illuminate\Support\Facades\Auth;
use Kavenegar;
use Kavenegar\KavenegarApi;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;

class cartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $card=session('card');
        $cardjson=json_encode($card);
        return view("card",compact(['card','cardjson']));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request,['qty'=>"required|numeric|min:0|max:750"],[
            "qty.required"=>'این فیلد الزامی است',
            'qty.numeric'=>'مقدار،عددی باشد ',
            'qty.min'=>'حداقل تعداد 250گرم باشد ',
            'qty.max'=>'حداکثر تعداد 750 باشد'
        ]);
        $qty=$request->qty /1000;

        if($qty<=0.1){
            $qty=$qty*1000;
        }

        session()->put("card.$request->product_id",["qty"=>$qty,"price"=>$request->product_price]);


        return back();
    }

    public function paycard(Request $card){
        // dd($card['items']);
        $toalPrice=0;
        // $card=json_decode($card);
        // session()->put("card",);

        session()->forget('card');
        
        foreach($card['items'] as $key=>$item){
         
            $total=$item['qty']*$item['price'];
            $key=$item['id'];
            session()->put("card.$key",['qty'=>$item['qty'],'price'=>$item['price'],'total'=>$total]);
            $toalPrice+=$total;
        }

        
        session()->put('pay.totalprice',$toalPrice);
        return response()->json("ok");
    }


    public function payment(){
        
        if(!Auth::user()){
            session()->put("inPayment",true);
            return redirect()->route('login');
        }
        
   
        $invoice = new Invoice;

        $invoice->amount(session()->get('pay.totalprice'));
        // $invoice->amount(10000);
        $invoice->detail(['detailName' => 'your detail goes here']);

            $user = Auth::user();
            $paymentId = md5(uniqid());

            $callbackUrl=route("verification");    
            $payment = \Shetabit\Payment\Facade\Payment::callbackUrl($callbackUrl);
            $payment->purchase($invoice, function ($driver, $transactionId) {
  
            });
        
          return $payment->pay()->render();


    }


    public function verification(){
        

        try {
        $receipt = Payment::amount(session()->get('pay.totalprice'))->transactionId(session()->get('transactionId'))->verify();

        // You can show payment referenceId to the user.
        echo $receipt->getReferenceId();
        $status="OK" ;   
        } catch (InvalidPaymentException $exception) {
            
                // when payment is not verified, it will throw an exception.
                // We can catch the exception to handle invalid payments.
                // getMessage method, returns a suitable message that can be used in user interface.
            $status="FAILED";
            echo $exception->getMessage();
        }


        return redirect()->route('paymentStore',['refId'=>$receipt->getReferenceId(),'status'=>$status]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(session('card'));
        $card=session('card');
        $order=new order();

        $order->count=count($card);
        $order->price=session('pay.totalprice');
        $order->referenceId=$request->refId;
        $order->status=$request->status;
        // $order->description="test";
        $order->user_id=Auth::user()->id;
        if($order->save()){
            foreach ($card as $key=>$item){
                  $order_detail=new order_detail();
                  $order_detail->order_id=$order->id;
                  $order_detail->product_id=$key;  
                  $order_detail->qty=$item['qty'];
                  $order_detail->price=$item['total'];
                  $order_detail->save();
            }

           
            return $this->sendSms(Auth::user()->phone_number,$order->id,session('pay.totalprice'));
        }else{
            Alert::message("error","سفارش ثبت نشد","error")->show();
        
        }
    }


    public function sendSms($number,$orderId,$price){
            $kavenegar = new KavenegarApi('4B776D5359437550394544567034424B4C4339684739686C372F2F42592B36755241547A527144485A4E4D3D');
            try{
                $sender = "1000689696";		//This is the Sender number
            
                $message = "سفارش شما با موفقیت ثبت شد 
                شماره سفارش : $orderId
                مبلغ: $price
                ";		//The body of SMS
            
                $receptor = array($number,"09113393966");			//Receptors numbers
            
                $result = $kavenegar->Send($sender,$receptor,$message);
                if($result){
                    foreach($result as $r){
                        echo "messageid = $r->messageid";
                        echo "message = $r->message";
                        echo "status = $r->status";
                        echo "statustext = $r->statustext";
                        echo "sender = $r->sender";
                        echo "receptor = $r->receptor";
                        echo "date = $r->date";
                        echo "cost = $r->cost";
                    }
                }
            }
            catch(\Kavenegar\Exceptions\ApiException $e){
                // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
                echo $e->errorMessage();
            }
            catch(\Kavenegar\Exceptions\HttpException $e){
                // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
                echo $e->errorMessage();
            }catch(\Exceptions $ex){
            // در صورت بروز خطایی دیگر
                echo $ex->getMessage();
            }
            Alert::message("success","سفارش با موفقیت ثبت شد","success")->show();
            // dd(session()->all());
            return redirect()->route('cats',2);
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

        session()->forget("card.$id");
        return back();
        
    }


    public function emptycard(){
        session()->flush();
        return back();
    }
}
