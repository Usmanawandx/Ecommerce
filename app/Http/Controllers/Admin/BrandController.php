<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Datatables;
use Validator;
class BrandController extends Controller
{
    //

    public  function  index(){
        return view('admin.brand.index');
    }

    public  function  create(){
        return view('admin.brand.create');
    }
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
            'photo' => 'mimes:jpeg,jpg,png,svg',
            'slider' => 'mimes:jpeg,jpg,png,svg',
            'slug' => 'unique:brands,slug,'.$id.'|regex:/^[a-zA-Z0-9\s-]+$/'
        ];
        $customs = [
            'photo.mimes' => 'Icon Type is Invalid.',
            'slider.mimes' => 'Slider Type is Invalid.',
            'slug.unique' => 'This slug has already been taken.',
            'slug.regex' => 'Slug Must Not Have Any Special Characters.'
        ];
        $validator = Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = Brands::findOrFail($id);
        $input = $request->all();
        if ($file = $request->file('photo'))
        {
            $name = time().str_replace(' ', '', $file->getClientOriginalName());
            $file->move('assets/images/brands',$name);
            if($data->photo != null)
            {
                if (file_exists(public_path().'/assets/images/brands/'.$data->photo)) {
                    unlink(public_path().'/assets/images/brands/'.$data->photo);
                }
            }
            $input['photo'] = $name;
        }
        if ($file = $request->file('slider'))
        {
            $name = time().str_replace(' ', '', $file->getClientOriginalName());
            $file->move('assets/images/brands',$name);
            if($data->slider != '')
            {
                if (file_exists(public_path().'/assets/images/brands/'.$data->slider)) {
                    unlink(public_path().'/assets/images/brands/'.$data->slider);
                }
            }
            $input['slider'] = $name;
        }

        if ($request->slider_status == ""){
            $input['slider_status'] = 0;
        }
        else
        {
            $input['slider_status'] = 1;
        }
