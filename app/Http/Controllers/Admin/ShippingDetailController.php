<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Childcategory;
use App\Models\Currency;
use App\Models\Country;
use App\Models\ShippingDetail;
use App\Models\ShippingZone;
use Datatables;
use Illuminate\Http\Request;

use Validator;

class ShippingDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
         $datas = ShippingDetail::all();
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('child_category', function(ShippingDetail $data) {
                              return $data->child->name;
                            })
                            ->editColumn('zone', function(ShippingDetail $data) {
                              return $data->zone->name;
                            })
                            ->editColumn('price', function(ShippingDetail $data) {
                                $sign = Currency::where('is_default','=',1)->first();
                                $price = $data->price * $sign->value;
                                $price = $sign->sign.$price;
                                return  $price;
                            })
                            ->addColumn('action', function(ShippingDetail $data) {
                                return '<div class="action-list"><a data-href="' . route('admin-shipping-detail-edit',$data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>Edit</a><a href="javascript:;" data-href="' . route('admin-shipping-detail-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                            })
                            ->rawColumns(['action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.shippingdetail.index');
    }

    //*** GET Request
    public function create()
    {
        $childcategories = Childcategory::all();
        $zones = ShippingZone::all();
        $sign = Currency::where('is_default','=',1)->first();
        return view('admin.shippingdetail.create',compact('sign','childcategories','zones'));
    }

    //*** POST Request
    public function store(Request $request)
    {
        // //--- Validation Section
        // $rules = ['id' => 'unique:countries'];
        // $customs = ['id.unique' => 'This Country has already been taken.'];
        // $validator = Validator::make($request->all(), $rules, $customs);
        // if ($validator->fails()) {
        //   return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        // }
        // //--- Validation Section Ends

        //--- Logic Section
        $sign = Currency::where('is_default','=',1)->first();
        $data = new ShippingDetail;
        $data->child_id = $request->child_id;
        $data->zone_id = $request->zone_id;
        $data->price = $request->price;
        $data->save();
        // $input = $request->all();
        // $input['country'] = ($input['country']);
        // $input['weight'] = ($input['weight']);
        // $input['price'] = ($input['price'] / $sign->value);
        // $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = 'New Data Added Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request
    public function edit($id)
    {
        $childcategories = Childcategory::all();
        $zones = ShippingZone::all();
        $sign = Currency::where('is_default','=',1)->first();
        $data = ShippingDetail::findOrFail($id);
        return view('admin.shippingdetail.edit',compact('data','sign','childcategories','zones'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        // //--- Validation Section
        // $rules = ['title' => 'unique:shippings,title,'.$id];
        // $customs = ['title.unique' => 'This title has already been taken.'];
        // $validator = Validator::make($request->all(), $rules, $customs);

        // if ($validator->fails()) {
        //   return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        // }
        // //--- Validation Section Ends

        //--- Logic Section
        $sign = Currency::where('is_default','=',1)->first();
        $data = ShippingDetail::findOrFail($id);
        $data->child_id = $request->child_id;
        $data->zone_id = $request->zone_id;
        $data->price = $request->price;
        $data->save();
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }
public function exportCsv()
    {
        $fileName = 'Shipping.csv';
        $Shipping = ShippingDetail::all();
        ini_set('max_execution_time',10000);
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        $columns = array('id','child_id','zone_id','price');
        $callback = function() use($Shipping, $columns) {
            $file = fopen('php://output','w');
            fputcsv($file, $columns);
            foreach ($Shipping as $Ship) {
                fputcsv($file,array(
                    $Ship->id,
                    $Ship->child_id,
                    $Ship->zone_id,
                    $Ship->price,
                ));                    
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
    public function CsvGetColumnIndex($value,$header){
        $key=  array_search($value,$header);
        if(isset($key)&&$key+1!=false){
          return $key;
        }
        else {
              $this->log.="<br> Column '".$value."' not Found in First row ";
        }

      }

    public function importbulk(Request $request)
    {
        $this->log="";
        ini_set('max_execution_time', 1180);
        $filename = '';
        if ($file = $request->file('bulk'))
        {
            $filename = time().'-'.$file->getClientOriginalName();
            $file->move('assets/temp_files',$filename);
        }
        $datas = "";
        $file = fopen(public_path('assets/temp_files/'.$filename),"r");

        $i = 1;
        $s=1;
        $header=fgetcsv($file,1000,",");
        $id=$this->CsvGetColumnIndex('id',$header);
        $child_id=$this->CsvGetColumnIndex('child_id',$header);
        $zone_id=$this->CsvGetColumnIndex('zone_id',$header);
        $price=$this->CsvGetColumnIndex('price',$header);
        if($this->log!=""){
            return $this->log;
        }
        while (($line = fgetcsv($file)) !== FALSE) {
                //Checking SKU not exist in column (Insert)
                if(!ShippingDetail::where('id',$line[$id])->exists() || $line[$id] == "")
                {
                    $data = new ShippingDetail;  
                    $data->child_id = $line[$child_id];
                    $data->zone_id = $line[$zone_id];
                    $data->price = $line[$price];
                    $data->save();

                }
                elseif($line[$id] != '' && ShippingDetail::where('id',$line[$id])->exists())
                {
                        $data = ShippingDetail::where('id', $line[$id])->first();
                        $data->child_id = $line[$child_id];
                        $data->zone_id = $line[$zone_id];
                        $data->price = $line[$price];
                        $data->save();
                }
            $i++;
        }
        
        fclose($file);
        if (file_exists('assets/temp_files/'.$filename)) {
            unlink('assets/temp_files/'.$filename);
        }
        if ($this->log!="") {
           return $this->log;
        }

        $msg = 'Bulk Product File Imported Successfully'. $this->log;
        return response()->json($msg);
    }
    // //*** GET Request Delete
    public function destroy($id)
    {
        $data = ShippingDetail::findOrFail($id);
        $data->delete();
        //--- Redirect Section
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }
}
