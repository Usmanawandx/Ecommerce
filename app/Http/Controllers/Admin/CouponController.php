<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Carbon\Carbon;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\Childcategory;
use App\Models\coupons_sku;
use App\Models\Product;
use App\Models\User;
use Cartalyst\Stripe\Api\Products;
use Validator;

class CouponController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
         $datas = Coupon::orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('type', function(Coupon $data) {
                                $type = $data->type == 0 ? "Discount By Percentage" : "Discount By Amount";
                                return $type;
                            })
                            ->editColumn('brands_id', function(Coupon $data) {
                                $brand= (isset($data->brands->name)?$data->brands->name:'');
                                return $brand;
                            })
                            ->editColumn('childcategories_id', function(Coupon $data) {
                                $cc=(isset($data->childcategories->name)?$data->childcategories->name:'');
                                return $cc;
                            })
                            ->editColumn('users_id', function(Coupon $data) {
                                $ui=(isset($data->users->name)?$data->users->name:'');
                                return $ui;
                            })
                            ->editColumn('price', function(Coupon $data) {
                                $price = $data->type == 0 ? $data->price.'%' : $data->price.'$';
                                return $price;
                            })
                            ->addColumn('status', function(Coupon $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-coupon-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-coupon-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            })
                            ->addColumn('action', function(Coupon $data) {
                                return '<div class="action-list"><a href="' . route('admin-coupon-edit',$data->id) . '"> <i class="fas fa-edit"></i>Edit</a><a href="javascript:;" data-href="' . route('admin-coupon-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                            })
                            ->rawColumns(['status','action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.coupon.index');
    }

    //*** GET Request
    public function create()
    {
        $brand=Brands::all();
        $vendor=User::where('is_vendor','<>',0)->get();
        $child=Childcategory::all();
        $prod=Product::where('sku','<>',null)->get();
        return view('admin.coupon.create',compact('brand','vendor','child','prod'));
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = ['code' => 'unique:coupons'];
        $customs = ['code.unique' => 'This code has already been taken.'];
        $validator = Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Coupon();
        $input = $request->all();
        $input['start_date'] = Carbon::parse($input['start_date'])->format('Y-m-d');
        if ($request->has('sku')) {
           unset( $input['sku']);
        //    dd( $input);
        }
        $input['end_date'] = Carbon::parse($input['end_date'])->format('Y-m-d');
        // dd($input);
        $data->fill($input)->save();
if($request->has('sku')){
    foreach ($request->sku as $key => $value) {
        $c_sku= new coupons_sku;
        $c_sku->coupons_id=$data->id;
        $c_sku->sku=$value;
        $c_sku->save();
    }
}

        //--- Logic Section Ends

        //--- Redirect Section
        $msg = 'New Data Added Successfully.'.'<a href="'.route("admin-coupon-index").'">View Coupon Lists</a>';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request
    public function edit($id)
    {
        $brand=Brands::all();
        $vendor=User::where('is_vendor','<>',0)->get();
        $child=Childcategory::all();
        $data = Coupon::findOrFail($id);
        $prod=Product::where('sku','<>',null)->get();
        $sku=$data->coupons_sku()->get();
        // dd($sku->where('sku','Hydraulic Kitchen Wand Brush')->all());
                // dd($data);
        return view('admin.coupon.edit',compact('data','brand','vendor','child','prod','sku'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section

        $rules = ['code' => 'unique:coupons,code,'.$id];
        $customs = ['code.unique' => 'This code has already been taken.'];
        $validator = Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = Coupon::findOrFail($id);
        $input = $request->all();
        $input['start_date'] = Carbon::parse($input['start_date'])->format('Y-m-d');
        $input['end_date'] = Carbon::parse($input['end_date'])->format('Y-m-d');
        if ($request->has('sku')) {
            unset( $input['sku']);
         //    dd( $input);
         }
        $data->update($input);
        $sku=$data->coupons_sku;
        if(count($sku)>0){
            foreach ($data->coupons_sku as  $value) {
               $value->delete();
            }
            // $data->coupons_sku->delete();
        }
        //--- Logic Section Ends
        if ($request->has('sku')) {
            foreach ($request->sku as $key => $value) {
                $c_sku= new coupons_sku;
                $c_sku->coupons_id=$data->id;
                $c_sku->sku=$value;
                $c_sku->save();
            }
        }

        //--- Redirect Section
        $msg = 'Data Updated Successfully.'.'<a href="'.route("admin-coupon-index").'">View Coupon Lists</a>';
        return response()->json($msg);
        //--- Redirect Section Ends
    }
      //*** GET Request Status
      public function status($id1,$id2)
        {
            $data = Coupon::findOrFail($id1);
            $data->status = $id2;
            $data->update();
        }


    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Coupon::findOrFail($id);
        $data->delete();
        //--- Redirect Section
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }
}