//        if ($request->is_featured == ""){
//            $input['is_featured'] = 0;
//        }
//        else {
//            $input['is_featured'] = 1;
//            //--- Validation Section
//            $rules = [
//                'image' => 'mimes:jpeg,jpg,png,svg'
//            ];
//            $customs = [
//                'image.required' => 'Feature Image is required.'
//            ];
//            $validator = Validator::make($request->all(), $rules, $customs);
//
//            if ($validator->fails()) {
//                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
//            }
//            //--- Validation Section Ends
//            if ($file = $request->file('image'))
//            {
//                $name = time().str_replace(' ', '', $file->getClientOriginalName());
//                $file->move('assets/images/categories',$name);
//                $input['image'] = $name;
//            }
//        }

        $data->update($input);
        cache()->forget('categories');
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }
    public function store(Request $request){
        $rules = [
            'photo' => 'mimes:jpeg,jpg,png,svg',
            'slider' => 'mimes:jpeg,jpg,png,svg',
            'slug' => 'unique:brands|regex:/^[a-zA-Z0-9\s-]+$/'
        ];
        $customs = [
            'photo.mimes' => 'Icon Type is Invalid.',
            'slider.mimes' => 'Slider Type is Invalid.',
            'slug.unique' => 'This slug has already been taken.',
            'slug.regex' => 'Slug Must Not Have Any Special Characters.'
        ];
        $validator = Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Brands();
        $input = $request->all();
        if ($file = $request->file('photo'))
        {
            $name = time().str_replace(' ', '', $file->getClientOriginalName());
            $file->move('assets/images/brands',$name);
            $input['photo'] = $name;
        }
        if ($file = $request->file('slider'))
        {
            $name = time().str_replace(' ', '', $file->getClientOriginalName());
            $file->move('assets/images/brands',$name);
            $input['slider'] = $name;
        }
        if ($request->slider_status == ""){
            $input['slider_status'] = 0;
        }
        else
        {
            $input['slider_status'] = 1;
        }
//        if ($request->is_featured == ""){
//            $input['is_featured'] = 0;
//        }
//        else {
//            $input['is_featured'] = 1;
//            //--- Validation Section
//            $rules = [
//                'image' => 'required|mimes:jpeg,jpg,png,svg'
//            ];
//            $customs = [
//                'image.required' => 'Feature Image is required.',
//                'image.mimes' => 'Feature Image Type is Invalid.'
//            ];
//            $validator = Validator::make($request->all(), $rules, $customs);
//
//            if ($validator->fails()) {
//                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
//            }
//            //--- Validation Section Ends
//            if ($file = $request->file('image'))
//            {
//                $name = time().str_replace(' ', '', $file->getClientOriginalName());
//                $file->move('assets/images/categories',$name);
//                $input['image'] = $name;
//            }
//        }
        $data->fill($input)->save();
        cache()->forget('categories');
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = 'New Data Added Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }
    public function datatables()
    {
        $datas = Brands::orderBy('id','desc')->get();
        //--- Integrating This Collection Into Datatables
        return Datatables::of($datas)
            ->addColumn('id', function(Brands $data) {
                return $data->id;
            })
            ->addColumn('status', function(Brands $data) {
                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                $s = $data->status == 1 ? 'selected' : '';
                $ns = $data->status == 0 ? 'selected' : '';
                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-brand-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><option data-val="0" value="'. route('admin-brand-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
            })
            ->addColumn('name', function(Brands $data) {
                $buttons = $data->name;
//                if ($data->attributes()->count() > 0) {
//                    $buttons .= '<a href="' . route('admin-attr-manage', $data->id) .'?type=category' . '" class="edit"> <i class="fas fa-edit"></i>Manage</a>';
//                }
//                $buttons .= '</div>';
                return $buttons;
            })
            ->addColumn('slug', function(Brands $data) {
                $slug = $data->slug;
                return $slug;
            })
            ->addColumn('products', function(Brands $data) {
                $products = Product::where('brand_id',$data->id)->count();
                return $products;
            })
            ->addColumn('feauture', function(Brands $data) {
                if ($data->is_feauture == "0") {
                    return '<div class="text-center"><label class="switch"><input type="checkbox" data-brand="'.$data->id.'" class="isfeauture"><span class="slider round"></span></label></div>';
                }
                else
                {
                    return '<div class="text-center"><label class="switch"><input type="checkbox" data-brand="'.$data->id.'" class="isfeauture" checked><span class="slider round"></span></label></div>';
                }

            })
            ->addColumn('action', function(Brands $data) {
                return '<div class="action-list"><a data-href="' . route('admin-brand-edit',$data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>Edit</a><a href="javascript:;" data-href="' . route('admin-brand-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
            })
            ->rawColumns(['id','status','attributes','feauture','action'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    public function edit($id){
        $data = Brands::findOrFail($id);
        return view('admin.brand.edit',compact('data'));
    }
    public function destroy($id)
    {
        $data = Brands::findOrFail($id);

        //If Photo Doesn't Exist
        if($data->photo == null){
            $data->delete();
            //--- Redirect Section
            $msg = 'Data Deleted Successfully.';
            return response()->json($msg);
            //--- Redirect Section Ends
        }
        //If Photo Exist
        // dd($data->image);
        if (file_exists(public_path().'/assets/images/brands/'.$data->photo)) {
            unlink(public_path().'/assets/images/brands/'.$data->photo);
        }
        // if (file_exists(public_path().'/assets/images/brands/'.$data->image)) {
        //     dd("true");
        //     unlink(public_path().'/assets/images/brands/'.$data->image);
        // }
        $data->delete();
        cache()->forget('categories');
        //--- Redirect Section
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }
    public function status($id1,$id2)
    {
        $data = Brands::findOrFail($id1);
        $data->status = $id2;
        $data->update();
        cache()->forget('categories');
    }
    public function exportBrand()
    {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=brands.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        $brands = Brands::all();
        $columns = array('id','name','slug','status');
        $callback = function() use ($brands, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach($brands as $brand) {
                fputcsv($file, array($brand->id,$brand->name,$brand->slug,$brand->status));
            }
            fclose($file);
        };
//        return Response::stream($callback, 200, $headers);
        return response()->stream($callback, 200, $headers);
    }
    public function updateFeauture(Request $request)
    {
        $check = $request->check;
        // dd($check);
        // return response()->json($check);
        if ($check == 'true')
        {
            $id = $request->id;
            $brand= Brands::findOrFail($id);
            $brand->is_feauture = 1;
            $brand->save();
            return response()->json('true');
        }
        else
        {
            $id = $request->id;
            $brand= Brands::findOrFail($id);
            $brand->is_feauture = 0;
            $brand->save();
            return response()->json('false');
        }
    }
}
