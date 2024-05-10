<?php

namespace  App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\User;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\po_product;
use App\Models\vendor_po;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Datatables;

class VendorPoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    //
    public function index($status){
        $vendor_pos='';
        if($status!='All'){
            $vendor_pos=vendor_po::where('status',$status)->get();
        }else {
            $vendor_pos=vendor_po::all();
        }
        return view('admin.vendor_po.index');
    }
    public function details()
    {
        $po = vendor_po::find(request()->id);
        return view('admin.vendor_po.details',compact('po'));
    }

    public function create_po()
    {
       $vendors= User::where('is_vendor',2)->get();
        return view('admin.vendor_po.vender_po',compact('vendors'));
    }
    public function add(Request $request){
        // dd($request->all());
        DB::beginTransaction();
        try {
            $vendor_id = request()->vendor;
            $orders = Order::where('status','processing')->get();
        //  dd($orders);
         $items = [];
         foreach($orders as $order)
         {
            //  dd($order->order_items);
            foreach($order->order_items as $item)
            {
                if($item->vendor_id == $vendor_id)
                {
                    array_push($items,$item);
                }
            }
         }
         $vpo = new vendor_po;
         $vpo->po_number = $this->po_no();
         $vpo->vendor_id = $vendor_id;
         $vpo->total_amount = 0;
         $vpo->save();
         $totalAmount=0;
         foreach($items as $item)
         {
            $poitem = new po_product;
            $poitem->vendor_pos_id = $vpo->id;
            $poitem->order_no = $item->order->order_number;
            $poitem->product_sku = $item->product->sku;
            $poitem->product_name = $item->product->name;
            $poitem->size = $item->size;
            $poitem->color = $item->color;
            $poitem->quantity = $item->qty;
            $poitem->amount = $item->vendor_amount;
            $totalAmount += $poitem->amount;
            $poitem->save();
         }
         $vpo = vendor_po::find($vpo->id);
         $vpo->total_amount = $totalAmount;
         $vpo->save();
            DB::commit();
        } catch (\Exception $th) {
            //throw $th;
            dd($th);
            DB::rollBack();
        }
        $msg = 'New Data Added Successfully.';
        return response()->json($msg);
    }
    public function po_no()
    {
        $last = vendor_po::latest()->first();
        if($last != null)
        {
            $last_no = $last->po_number;
            $po_no = $last_no + 1;
            return $po_no;
        }
        else{
            return 500000;
        }
    }
    public function getVendorProduct($id){
        $prod = Product::where('vendor_id',$id)->get();
        return   View('admin.vendor_po.partials._products',compact('prod'))->render();
    }
    public function getVendorItem($id)
    {
         $orders = Order::where('status','processing')->get();
        //  dd($orders);
         $items = [];
         foreach($orders as $order)
         {
            //  dd($order->order_items);
            foreach($order->order_items as $item)
            {
                if($item->vendor_id == $id)
                {
                    array_push($items,$item);
                }
            }
         }
         return View('admin.vendor_po.partials.vender_po_td',compact('items'))->render();
    }
  //*** JSON Request
  public function datatables($status)
  {

        $datas = vendor_po::orderBy('created_at','desc')->get();
       //--- Integrating This Collection Into Datatables
       return Datatables::of($datas)
                        ->editColumn('po_number', function(vendor_po $data) {
                            return $data->po_number;
                            })
                        ->editColumn('vendor', function(vendor_po $data) {
                            return $data->vendor->shop_name;
                            })
                        ->editColumn('amount', function(vendor_po $data) {
                            return $data->total_amount;
                            })
                        ->editColumn('date', function(vendor_po $data) {
                            return $data->created_at;
                            })
                          ->addColumn('action', function(vendor_po $data) {
                              return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('po_details',$data->id) . '" > <i class="fas fa-eye"></i> Details</a></div></div>';
                          })
                          ->rawColumns(['po_number','vendor','amount','date','action'])
                          ->toJson(); //--- Returning Json Data To Client Side
  }

}
