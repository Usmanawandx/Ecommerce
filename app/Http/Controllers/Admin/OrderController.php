<?php

namespace App\Http\Controllers\Admin;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Childcategory;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTrack;
use App\Models\User;
use App\Models\Product;
use App\Models\VendorOrder;
use Datatables;
use PDF;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function create_po()
    {
       $vendors= User::where('is_vendor','<>',0)->get();
        $prod = Product::all();
        return view('admin.order.vender_po',compact('prod','vendors'));
    }

    //*** JSON Request
    public function datatables($status)
    {

        if(isset( $status)&&$status<>'none') {
            $datas = Order::where('status','=',$status)->get();
        }
        else{
          $datas = Order::orderBy('id','desc')->get();
        }

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('status',function(Order $data){
                                return $data->status;
                            })
                            ->editColumn('check',function(Order $data){
                                return '<input type="checkbox" name="checkbox[]" data-id="'.$data->id.'" class="check_status">';
                            })
                             ->editColumn('totalQty',function(Order $data){
                                $qty = 0;
                                foreach($data->order_items as $item)
                                {
                                    $qty += $item->qty;
                                }
                                return $qty;
                            })
                            ->editColumn('id', function(Order $data) {
                                $id = '<a href="'.route('admin-order-invoice',$data->id).'">'.$data->order_number.'</a>';
                                return $id;
                            })
                            ->editColumn('pay_amount', function(Order $data) {
                                return $data->currency_sign . round($data->pay_amount * $data->currency_value , 2);
                            })
                            ->addColumn('action', function(Order $data) {
                                $orders = '<a href="javascript:;" data-href="'. route('admin-order-edit',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-dollar-sign"></i> Delivery Status</a>';
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a><a href="javascript:;" class="send" data-email="'. $data->customer_email .'" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> Send</a><a href="javascript:;" data-href="'. route('admin-order-track',$data->id) .'" class="track" data-toggle="modal" data-target="#modal1"><i class="fas fa-truck"></i> Track Order</a>'.$orders.'<a href="javascript:;" data-href="'. route('admin-order-notes',$data->id) .'" class="notes" data-toggle="modal" data-target="#modal-note"><i class="fas fa-envelope"></i> order notes</a></div></div>';
                            })
                            ->rawColumns(['id','check','action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    public function index()
    {
        return view('admin.order.index');
    }

    public function edit($id)
    {
        $data = Order::find($id);
        return view('admin.order.delivery',compact('data'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {

        //--- Logic Section
        $data = Order::findOrFail($id);

        $input = $request->all();
        if ($data->status == "completed"){

        // Then Save Without Changing it.
            $input['status'] = "completed";
            $data->update($input);
            //--- Logic Section Ends


        //--- Redirect Section
        $msg = 'Status Updated Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends

            }else{
            if ($input['status'] == "completed"){

                foreach($data->vendororders as $vorder)
                {
                    $uprice = User::findOrFail($vorder->user_id);
                    $uprice->current_balance = $uprice->current_balance + $vorder->price;
                    $uprice->update();
                }

                if( User::where('id', $data->affilate_user)->exists() ){
                    $auser = User::where('id', $data->affilate_user)->first();
                    $auser->affilate_income += $data->affilate_charge;
                    $auser->update();
                }



                $gs = Generalsetting::findOrFail(1);
                if($gs->is_smtp == 1)
                {
                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order '.$data->order_number.' is Confirmed!',
                        'body' => "Hello ".$data->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.",
                    ];

                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($maildata);
                }
                else
                {
                   $to = $data->customer_email;
                   $subject = 'Your order '.$data->order_number.' is Confirmed!';
                   $msg = "Hello ".$data->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.";
                $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);
                }
            }
            if ($input['status'] == "declined"){

                $cart = unserialize(bzdecompress(utf8_decode($data->cart)));

                foreach($cart->items as $prod)
                {
                    $x = (string)$prod['stock'];
                    if($x != null)
                    {

                        $product = Product::findOrFail($prod['item']['id']);
                        $product->stock = $product->stock + $prod['qty'];
                        $product->update();
                    }
                }


                foreach($cart->items as $prod)
                {
                    $x = (string)$prod['size_qty'];
                    if(!empty($x))
                    {
                        $product = Product::findOrFail($prod['item']['id']);
                        $x = (int)$x;
                        $temp = $product->size_qty;
                        $temp[$prod['size_key']] = $x;
                        $temp1 = implode(',', $temp);
                        $product->size_qty =  $temp1;
                        $product->update();
                    }
                }



                $gs = Generalsetting::findOrFail(1);
                if($gs->is_smtp == 1)
                {
                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order '.$data->order_number.' is Declined!',
                        'body' => "Hello ".$data->customer_name.","."\n We are sorry for the inconvenience caused. We are looking forward to your next visit.",
                    ];
                $mailer = new GeniusMailer();
                $mailer->sendCustomMail($maildata);
                }
                else
                {
                   $to = $data->customer_email;
                   $subject = 'Your order '.$data->order_number.' is Declined!';
                   $msg = "Hello ".$data->customer_name.","."\n We are sorry for the inconvenience caused. We are looking forward to your next visit.";
                   $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);
                }

            }

            $data->update($input);

            if($request->track_text)
            {
                    $title = ucwords($request->status);
                    $ck = OrderTrack::where('order_id','=',$id)->where('title','=',$title)->first();
                    if($ck){
                        $ck->order_id = $id;
                        $ck->title = $title;
                        $ck->text = $request->track_text;
                        $ck->update();
                    }
                    else {
                        $data = new OrderTrack;
                        $data->order_id = $id;
                        $data->title = $title;
                        $data->text = $request->track_text;
                        $data->save();
                    }


            }


        $order = VendorOrder::where('order_id','=',$id)->update(['status' => $input['status']]);

         //--- Redirect Section
         $msg = 'Status Updated Successfully.';
         return response()->json($msg);
         //--- Redirect Section Ends

            }

        //--- Redirect Section
        $msg = 'Status Updated Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends

    }

    public function pending()
    {
        return view('admin.order.pending');
    }
    public function processing()
    {
        return view('admin.order.processing');
    }
    public function completed()
    {
        return view('admin.order.completed');
    }
    public function declined($status)
    {
        return view('admin.order.declined',compact('status'));
    }
    public function OrderListStatus($status)
    {

        return view('admin.order.declined',compact('status'));
    }
    public function show($id)
    {
        if(!Order::where('id',$id)->exists())
        {
            return redirect()->route('admin.dashboard')->with('unsuccess',__('Sorry the page does not exist.'));
        }
        $vendors = User::where('is_vendor','=',2)->orderBy('id','desc')->get();
        $order = Order::findOrFail($id);
        $cart = unserialize($order->cart);
        $prod=Product::all();
        $childCate=Childcategory::all();
        return view('admin.order.details',compact('order','cart','childCate','prod','vendors'));
    }
    public function invoice($id)
    {
        $order = Order::findOrFail($id);
        $cart = unserialize($order->cart);
        return view('admin.order.invoice',compact('order','cart'));
    }
    public function emailsub(Request $request)
    {
        $gs = Generalsetting::findOrFail(1);
        if($gs->is_smtp == 1)
        {
            $data = 0;
            $datas = [
                    'to' => $request->to,
                    'subject' => $request->subject,
                    'body' => $request->message,
            ];

            $mailer = new GeniusMailer();
            $mail = $mailer->sendCustomMail($datas);
            if($mail) {
                $data = 1;
            }
        }
        else
        {
            $data = 0;
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
            $mail = mail($request->to,$request->subject,$request->message,$headers);
            if($mail) {
                $data = 1;
            }
        }

        return response()->json($data);
    }

    public function printpage($id)
    {
        $order = Order::findOrFail($id);
        $cart = unserialize($order->cart);
        return view('admin.order.print',compact('order','cart'));
    }

    public function license(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $cart->items[$request->license_key]['license'] = $request->license;
        $order->cart = utf8_encode(bzcompress(serialize($cart), 9));
        $order->update();
        $msg = 'Successfully Changed The License Key.';
        return response()->json($msg);
    }
    public function updateStatus()
    {
        $status = request()->orderStatus;
        $data = request()->id;
        foreach ($data as $id) {
            $order = Order::findOrFail($id);
            $order->status = $status;
            $order->save();
        }
        return response()->json('Order Status Updated Successfully');
    }
    public function itemEdit()
    {
        $id = request()->id;
        $order_item = OrderItem::find($id);
        $order_item->vendor_id = request()->vendor;
        $order_item->vendor_amount = request()->vendor_amount;
        $order_item->admin_commission = request()->admin_commission;
        $order_item->save();
        return response('200');
    }
}
