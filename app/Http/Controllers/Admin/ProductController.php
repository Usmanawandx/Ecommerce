<?php

namespace App\Http\Controllers\Admin;

use App\Models\Childcategory;
use App\Models\Subcategory;
use App\Models\User;
use Datatables;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Brands;
use App\Models\Stores;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Gallery;
use App\Models\Attribute;
use App\Models\AttributeOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Support\Str;
use File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Validator;
use Image;
use DB;

class ProductController extends Controller
{
    public $log = "";

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    function getimg($url) {
        $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
        $headers[] = 'Connection: Keep-Alive';
        $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
        $user_agent = 'php';
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($process, CURLOPT_HEADER, 0);
        curl_setopt($process, CURLOPT_USERAGENT, $user_agent); //check here
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        $return = curl_exec($process);
        curl_close($process);
        return $return;
    }
    public function scrap_image(){
        set_time_limit(500000);
        $products = Product::where("is_scrap","=",0)->where('photo', 'not like', "%https%")->get();
        $base_url = "https://ecpmarket.com/wp-content/uploads/";
        foreach ($products as $product) {
            if(empty($product->photo))
                continue;
            $extract_image_path = explode("/",$product->photo);
            if(isset($extract_image_path[0]) && isset($extract_image_path[1])){
                $newPath = $extract_image_path[0].'/'.$extract_image_path[1];

                $imgurl = $base_url . $product->photo;
                // $imagename= basename($imgurl);
                // // if(file_exists('./tmp/'.$imagename)){continue;}
                // $path = public_path() . '/assets/images/products/'.$newPath.'/';
                // $image = $this->getimg($imgurl);
                // file_put_contents($path.$imagename,$image);
                    $data = file_get_contents($imgurl);

                    // $fp = 'logo-1.png';

                    $image_path = public_path() . '/assets/images/products/'.$newPath.'/';
                    if (!is_dir($image_path)) mkdir($image_path, 0777, true);
                    // $fimg->save($image_path . $fphoto);
                    file_put_contents( $image_path.$extract_image_path[2], $data);
                    echo "File downloaded! ".$product->id.'____'.$product->photo."____".$image_path."<br>";
                //    exit();
                // try{
                //     $image = $base_url . $product->photo;
                //     $ch = curl_init();
                //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                //     curl_setopt($ch, CURLOPT_URL, $image);
                //     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
                //     curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
                //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                //     curl_setopt($ch, CURLOPT_HEADER, true);
                //     curl_setopt($ch, CURLOPT_NOBODY, true);
                //     $content = curl_exec($ch);

                //     $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
                //     $thumb_url = '';

                //     if (strpos($contentType, 'image/') !== false) {

                //         // echo $image;
                //         // exit();

                //         $fimg = Image::make($image->getRealPath())->resize(800,800);

                //         $fphoto = $extract_image_path[2];

                //         $image_path = public_path() . '/assets/images/products/'.$newPath.'/';
                //         if (!is_dir($image_path)) mkdir($image_path, 0777, true);
                //         $fimg->save($image_path . $fphoto);

                //         $image_thum_path = public_path() . '/assets/images/thumbnails/'.$newPath.'/';
                //         if (!is_dir($image_thum_path)) mkdir($image_thum_path, 0777, true);
                //         $timg = Image::make($image)->resize(285, 285);
                //         $thumbnail = $extract_image_path[2];
                //         $timg->save($image_thum_path. $thumbnail);
                        DB::table('products')
                            ->where('id', $product->id)
                            ->update(['is_scrap' => 1]);
                            // exit();
                //     }else {
                //         echo "Echo type is not image";
                //     }
                // }catch (Exception $e){

                //     echo "Scrapping Error In Porduct With ID".$product->id;
                // }
            }else{
                echo "Path is different : ".$product->photo." ____";
            }
        }
        exit();
    }
    public function exportComissionCategoryCsv()
    {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=Comission-Categories.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        $ccate = Childcategory::all();
        $columns = array("Code",'Sub Category', 'Name', 'Slugan', 'Status', 'Comission');
        $callback = function() use ($ccate, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach($ccate as $cat) {
                fputcsv($file, array($cat->id,$cat->subcategory_id, $cat->name, $cat->slug, $cat->status, $cat->comission));
            }
            fclose($file);
        };
//        return Response::stream($callback, 200, $headers);
        return response()->stream($callback, 200, $headers);
    }
    public function exportCsv()
    {
        $fileName = 'Products.csv';
        $products = Product::all();
        ini_set('max_execution_time', 10000);
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        $columns = array('sku','main_category','sub_category','child_category','name','slug','product_type','photo','batch','file','size','size_qty','size_price','price','previous_price','details','stock','policy','status','tags','brand','vendor');
        $callback = function() use($products, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($products as $produt) {
                $mcat = Category::find($produt->category_id);
                $scat =  Subcategory::find($produt->subcategory_id);
                $ccat = Childcategory::find($produt->childcategory_id);
                $brands = Brands::find($produt->brand_id);
                $store = User::find($produt->vendor_id);
                fputcsv($file, array(
                    $produt->sku,
                   ( isset($mcat->name) ? $mcat->name : Null),
                   ( isset($scat->name) ? $scat->name : Null),
                   ( isset($ccat->name) ? $ccat->name : Null),
                    $produt->name,
                    $produt->slug,
                    $produt->product_type,
                    $produt->photo,
                    $produt->batch,
                    $produt->file,
                    is_array($produt->size) ? implode(",",$produt->size) : $produt->size,
                    is_array($produt->size_qty) ? implode(",",$produt->size_qty) : $produt->size_qty,
                    is_array($produt->size_price) ? implode(",",$produt->size_price) : $produt->size_price,
                    $produt->price,
                    $produt->previous_price,
                    $produt->details,
                    $produt->stock,
                    $produt->policy,
                    $produt->status,
                    is_array($produt->tags) ? implode(",",$produt->tags) : $produt->tags,
                    isset($brands->name) ? $brands->name : Null,
                    isset($store->shop_name) ? $store->shop_name : Null,
                    ));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
    public function catlogExport()
    {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=catalog.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        $prods = Product::all();
        $columns = array('id','title','sku','description','google_product_category','availability','condition','price','link','image_link','brand','sale_price','custom_label_0','custom_label_1','custom_label_2','custom_label_3');
        $callback = function() use ($prods, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach($prods as $prod) {
                if($prod->product_condition == 0)
                {
                    $condition = "new";
                }
                else
                {
                    $condition = $prod->product_condition;
                }
                if($prod->stock == 0)
                {
                    $stock = "Out of Stock";
                }
                else
                {
                    $stock = "In Stock";
                }
                $link = 'https://ecpmarket.com/product/'.$prod->slug;
                $image_link = 'https://ecpmarket.com/product/assets/images/products/'.$prod->photo;
                // $details = strip_tags($prod->details);
                if($prod->previous_price != 0)
                {
                    $price = $prod->previous_price;
                }
                else{
                    $price = $prod->price;
                }
                if($prod->price <= 1000)
                {
                    $price_range = "under 1000";
                }
                else if($prod->price > 1000)
                {
                    $price_range = "above 1000";
                }
                fputcsv($file, array($prod->id,$prod->name,$prod->sku,$prod->name,$prod->category->name,$stock,$condition,$price,$link,$image_link,$prod->brand->name,$prod->price,$prod->category->name,$prod->subcategory->name,$prod->childcategory->name,$price_range));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
    //*** JSON Request
    // public function datatables()
    // {
    //      $datas = Product::where('product_type','=','normal')->orderBy('id','desc')->get();
    //      //--- Integrating This Collection Into Datatables
    //      return Datatables::of($datas)
    //                         ->addColumn('check', function(Product $data){
    //                             return '<input type="checkbox" name="duplicate[]" data-id="'.$data->id.'" class="check_duplicate">';
    //                         })
    //                         ->editColumn('name', function(Product $data) {
    //                             $name =  mb_strlen($data->name,'UTF-8') > 50 ? mb_substr($data->name,0,50,'UTF-8').'...' : $data->name;

    //                             $id = '<small>'.__("ID").': <a href="'.route('front.product', $data->slug).'" target="_blank">'.sprintf("%'.08d",$data->id).'</a></small>';

    //                             $id3 = $data->type == 'Physical' ?'<small class="ml-2"> '.__("SKU").': <a href="'.route('front.product', $data->slug).'" target="_blank">'.$data->sku.'</a>' : '';

    //                             return  $name.'<br>'.$id.$id3.$data->checkVendor();
    //                         })
    //                         ->editColumn('price', function(Product $data) {
    //                             $sign = Currency::where('is_default','=',1)->first();
    //                             $price = round($data->price * $sign->value , 2);
    //                             $price = $sign->sign.$price ;
    //                             return  $price;
    //                         })
    //                         ->editColumn('stock', function(Product $data) {
    //                             $stck = (string)$data->stock;
    //                             if($stck == "0")
    //                             return "Out Of Stock";
    //                             elseif($stck == null)
    //                             return "Unlimited";
    //                             else
    //                             return $data->stock;
    //                         })
    //                         ->editColumn('stockStatus', function(Product $data) {
    //                             $stck = (string)$data->stock;
    //                             if ($stck == "0") {
    //                                 return '<div class="text-center"><label class="switch"><input type="checkbox" data-prod="'.$data->id.'" class="toggle_check"><span class="slider round"></span></label></div>';
    //                             }
    //                             else
    //                             {
    //                                 return '<div class="text-center"><label class="switch"><input type="checkbox" data-prod="'.$data->id.'" class="toggle_check" checked><span class="slider round"></span></label></div>';
    //                             }
    //                         })
    //                         ->addColumn('status', function(Product $data) {
    //                             $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
    //                             $s = $data->status == 1 ? 'selected' : '';
    //                             $ns = $data->status == 0 ? 'selected' : '';
    //                             return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
    //                         })
    //                         ->addColumn('action', function(Product $data) {
    //                             $catalog = $data->type == 'Physical' ? ($data->is_catalog == 1 ? '<a href="javascript:;" data-href="' . route('admin-prod-catalog',['id1' => $data->id, 'id2' => 0]) . '" data-toggle="modal" data-target="#catalog-modal" class="delete"><i class="fas fa-trash-alt"></i> Remove Catalog</a>' : '<a href="javascript:;" data-href="'. route('admin-prod-catalog',['id1' => $data->id, 'id2' => 1]) .'" data-toggle="modal" data-target="#catalog-modal"> <i class="fas fa-plus"></i> Add To Catalog</a>') : '';
    //                             return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-prod-edit',$data->id) . '"> <i class="fas fa-edit"></i> Edit</a><a href="javascript" class="set-gallery" data-toggle="modal" data-target="#setgallery"><input type="hidden" value="'.$data->id.'"><i class="fas fa-eye"></i> View Gallery</a>'.$catalog.'<a data-href="' . route('admin-prod-feature',$data->id) . '" class="feature" data-toggle="modal" data-target="#modal2"> <i class="fas fa-star"></i> Highlight</a><a href="javascript:;" data-href="' . route('admin-prod-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></div></div>';
    //                         })
    //                         ->rawColumns(['name','check', 'status','stockStatus', 'action'])
    //                         ->toJson(); //--- Returning Json Data To Client Side
    // }
    
    public function datatables(Request $request)
    {
        $draw = $request->get('draw');
         $start = $request->get("start");
         $rowperpage = $request->get("length");
         $columnIndex_arr = $request->get('order');
         $columnName_arr = $request->get('columns');
         $order_arr = $request->get('order');
         $search_arr = $request->get('search');
         
         $columnIndex = $columnIndex_arr[0]['column']; // Column index
         $columnName = $columnName_arr[$columnIndex]['name']; // Column name
         $columnSortOrder = $order_arr[0]['dir']; // asc or desc
         $searchValue = $search_arr['value']; // Search value
         
         $totalRecords = Product::where('product_type','=','normal')->orderBy('id','desc')->count();
        $totalRecordswithFilter = Product::where('product_type','=','normal')->where('name', 'like', '%' .$searchValue . '%')->orWhere('sku', 'like', '%' .$searchValue . '%')->count();
        
    //     $records = Product::orderBy($columnName,$columnSortOrder)
    //   ->where('name', 'like', '%' .$searchValue . '%')
    //   ->skip($start)
    //   ->take($rowperpage)
    //   ->get();
        $records = Product::where('product_type','=','normal')->where('name', 'like', '%' .$searchValue . '%')->orWhere('sku', 'like', '%' .$searchValue . '%')->skip($start)->take($rowperpage)->orderBy('id','desc')->get();
       $data_arr = array();
       
       foreach($records as $record){
        $name =  mb_strlen($record->name,'UTF-8') > 50 ? mb_substr($record->name,0,50,'UTF-8').'...' : $record->name;
        $id = '<small>'.__("ID").': <a href="'.route('front.product', $record->slug).'" target="_blank">'.sprintf("%'.08d",$record->id).'</a></small>';
        $id3 = $record->type == 'Physical' ?'<small class="ml-2"> '.__("SKU").': <a href="'.route('front.product', $record->slug).'" target="_blank">'.$record->sku.'</a>' : '';
        $name_text =  $name.'<br>'.$id.$id3.$record->checkVendor();
        $type = $record->product_type;
        $stock = $record->stock;
        $sign = Currency::where('is_default','=',1)->first();
        $price = round($record->price * $sign->value , 2);
        $price = $sign->sign.' '.number_format($price);
        $check = '<input type="checkbox" name="duplicate[]" data-id="'.$record->id.'" class="check_duplicate">'; 
        $class = $record->status == 1 ? 'drop-success' : 'drop-danger';
        $s = $record->status == 1 ? 'selected' : '';
        $ns = $record->status == 0 ? 'selected' : '';
        $status =  '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-prod-status',['id1' => $record->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-prod-status',['id1' => $record->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
        $catalog = $record->type == 'Physical' ? ($record->is_catalog == 1 ? '<a href="javascript:;" data-href="' . route('admin-prod-catalog',['id1' => $record->id, 'id2' => 0]) . '" data-toggle="modal" data-target="#catalog-modal" class="delete"><i class="fas fa-trash-alt"></i> Remove Catalog</a>' : '<a href="javascript:;" data-href="'. route('admin-prod-catalog',['id1' => $record->id, 'id2' => 1]) .'" data-toggle="modal" data-target="#catalog-modal"> <i class="fas fa-plus"></i> Add To Catalog</a>') : '';
        $action = '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-prod-edit',$record->id) . '"> <i class="fas fa-edit"></i> Edit</a><a href="javascript" class="set-gallery" data-toggle="modal" data-target="#setgallery"><input type="hidden" value="'.$record->id.'"><i class="fas fa-eye"></i> View Gallery</a>'.$catalog.'<a data-href="' . route('admin-prod-feature',$record->id) . '" class="feature" data-toggle="modal" data-target="#modal2"> <i class="fas fa-star"></i> Highlight</a><a href="javascript:;" data-href="' . route('admin-prod-boosting',$record->id) . '" data-toggle="modal" data-target="#boost_modal" class="boosting"><i class="fas fa-rocket"></i>Boosting</a><a href="javascript:;" data-href="' . route('admin-prod-delete',$record->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></div></div>';
        if ($stock == "0") {
            $stockStatus = '<div class="text-center"><label class="switch"><input type="checkbox" data-prod="'.$record->id.'" class="toggle_check"><span class="slider round"></span></label></div>';
        }
        else
        {
            $stockStatus = '<div class="text-center"><label class="switch"><input type="checkbox" data-prod="'.$record->id.'" class="toggle_check" checked><span class="slider round"></span></label></div>';
        }
        if($stock == "0")
        {
            $stock_text =  "Out Of Stock";
        }
        elseif($stock == null)
        {
            $stock_text = "Unlimited";
        }
        else
        {
            $stock_text = $stock;
        }
        $data_arr[] = array(
          "check" => $check,
          "name" => $name_text,
          "type" => $type,
          "stock" => $stock_text,
          "stockStatus" => $stockStatus,
          "price" => $price,
          "status" => $status,
          "action" => $action,
        );
       }
        $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
     );
    echo json_encode($response);
     exit;
    }
    
    //*** JSON Request
    public function deactivedatatables()
    {
         $datas = Product::where('status','=',0)->orderBy('id','desc')->get();

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('name', function(Product $data) {
                                $name =  mb_strlen($data->name,'UTF-8') > 50 ? mb_substr($data->name,0,50,'UTF-8').'...' : $data->name;

                                $id = '<small>'.__("ID").': <a href="'.route('front.product', $data->slug).'" target="_blank">'.sprintf("%'.08d",$data->id).'</a></small>';

                                $id3 = $data->type == 'Physical' ?'<small class="ml-2"> '.__("SKU").': <a href="'.route('front.product', $data->slug).'" target="_blank">'.$data->sku.'</a>' : '';

                                return  $name.'<br>'.$id.$id3.$data->checkVendor();
                            })
                            ->editColumn('price', function(Product $data) {
                                $sign = Currency::where('is_default','=',1)->first();
                                $price = round($data->price * $sign->value , 2);
                                $price = $sign->sign.$price ;
                                return  $price;
                            })
                            ->editColumn('stock', function(Product $data) {
                                $stck = (string)$data->stock;
                                if($stck == "0")
                                return "Out Of Stock";
                                elseif($stck == null)
                                return "Unlimited";
                                else
                                return $data->stock;
                            })
                            ->editColumn('stockStatus', function(Product $data) {
                                $stck = (string)$data->stock;
                                if ($stck == "0") {
                                    return '<div class="text-center"><label class="switch"><input type="checkbox" data-prod="'.$data->id.'" class="toggle_check"><span class="slider round"></span></label></div>';
                                }
                                else
                                {
                                    return '<div class="text-center"><label class="switch"><input type="checkbox" data-prod="'.$data->id.'" class="toggle_check" checked><span class="slider round"></span></label></div>';
                                }
                            })
                            ->addColumn('status', function(Product $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            })
                            ->addColumn('action', function(Product $data) {
                                $catalog = $data->type == 'Physical' ? ($data->is_catalog == 1 ? '<a href="javascript:;" data-href="' . route('admin-prod-catalog',['id1' => $data->id, 'id2' => 0]) . '" data-toggle="modal" data-target="#catalog-modal" class="delete"><i class="fas fa-trash-alt"></i> Remove Catalog</a>' : '<a href="javascript:;" data-href="'. route('admin-prod-catalog',['id1' => $data->id, 'id2' => 1]) .'" data-toggle="modal" data-target="#catalog-modal"> <i class="fas fa-plus"></i> Add To Catalog</a>') : '';
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-prod-edit',$data->id) . '"> <i class="fas fa-edit"></i> Edit</a><a href="javascript" class="set-gallery" data-toggle="modal" data-target="#setgallery"><input type="hidden" value="'.$data->id.'"><i class="fas fa-eye"></i> View Gallery</a>'.$catalog.'<a data-href="' . route('admin-prod-feature',$data->id) . '" class="feature" data-toggle="modal" data-target="#modal2"> <i class="fas fa-star"></i> Highlight</a><a href="javascript:;" data-href="' . route('admin-prod-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></div></div>';
                            })
                            ->rawColumns(['name', 'status', 'stockStatus', 'action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }


    //*** JSON Request
    public function catalogdatatables()
    {
         $datas = Product::where('is_catalog','=',1)->orderBy('id','desc')->get();

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('name', function(Product $data) {
                                $name = mb_strlen(strip_tags($data->name),'utf-8') > 50 ? mb_substr(strip_tags($data->name),0,50,'utf-8').'...' : strip_tags($data->name);
                                $id = '<small>ID: <a href="'.route('front.product', $data->slug).'" target="_blank">'.sprintf("%'.08d",$data->id).'</a></small>';

                                $id3 = $data->type == 'Physical' ?'<small class="ml-2"> SKU: <a href="'.route('front.product', $data->slug).'" target="_blank">'.$data->sku.'</a>' : '';

                                return  $name.'<br>'.$id.$id3;
                            })
                            ->editColumn('price', function(Product $data) {
                                $sign = Currency::where('is_default','=',1)->first();
                                $price = round($data->price * $sign->value , 2);
                                $price = $sign->sign.$price ;
                                return  $price;
                            })
                            ->editColumn('stock', function(Product $data) {
                                $stck = (string)$data->stock;
                                if($stck == "0")
                                return "Out Of Stock";
                                elseif($stck == null)
                                return "Unlimited";
                                else
                                return $data->stock;
                            })
                            ->addColumn('status', function(Product $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            })
                            ->addColumn('action', function(Product $data) {
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-prod-edit',$data->id) . '"> <i class="fas fa-edit"></i> Edit</a><a href="javascript" class="set-gallery" data-toggle="modal" data-target="#setgallery"><input type="hidden" value="'.$data->id.'"><i class="fas fa-eye"></i> View Gallery</a><a data-href="' . route('admin-prod-feature',$data->id) . '" class="feature" data-toggle="modal" data-target="#modal2"> <i class="fas fa-star"></i> Highlight</a><a href="javascript:;" data-href="' . route('admin-prod-catalog',['id1' => $data->id, 'id2' => 0]) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i> Remove Catalog</a></div></div>';
                            })
                            ->rawColumns(['name', 'status', 'action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    //*** GET Request
    public function index()
    {
        return view('admin.product.index');
    }

    //*** GET Request
    public function deactive()
    {
        return view('admin.product.deactive');
    }

    //*** GET Request
    public function catalogs()
    {
        return view('admin.product.catalog');
    }

    //*** GET Request
    public function types()
    {
        return view('admin.product.types');
    }

    //*** GET Request
    public function createPhysical()
    {
        $cats = Category::all();
        $sign = Currency::where('is_default','=',1)->first();
        $brand = Brands::where('status','=',1)->get();
        $store = User::where('is_vendor','=',2)->get();
//        dd($store);
        return view('admin.product.create.physical',compact('cats','sign','brand','store'));
    }
    //*** GET Request
    public function createDigital()
    {
        $cats = Category::all();
        $sign = Currency::where('is_default','=',1)->first();
        $brand = Brands::all();
        $store = User::where('is_vendor','=',2)->get();
        return view('admin.product.create.digital',compact('cats','sign','brand','store'));
    }
    //*** GET Request
    public function createLicense()
    {
        $cats = Category::all();
        $sign = Currency::where('is_default','=',1)->first();
        $brand = Brands::all();
        $store = User::where('is_vendor','=',2)->get();
        return view('admin.product.create.license',compact('cats','sign','brand','store'));
    }

    //*** GET Request
    public function status($id1,$id2)
    {
        $data = Product::findOrFail($id1);
        $data->status = $id2;
        $data->update();
    }

    //*** GET Request
    public function catalog($id1,$id2)
    {
        $data = Product::findOrFail($id1);
        $data->is_catalog = $id2;
        $data->update();
        if($id2 == 1) {
            $msg = "Product added to catalog successfully.";
        }
        else {
            $msg = "Product removed from catalog successfully.";
        }

        return response()->json($msg);

    }

    //*** POST Request
    public function uploadUpdate(Request $request,$id)
    {
        //--- Validation Section
        $rules = [
          'photo' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $data = Product::findOrFail($id);
        // dd($request->hasFile('photo'));
        //--- Validation Section Ends

        // list($type, $image) = explode(';', $image);
        // list(, $image)      = explode(',', $image);
        // $image = base64_decode($image);
        // $image_name = Str::random(10).'.png';
        // dd(pathinfo($request->photo, PATHINFO_EXTENSION));
        // $image_name = Str::random(10).'.'.pathinfo($request->photo, PATHINFO_EXTENSION);

        // $path = 'assets/images/products/'.$image_name;
        // file_put_contents($path, $image);
        // $image = $request->photo;

        // list($type, $image) = explode(';', $image);
        // list(, $image)      = explode(',', $image);
    // dd($image);

        // $image_name = Str::random(10);
        //  $file = $request->file();

        // $path =  public_path('assets/images/products/');
        // dd( $path);
        // $file->move($path,$image_name);
       // file_put_contents($path, $image);
        // file_put_contents($path, $image);
        // $image = $request->photo;
        // $image = base64_decode($image);
        $date = date('Y-m-d');
        $image_name = Str::random(10).'.'.$request->file('photo')->extension();
        // $image_name = Str::random(10);
        $file = $request->file('photo');
        if (! File::exists('assets/images/products/'.$date)) {
            File::makeDirectory('assets/images/products/'.$date);
        }
        $path =  public_path('assets/images/products/'.$date.'/');
        // dd( $path);
        $file->move($path,$image_name);
        // file_put_contents($path, $image);
        $input['photo'] = $date.'/'.$image_name;
        $input['batch'] = $date;
        if($data->photo != null)
        {
            $imageExist = Product::where('photo',$data->photo)->where('id','!=',$data->id)->first();
            if ($imageExist == null) {
                if (file_exists(public_path().'/assets/images/products/'.$data->photo)) {
                    unlink(public_path().'/assets/images/products/'.$data->photo);
                }
            }

        }
                        // $input['photo'] = $image_name;
         $data->update($input);
         $data->thumbnail  = $input['photo'];
         $data->update();
                // if($data->thumbnail != null)
                // {
                //     if (file_exists(public_path().'/assets/images/thumbnails/'.$data->thumbnail)) {
                //         unlink(public_path().'/assets/images/thumbnails/'.$data->thumbnail);
                //     }
                // }

        // $img = Image::make( public_path('assets/images/products/').$data->photo)->resize(285, 285);
        // // $img = Image::make(public_path('assets/images/products/').$data->photo)->resize(285, 285);
        // $thumbnail = Str::random(10).'.'.pathinfo($data->photo,PATHINFO_EXTENSION);
        // $img->save(public_path('/assets/images/thumbnails/').$thumbnail);
        // $data->thumbnail  = $thumbnail;
        // $data->update();
        return response()->json(['status'=>true,'file_name' => $input['photo']]);
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
            'photo'      => 'required',
            'file'       => 'mimes:zip',
            'slug'      => 'unique:products'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Product;
        $sign = Currency::where('is_default','=',1)->first();
        $input = $request->all();

        // Check File
        if ($file = $request->file('file')) {
            $name = time().str_replace(' ', '', $file->getClientOriginalName());
            $file->move('assets/files',$name);
            $input['file'] = $name;
        }
        $image = $request->photo;

        // list($type, $image) = explode(';', $image);
        // list(, $image)      = explode(',', $image);
        $image = base64_decode($image);
        $date = date('Y-m-d');
        $image_name = Str::random(10).'.'.$request->file('photo')->extension();
        // $image_name = Str::random(10);
        $file = $request->file('photo');
        if (! File::exists('assets/images/products/'.$date)) {
            File::makeDirectory('assets/images/products/'.$date);
        }
            $path =  public_path('assets/images/products/'.$date.'/');
        // dd( $path);
        $file->move($path,$image_name);
        // file_put_contents($path, $image);
        $input['photo'] = $date.'/'.$image_name;

        // dd($image_name);
        $data->batch = $date;
        // Check Physical
        if($request->type == "Physical")
        {
            //--- Validation Section
            $rules = ['sku'      => 'min:8|unique:products'];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }
            //--- Validation Section Ends

            // Check Condition
            if ($request->product_condition_check == ""){
                $input['product_condition'] = 0;
            }

            // Check Shipping Time
            if ($request->shipping_time_check == ""){
                $input['ship'] = null;
            }

            // Check Size
            if(empty($request->size_check ))
            {
                $input['size'] = null;
                $input['size_qty'] = null;
                $input['size_price'] = null;
            }
            else{
                if(in_array(null, $request->size) || in_array(null, $request->size_qty))
                {
                    $input['size'] = null;
                    $input['size_qty'] = null;
                    $input['size_price'] = null;
                }
                else
                {
                    if(in_array(0,$input['size_qty'])){
                        return response()->json(array('errors' => [0 => 'Size Qty can not be 0.']));
                    }

                    $input['size'] = implode(',', $request->size);
                    $input['size_qty'] = implode(',', $request->size_qty);
                    $size_prices = $request->size_price;
                    $s_price = array();
                    foreach($size_prices as $key => $sPrice){
                        $s_price[$key] = $sPrice / $sign->value;
                    }

                    $input['size_price'] = implode(',', $s_price);
                    $size_previous_prices = $request->size_previous_price;
                    $s_pre_price = array();
                    foreach($size_previous_prices as $key => $item){
                        $s_pre_price[$key] = $item / $sign->value;
                    }
                    $input['size_prevoius_price'] = implode(',', $s_pre_price);
                }
            }


            // Check Whole Sale
            if(empty($request->whole_check ))
            {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
            }
            else{
                if(in_array(null, $request->whole_sell_qty) || in_array(null, $request->whole_sell_discount))
                {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
                }
                else
                {
                    $input['whole_sell_qty'] = implode(',', $request->whole_sell_qty);
                    $input['whole_sell_discount'] = implode(',', $request->whole_sell_discount);
                }
            }

            // Check Color
            if(empty($request->color_check))
            {
                $input['color'] = null;
            }
            else{
                $input['color'] = implode(',', $request->color);
            }

            // Check Measurement
            if ($request->mesasure_check == "")
            {
                $input['measure'] = null;
            }

        }

        // Check Seo
        if (empty($request->seo_check))
        {
            $input['meta_tag'] = null;
            $input['meta_description'] = null;
        }
        else {
            if (!empty($request->meta_tag))
            {
                $input['meta_tag'] = implode(',', $request->meta_tag);
            }
        }

        // Check License

        if($request->type == "License")
        {

            if(in_array(null, $request->license) || in_array(null, $request->license_qty))
            {
                $input['license'] = null;
                $input['license_qty'] = null;
            }
            else
            {
                $input['license'] = implode(',,', $request->license);
                $input['license_qty'] = implode(',', $request->license_qty);
            }

        }

        // Check Features
        if(in_array(null, $request->features) || in_array(null, $request->colors))
        {
            $input['features'] = null;
            $input['colors'] = null;
        }
        else
        {
            $input['features'] = implode(',', str_replace(',',' ',$request->features));
            $input['colors'] = implode(',', str_replace(',',' ',$request->colors));
        }

        //tags
        if (!empty($request->tags))
        {
            $input['tags'] = implode(',', $request->tags);
        }



        // Conert Price According to Currency
        $input['price'] = ($input['price'] / $sign->value);
        $input['previous_price'] = ($input['previous_price'] / $sign->value);



        // store filtering attributes for physical product
        $attrArr = [];
        if (!empty($request->category_id)) {
          $catAttrs = Attribute::where('attributable_id', $request->category_id)->where('attributable_type', 'App\Models\Category')->get();
          if (!empty($catAttrs)) {
            foreach ($catAttrs as $key => $catAttr) {
              $in_name = $catAttr->input_name;
              if ($request->has("$in_name")) {
                $attrArr["$in_name"]["values"] = $request["$in_name"];
                $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                if ($catAttr->details_status) {
                  $attrArr["$in_name"]["details_status"] = 1;
                } else {
                  $attrArr["$in_name"]["details_status"] = 0;
                }
              }
            }
          }
        }

        if (!empty($request->subcategory_id)) {
          $subAttrs = Attribute::where('attributable_id', $request->subcategory_id)->where('attributable_type', 'App\Models\Subcategory')->get();
          if (!empty($subAttrs)) {
            foreach ($subAttrs as $key => $subAttr) {
              $in_name = $subAttr->input_name;
              if ($request->has("$in_name")) {
                $attrArr["$in_name"]["values"] = $request["$in_name"];
                $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                if ($subAttr->details_status) {
                  $attrArr["$in_name"]["details_status"] = 1;
                } else {
                  $attrArr["$in_name"]["details_status"] = 0;
                }
              }
            }
          }
        }
        if (!empty($request->childcategory_id)) {
          $childAttrs = Attribute::where('attributable_id', $request->childcategory_id)->where('attributable_type', 'App\Models\Childcategory')->get();
          if (!empty($childAttrs)) {
            foreach ($childAttrs as $key => $childAttr) {
              $in_name = $childAttr->input_name;
              if ($request->has("$in_name")) {
                $attrArr["$in_name"]["values"] = $request["$in_name"];
                $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                if ($childAttr->details_status) {
                  $attrArr["$in_name"]["details_status"] = 1;
                } else {
                  $attrArr["$in_name"]["details_status"] = 0;
                }
              }
            }
          }
        }

        if (empty($attrArr)) {
          $input['attributes'] = NULL;
        } else {
          $jsonAttr = json_encode($attrArr);
          $input['attributes'] = $jsonAttr;
        }
        // Save Data
        $data->fill($input)->save();

        // Set SLug
        $prod = Product::find($data->id);
        // if($prod->type != 'Physical'){
        //     $prod->slug = Str::slug($data->name,'-').'-'.strtolower(Str::random(3).$data->id.Str::random(3));
        // }
        // else {
            // $prod->slug = Str::slug($data->name,'-');
        // }

        // Set Thumbnail
    $prod->thumbnail = $input['photo'];
        $prod->update();

        // Add To Gallery If any
        $lastid = $data->id;
        if ($files = $request->file('gallery')){
            if (! File::exists('assets/images/galleries/'.$date)) {
                File::makeDirectory('assets/images/galleries/'.$date);
            }
                $path =  public_path('assets/images/galleries/'.$date.'/');
            foreach ($files as  $key => $file){
                if(in_array($key, $request->galval))
                {
                    $gallery = new Gallery;
                    $name = time().str_replace(' ', '', $file->getClientOriginalName());
                    $file->move($path,$name);
                    $gallery['photo'] = $date.'/'.$name;
                    $gallery['product_id'] = $lastid;
                    $gallery->save();
                }
            }
        }
        //logic Section Ends

        //--- Redirect Section
        $msg = 'New Product Added Successfully.<a href="'.route('admin-prod-index').'">View Product Lists.</a>';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** POST Request
    public function import(){

        $cats = Category::all();
        $sign = Currency::where('is_default','=',1)->first();
        return view('admin.product.productcsv',compact('cats','sign'));
    }
    public function CsvGetColumnIndex($value,$header){
      $key=  array_search($value,$header);
      if(isset($key)&&$key+1!=false){
        return $key;
      }
      else {
            $this->log.="<br> Column '".$value."' not Found in First row ";
      }
        // $linecount = 0;
        // $cellcnt = 0;
        // while (($line = fgetcsv($file,1000,","))) {
        //     $linecount++;
        //     foreach($line as $key => $values) {
        //         if ($key == 0) {
        //             dd($line);
        //             if ($value==$values) {
        //                 $this->log.="<br> found ".$values." at".$key;
        //                return $key;
        //             }
        //         }
        //         else {
        //             continue;
        //         }
        //     }
        // }
    }
    public function importSubmit(Request $request)
    {
        $this->log="";
        ini_set('max_execution_time', 1180);
        $filename = '';
        if ($file = $request->file('csvfile'))
        {
            $filename = time().'-'.$file->getClientOriginalName();
            $file->move('assets/temp_files',$filename);
        }
        $datas = "";
        $file = fopen(public_path('assets/temp_files/'.$filename),"r");

        $i = 1;
        $s=1;
        $header=fgetcsv($file,1000,",");
        // dd($header);
        // $sku=$this->CsvGetColumnIndex('sku',$header);
        // $url = [];
        // while (($line = fgetcsv($file)) !== FALSE) {
        //     $data = Product::where('sku',$line[$sku])->first();
        //     dd($data);
        //     $data->slug = Str::slug($data->name,'-');
        //     $data->save();
        // };
        // dd($url);
        // exit();
        //Columns
        $sku=$this->CsvGetColumnIndex('sku',$header);
        $child_category=$this->CsvGetColumnIndex('child_category',$header);
        $product_name=$this->CsvGetColumnIndex('product_name',$header);
        $Brand=$this->CsvGetColumnIndex('Brand',$header);
        $Seller=$this->CsvGetColumnIndex('Seller',$header);
        $image_batch=$this->CsvGetColumnIndex('image_batch#',$header);
        $gallery_batch=$this->CsvGetColumnIndex('gallery_batch',$header);
        $Image1_name=$this->CsvGetColumnIndex('Image1_name',$header);
        $Image2_Name=$this->CsvGetColumnIndex('Image2_Name',$header);
        $product_description=$this->CsvGetColumnIndex('product_description',$header);
        $Sale_Price=$this->CsvGetColumnIndex('Previous Price',$header);
        $Retail_Price=$this->CsvGetColumnIndex('Current Price',$header);
        $stock_quantity=$this->CsvGetColumnIndex('stock_quantity',$header);
        $stock_status=$this->CsvGetColumnIndex('stock_status',$header);
        $Warranty=$this->CsvGetColumnIndex('Warranty',$header);
        $Warranty_Duration=$this->CsvGetColumnIndex('Warranty Duration',$header);
        $Variable=$this->CsvGetColumnIndex('Variable',$header);
        $Variant_Name=$this->CsvGetColumnIndex('Variant Name',$header);
        $Variant_Value=$this->CsvGetColumnIndex('Variant Value',$header);
        $tags=$this->CsvGetColumnIndex('tags',$header);
        $policy=$this->CsvGetColumnIndex('policy',$header);
        $meta_tag=$this->CsvGetColumnIndex('meta_tag',$header);
        $meta_title=$this->CsvGetColumnIndex('meta_title',$header);
        $Product_URL=$this->CsvGetColumnIndex('Product_URL',$header);
        $meta_description=$this->CsvGetColumnIndex('meta_description',$header);
        $product_type=$this->CsvGetColumnIndex('product_type',$header);
        // dd($batch);
        if($this->log!=""){
            return $this->log;
        }
        // dd( $meta_title);

        //End Columns
        // dd($header);
        // while (($line = fgetcsv($file,1000,",")) !== FALSE) {

        //     $s++;
        // }
        while (($line = fgetcsv($file)) !== FALSE) {
                $pro_type= ['normal','affiliate'];
                if($line[$product_type]==""){
                    $this->log .="<br>Row No: ".$i." - product_type must be required ";
                }
                else if(!in_array($line[$product_type],$pro_type)){
                    $this->log .="<br>Row No: ".$i." - product_type must be 'normal' or 'affiliate'";
                }
                //Checking SKU not exist in column (Insert)
                if($line[$sku] == "" || !Product::where('sku',$line[$sku])->exists())
                {
                    // dd($line[$sku]);
                    DB::beginTransaction();
                    try {
                        $data = new Product;
                        $ccat = Childcategory::find($line[$child_category]);
                        $catname =  $ccat['name'];
                        // dd($catname);
                        $sign = Currency::where('is_default','=',1)->first();
                        $input['type'] = 'Physical';
                        $input['details']=htmlentities($line[$product_description],ENT_IGNORE);
                        $input['name'] = htmlentities($line[$product_name],ENT_IGNORE);
                        // check sku
                        if ($line[$sku] == "") {
                            $input['sku'] = substr($catname,0,3)."-".random_int (100000,999999);
                        }
                        else{
                            $input['sku'] = $line['sku'];
                        }
                        // check child category
                        if($line[$child_category] != "" && $ccat != null){
                            $input['childcategory_id'] = $ccat['id'];
                            $input['subcategory_id'] = $ccat->subcategory_id;
                            $scat = Subcategory::find($ccat->subcategory_id);
                            if ($scat != null) {
                                $input['category_id'] = $scat->category_id;
                            }
                            else{
                                $this->log .="<br>Row No: ".$i." - Main Category or Sub Category not found";
                            }

                        }
                        else{
                            $this->log .="<br>Row No: ".$i." - Child Category not found";
                        }
                        // check brand
                        $brand = Brands::find($line[$Brand]);
                        if ($line[$Brand] != "" && $brand != null) {
                            $input['brand_id'] = $brand->id;
                        }
                        else{
                            $this->log .="<br>Row No: ".$i." - Brand not found";
                        }
                        // check seller
                        $seller = User::find($line[$Seller]);
                        if ($line[$Seller] != "" && $seller != null) {
                            $input['vendor_id'] = $seller->id;
                        }
                        else{
                            $this->log .="<br>Row No: ".$i." - Store not found";
                        }

                        $attrArr = [];
                        $attrArr["warranty_type"]["values"] = $line[$Warranty_Duration];
                        $attrArr["warranty_type"]["prices"] = $request["warranty_type"."_price"];
                        $attrArr["warranty_type"]["details_status"] = 0;
                        $jsonAttr = json_encode($attrArr);
                        $input['attributes'] = $jsonAttr;
                        if ($line[$Retail_Price]!="") {
                            $input['price'] = $line[$Retail_Price];
                        }
                        else {
                            $this->log.="<br> Retail Price are Required at row ".$i;
                        }
                        $input['previous_price'] = $line[$Sale_Price] != "" ? $line[$Sale_Price] : null;
                        if(isset($line[$stock_quantity])){
                            $input['stock'] = $line[$stock_quantity];
                        }
                        else {
                                $this->log.="<br> stock_quantity  are Required at row ".$i;
                        }
                        $input['policy'] = $line[$policy];
                        $input['meta_tag'] = $line[$meta_tag];
                        $input['meta_description'] = $line[$meta_title];
                        if (isset( $line[$tags])) {
                            $input['tags'] = $line[$tags];
                        }
                        else {
                            $this->log.="<br> tags  are Required at row ".$i;
                        }
                        $input['product_type'] = $line[$product_type];
                        $input['slug'] = Str::slug($input['name'],'-');

                        if(isset($line[$Image1_name])){
                            if (file_exists(public_path().'/assets/images/products/'.$line[$image_batch].'/'.$line[$Image1_name])) {

                                $input['photo'] = $line[$image_batch].'/'.$line[$Image1_name];
                                $input['thumbnail']  = $input['photo'];
                            }
                            else {
                                $this->log.="<br> given image not found according the batch ".$line[$image_batch]." at row ".$i;
                            }
                        }
                        else {
                            $this->log.="<br>Image1_name required at row #".$i;
                        }
                        if($this->log==""){
                            $data->fill($input)->save();
                        }
                        if($line[$Image2_Name]!=""){
                            $str = $line[$Image2_Name];
                            $pics = explode(",",$str);
                            foreach($pics as $key => $value)
                            {
                                if (file_exists(public_path().'assets/images/galleries/'.$line[$gallery_batch].'/'.$value)) {
                                    # code...

                                    $inputdata = new Gallery;
                                    $input["product_id"] = $data->id;
                                    $input['photo'] = $line[$gallery_batch].'/'.$value;
                                    // dd($line[$image_batch].'/'.$value);
                                    if($this->log==""){
                                        $inputdata->fill($input)->save();
                                    }
                                }
                                else {
                                    $this->log.="<br> given image2_name not found in galleries at row ".$i;
                                }
                            }
                        }
                        DB::commit();
                        }catch (\Exception $e) {
                            DB::rollback();
                            // something went wrong
                        }
                }
                //Checking SKU exist in column (Update)
                else
                {
                    DB::beginTransaction();
                    try {
                    // dd($line[$sku]);
                        $data = Product::where('sku', $line[$sku])->first();
                        $sign = Currency::where('is_default','=',1)->first();

                        $input['type'] = 'Physical';
                        if($line[$product_description] != "")
                        {
                            $input['details']=htmlentities($line[$product_description],ENT_IGNORE);
                        }
                        if($line[$product_name] != "")
                        {
                        $input['name'] = htmlentities($line[$product_name], ENT_IGNORE);
                        }
                        // check child category
                        if($line[$child_category] != ""){
                            $ccat = Childcategory::find($line[$child_category]);
                            $input['childcategory_id'] = $ccat['id'];
                            $input['subcategory_id'] = $ccat->subcategory_id;
                            $scat = Subcategory::find($ccat->subcategory_id);
                            if ($scat != null) {
                                $input['category_id'] = $scat->category_id;
                            }
                            else{
                                $this->log .="<br>Row No: ".$i." - Main Category or Sub Category not found";
                            }

                        }
                        // check brand
                        if ($line[$Brand] != "") {
                            $brand = Brands::find($line[$Brand]);
                            $input['brand_id'] = $brand->id;
                        }
                        // check seller

                        if ($line[$Seller] != "") {
                            $seller = User::find($line[$Seller]);
                            $input['vendor_id'] = $seller->id;
                        }
                        $attrArr = [];
                        $attrArr["warranty_type"]["values"] = $line[$Warranty_Duration];
                        $attrArr["warranty_type"]["prices"] = $request["warranty_type"."_price"];
                        $attrArr["warranty_type"]["details_status"] = 0;
                        $jsonAttr = json_encode($attrArr);
                        $input['attributes'] = $jsonAttr;
                        if ($line[$Retail_Price]!="") {
                            $input['price'] = $line[$Retail_Price];
                        }
                        if($line[$Sale_Price] != "")
                        {
                            $input['previous_price'] = $line[$Sale_Price];
                        }
                        if($line[$stock_quantity] != ""){
                            $input['stock'] = $line[$stock_quantity];
                        }
                        $input['policy'] = $line[$policy];
                        $input['meta_tag'] = $line[$meta_tag];
                        $input['meta_description'] = $line[$meta_title];
                        if (isset( $line[$tags])) {
                            $input['tags'] = $line[$tags];
                        }
                        else {
                            $this->log.="<br> tags  are Required at row ".$i;
                        }
                        $input['product_type'] = $line[$product_type];
                        // if($line['slug'] != "")
                        // {
                        //     $input['slug'] = $line['slug'];
                        // }
                        // $slug = Str::slug($input['name'],'-');
                        // $existslug = Product::where('slug',$slug)->get()
                        // if($existslug != null)
                        // {
                        //  $input['slug'] = ;
                        // }
                        if($line[$Image1_name] != "" && $line[$image_batch] != ""){
                            if (file_exists(public_path(). '/assets/images/products/'.$line[$image_batch].'/'.$line[$Image1_name])) {

                                $input['photo'] = $line[$image_batch].'/'.$line[$Image1_name];
                                $input['thumbnail']  = $input['photo'];
                            }
                            else {
                                $this->log.="<br> given image not found according the batch ".$line[$image_batch]." at row ".$i;
                            }
                        }
                        if($line[$Image2_Name]!=""){
                            $result_gallary =  Gallery::where("product_id",$data->id)->get();
                            // if(count($result_gallary) > 0){
                            //     $result_gallary->delete();
                            // }
                            $str = $line[$Image2_Name];
                            $pics = explode(",",$str);
                            foreach($pics as $key => $value)
                            {
                                if (file_exists(public_path().'assets/images/galleries/'.$line[$gallery_batch].'/'.$value)) {
                                    # code...

                                    $inputdata = new Gallery;
                                    $input["product_id"] = $data->id;
                                    $input['photo'] = $line[$gallery_batch].'/'.$value;
                                    // dd($line[$image_batch].'/'.$value);
                                    if($this->log==""){
                                        $inputdata->fill($input)->save();
                                    }
                                }
                                else {
                                    $this->log.="<br> given image2_name not found in galleries at row ".$i;
                                }
                            }
                        }
                        if($this->log==""){
                            $data->update($input);
                        }
                    DB::commit();
                    }catch (\Exception $e) {
                        DB::rollback();
                        // something went wrong
                    }
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
        //--- Redirect Section
        $msg = 'Bulk Product File Imported Successfully.<a href="'.route('admin-prod-index').'">View Product Lists.</a>'. $this->log;
        return response()->json($msg);
    }

    //*** GET Request
    public function edit($id)
    {
        if(!Product::where('id',$id)->exists())
        {
            return redirect()->route('admin.dashboard')->with('unsuccess',__('Sorry the page does not exist.'));
        }
        $cats = Category::all();
        $data = Product::findOrFail($id);
        $sign = Currency::where('is_default','=',1)->first();
        $brand = Brands::where('status','=',1)->get();
        $store = User::where('is_vendor','=',2)->get();
        if($data->type == 'Digital')
            return view('admin.product.edit.digital',compact('cats','data','sign','brand','store'));
        elseif($data->type == 'License')
            return view('admin.product.edit.license',compact('cats','data','sign','brand','store'));
        else
            return view('admin.product.edit.physical',compact('cats','data','sign','brand','store'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
    //    dd($request->all());
    //    exit();

        //--- Validation Section
        $rules = [
               'file'       => 'mimes:zip',
                ];
        

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends


        //-- Logic Section
        $data = Product::findOrFail($id);
        $sign = Currency::where('is_default','=',1)->first();
        $input = $request->all();
            //Check Types
            if($request->type_check == 1)
            {
                $input['link'] = null;
            }
            else
            {
                if($data->file!=null){
                        if (file_exists(public_path().'/assets/files/'.$data->file)) {
                        unlink(public_path().'/assets/files/'.$data->file);
                    }
                }
                $input['file'] = null;
            }


            // Check Physical
            if($data->type == "Physical")
            {

                    //--- Validation Section
                    $rules = ['sku' => 'min:8|unique:products,sku,'.$id];

                    $validator = Validator::make($request->all(), $rules);

                    if ($validator->fails()) {
                        return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
                    }
                    //--- Validation Section Ends

                        // Check Condition
                        if ($request->product_condition_check == ""){
                            $input['product_condition'] = 0;
                        }

                        // Check Shipping Time
                        if ($request->shipping_time_check == ""){
                            $input['ship'] = null;
                        }

                        // Check Size

                        if(empty($request->size_check ))
                        {
                            $input['size'] = null;
                            $input['size_qty'] = null;
                            $input['size_price'] = null;
                        }
                        else{
                                if(in_array(null, $request->size) || in_array(null, $request->size_qty) || in_array(null, $request->size_price))
                                {
                                    $input['size'] = null;
                                    $input['size_qty'] = null;
                                    $input['size_price'] = null;
                                }
                                else
                                {

                                    if(in_array(0,$input['size_qty'])){
                                        return response()->json(array('errors' => [0 => 'Size Qty can not be 0.']));
                                    }

                                    $input['size'] = implode(',', $request->size);
                                    $input['size_qty'] = implode(',', $request->size_qty);
                                    $size_prices = $request->size_price;
                                    $s_price = array();
                                    foreach($size_prices as $key => $sPrice){
                                        $s_price[$key] = $sPrice / $sign->value;
                                    }

                                    $input['size_price'] = implode(',', $s_price);
                                    $size_previous_prices = $request->size_previous_price;
                                    $s_pre_price = array();
                                    foreach($size_previous_prices as $key => $item){
                                        $s_pre_price[$key] = $item / $sign->value;
                                    }
                                    $input['size_prevoius_price'] = implode(',', $s_pre_price);
                                }
                        }



                        // Check Whole Sale
            if(empty($request->whole_check ))
            {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
            }
            else{
                if(in_array(null, $request->whole_sell_qty) || in_array(null, $request->whole_sell_discount))
                {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
                }
                else
                {
                    $input['whole_sell_qty'] = implode(',', $request->whole_sell_qty);
                    $input['whole_sell_discount'] = implode(',', $request->whole_sell_discount);
                }
            }

                        // Check Color
                        if(empty($request->color_check ))
                        {
                            $input['color'] = null;
                        }
                        else{
                            if (!empty($request->color))
                             {
                                $input['color'] = implode(',', $request->color);
                             }
                            if (empty($request->color))
                             {
                                $input['color'] = null;
                             }
                        }

                        // Check Measure
                    if ($request->measure_check == "")
                     {
                        $input['measure'] = null;
                     }
            }


            // Check Seo
        if (empty($request->seo_check))
         {
            $input['meta_tag'] = null;
            $input['meta_description'] = null;
         }
         else {
        if (!empty($request->meta_tag))
         {
            $input['meta_tag'] = implode(',', $request->meta_tag);
         }
         }



        // Check License
        if($data->type == "License")
        {

        if(!in_array(null, $request->license) && !in_array(null, $request->license_qty))
        {
            $input['license'] = implode(',,', $request->license);
            $input['license_qty'] = implode(',', $request->license_qty);
        }
        else
        {
            if(in_array(null, $request->license) || in_array(null, $request->license_qty))
            {
                $input['license'] = null;
                $input['license_qty'] = null;
            }
            else
            {
                $license = explode(',,', $prod->license);
                $license_qty = explode(',', $prod->license_qty);
                $input['license'] = implode(',,', $license);
                $input['license_qty'] = implode(',', $license_qty);
            }
        }

        }
            // Check Features
            if(!in_array(null, $request->features) && !in_array(null, $request->colors))
            {
                    $input['features'] = implode(',', str_replace(',',' ',$request->features));
                    $input['colors'] = implode(',', str_replace(',',' ',$request->colors));
            }
            else
            {
                if(in_array(null, $request->features) || in_array(null, $request->colors))
                {
                    $input['features'] = null;
                    $input['colors'] = null;
                }
                else
                {
                    $features = explode(',', $data->features);
                    $colors = explode(',', $data->colors);
                    $input['features'] = implode(',', $features);
                    $input['colors'] = implode(',', $colors);
                }
            }

        //Product Tags
        if (!empty($request->tags))
         {
            $input['tags'] = implode(',', $request->tags);
         }
        if (empty($request->tags))
         {
            $input['tags'] = null;
         }


         $input['price'] = $input['price'] / $sign->value;
         $input['previous_price'] = $input['previous_price'] / $sign->value;

         // store filtering attributes for physical product
         $attrArr = [];
         if (!empty($request->category_id)) {
           $catAttrs = Attribute::where('attributable_id', $request->category_id)->where('attributable_type', 'App\Models\Category')->get();
           if (!empty($catAttrs)) {
             foreach ($catAttrs as $key => $catAttr) {
               $in_name = $catAttr->input_name;
               if ($request->has("$in_name")) {
                 $attrArr["$in_name"]["values"] = $request["$in_name"];
                 $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                 if ($catAttr->details_status) {
                   $attrArr["$in_name"]["details_status"] = 1;
                 } else {
                   $attrArr["$in_name"]["details_status"] = 0;
                 }
               }
             }
           }
         }

         if (!empty($request->subcategory_id)) {
           $subAttrs = Attribute::where('attributable_id', $request->subcategory_id)->where('attributable_type', 'App\Models\Subcategory')->get();
           if (!empty($subAttrs)) {
             foreach ($subAttrs as $key => $subAttr) {
               $in_name = $subAttr->input_name;
               if ($request->has("$in_name")) {
                 $attrArr["$in_name"]["values"] = $request["$in_name"];
                 $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                 if ($subAttr->details_status) {
                   $attrArr["$in_name"]["details_status"] = 1;
                 } else {
                   $attrArr["$in_name"]["details_status"] = 0;
                 }
               }
             }
           }
         }
         if (!empty($request->childcategory_id)) {
           $childAttrs = Attribute::where('attributable_id', $request->childcategory_id)->where('attributable_type', 'App\Models\Childcategory')->get();
           if (!empty($childAttrs)) {
             foreach ($childAttrs as $key => $childAttr) {
               $in_name = $childAttr->input_name;
               if ($request->has("$in_name")) {
                 $attrArr["$in_name"]["values"] = $request["$in_name"];
                 $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                 if ($childAttr->details_status) {
                   $attrArr["$in_name"]["details_status"] = 1;
                 } else {
                   $attrArr["$in_name"]["details_status"] = 0;
                 }
               }
             }
           }
         }



         if (empty($attrArr)) {
           $input['attributes'] = NULL;
         } else {
           $jsonAttr = json_encode($attrArr);
           $input['attributes'] = $jsonAttr;
         }
         unset($input['photo']);
         unset($input['thumbnail']);
         $data->update($input);
        //-- Logic Section Ends


        // $prod = Product::find($data->id);
        // // Set SLug
        // $prod->slug = Str::slug($data->name,'-');

        // $prod->update();


        //--- Redirect Section
        $msg = 'Product Updated Successfully.<a href="'.route('admin-prod-index').'">View Product Lists.</a>';
        return response()->json($msg);
        //--- Redirect Section Ends
    }


    //*** GET Request
    public function feature($id)
    {
            $data = Product::findOrFail($id);
            return view('admin.product.highlight',compact('data'));
    }

    //*** POST Request
    public function featuresubmit(Request $request, $id)
    {
        //-- Logic Section
            $data = Product::findOrFail($id);
            $input = $request->all();
            if($request->featured == "")
            {
                $input['featured'] = 0;
            }
            if($request->hot == "")
            {
                $input['hot'] = 0;
            }
            if($request->best == "")
            {
                $input['best'] = 0;
            }
            if($request->top == "")
            {
                $input['top'] = 0;
            }
            if($request->latest == "")
            {
                $input['latest'] = 0;
            }
            if($request->big == "")
            {
                $input['big'] = 0;
            }
            if($request->trending == "")
            {
                $input['trending'] = 0;
            }
            if($request->sale == "")
            {
                $input['sale'] = 0;
            }
            if($request->is_discount == "")
            {
                $input['is_discount'] = 0;
                $input['discount_date'] = null;
            }

            $data->update($input);
        //-- Logic Section Ends

        //--- Redirect Section
        $msg = 'Highlight Updated Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends

    }
    public function boosting($id)
    {
            $data = Product::findOrFail($id);
            return view('admin.product.boosting',compact('data'));
    }
    public function boostingSubmit(Request $request, $id)
    {
        $prod = Product::find($id);
        $prod->category_boost = $request->category_boost;
        $prod->brand_boost = $request->brand_boost;
        $prod->vendor_boost = $request->vendor_boost;
        $prod->save();
        $msg = 'Boosting Updated Successfully.';
        return response()->json($msg);
    }
    //*** GET Request
    public function destroy($id)
    {

        $data = Product::findOrFail($id);
        if($data->galleries->count() > 0)
        {
            foreach ($data->galleries as $gal) {
                    if (file_exists(public_path().'/assets/images/galleries/'.$gal->photo)) {
                        unlink(public_path().'/assets/images/galleries/'.$gal->photo);
                    }
                $gal->delete();
            }

        }

        if($data->reports->count() > 0)
        {
            foreach ($data->reports as $gal) {
                $gal->delete();
            }
        }

        if($data->ratings->count() > 0)
        {
            foreach ($data->ratings  as $gal) {
                $gal->delete();
            }
        }
        if($data->wishlists->count() > 0)
        {
            foreach ($data->wishlists as $gal) {
                $gal->delete();
            }
        }
        if($data->clicks->count() > 0)
        {
            foreach ($data->clicks as $gal) {
                $gal->delete();
            }
        }
        if($data->comments->count() > 0)
        {
            foreach ($data->comments as $gal) {
            if($gal->replies->count() > 0)
            {
                foreach ($gal->replies as $key) {
                    $key->delete();
                }
            }
                $gal->delete();
            }
        }

        if($data->photo != null)
        {
            $imageExist = Product::where('photo',$data->photo)->where('id','!=',$data->id)->first();
            if ($imageExist == null) {
                if (file_exists(public_path().'/assets/images/products/'.$data->photo)) {
                    unlink(public_path().'/assets/images/products/'.$data->photo);
                }
            }

        }

        if (file_exists(public_path().'/assets/images/thumbnails/'.$data->thumbnail) && $data->thumbnail != "") {
            unlink(public_path().'/assets/images/thumbnails/'.$data->thumbnail);
        }

        if($data->file != null){
            if (file_exists(public_path().'/assets/files/'.$data->file)) {
                unlink(public_path().'/assets/files/'.$data->file);
            }
        }
        $data->delete();
        //--- Redirect Section
        $msg = 'Product Deleted Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends

// PRODUCT DELETE ENDS
    }

    public function getAttributes(Request $request) {
      $model = '';
      if ($request->type == 'category') {
        $model = 'App\Models\Category';
      } elseif ($request->type == 'subcategory') {
        $model = 'App\Models\Subcategory';
      } elseif ($request->type == 'childcategory') {
        $model = 'App\Models\Childcategory';
      }

      $attributes = Attribute::where('attributable_id', $request->id)->where('attributable_type', $model)->get();
      $attrOptions = [];
      foreach ($attributes as $key => $attribute) {
        $options = AttributeOption::where('attribute_id', $attribute->id)->get();
        $attrOptions[] = ['attribute' => $attribute, 'options' => $options];
      }
      return response()->json($attrOptions);
    }
    public function updateStatus(Request $request)
    {
        $check = $request->check;
        // dd($check);
        // return response()->json($check);
        if ($check == 'true')
        {
            $id = $request->id;
            $product= Product::findOrFail($id);
            $product->stock = null;
            $product->save();
            return response()->json('true');
        }
        else
        {
            $id = $request->id;
            $product= Product::findOrFail($id);
            $product->stock = 0;
            $product->save();
            return response()->json('false');
        }
    }
    public function addDuplicate()
    {
        $data = request()->id;
        foreach ($data as $id) {
            $product = Product::findOrFail($id);
            $dupliProduct = new Product;
            $dupliProduct = $product->replicate();
            $str = $dupliProduct->category->name;
            $sku = substr($str,0, 3).'-'.random_int (100000, 999999);
            $dupliProduct->sku = $sku;
            $dupliProduct->slug = Str::slug($dupliProduct->name,'-').'-'.strtolower($dupliProduct->sku);
            $dupliProduct->save();
            // $gallery = new Gallery;
            // $gallery->product_id = $dupliProduct->id;
            // $gallery->photo = $dupliProduct->photo;
            // $gallery->save();
        }
        return response()->json('Product Add Successfully');
    }
    public function deleteProduct()
    {
        $ids = request()->id;
        foreach ($ids as $id) {
            $data = Product::findOrFail($id);
            if($data->galleries->count() > 0)
            {
                foreach ($data->galleries as $gal) {
                        if (file_exists(public_path().'/assets/images/galleries/'.$gal->photo)) {
                            unlink(public_path().'/assets/images/galleries/'.$gal->photo);
                        }
                    $gal->delete();
                }

            }
            if($data->reports->count() > 0)
            {
                foreach ($data->reports as $gal) {
                    $gal->delete();
                }
            }

            if($data->ratings->count() > 0)
            {
                foreach ($data->ratings  as $gal) {
                    $gal->delete();
                }
            }
            if($data->wishlists->count() > 0)
            {
                foreach ($data->wishlists as $gal) {
                    $gal->delete();
                }
            }
            if($data->clicks->count() > 0)
            {
                foreach ($data->clicks as $gal) {
                    $gal->delete();
                }
            }
            if($data->comments->count() > 0)
            {
                foreach ($data->comments as $gal) {
                if($gal->replies->count() > 0)
                {
                    foreach ($gal->replies as $key) {
                        $key->delete();
                    }
                }
                    $gal->delete();
                }
            }

            if($data->photo != null)
            {
                $imageExist = Product::where('photo',$data->photo)->where('id','!=',$data->id)->first();
                if ($imageExist == null) {
                    if (file_exists(public_path().'/assets/images/products/'.$data->photo)) {
                        unlink(public_path().'/assets/images/products/'.$data->photo);
                    }
                }

            }

            if (file_exists(public_path().'/assets/images/thumbnails/'.$data->thumbnail) && $data->thumbnail != "") {
                unlink(public_path().'/assets/images/thumbnails/'.$data->thumbnail);
            }

            if($data->file != null){
                if (file_exists(public_path().'/assets/files/'.$data->file)) {
                    unlink(public_path().'/assets/files/'.$data->file);
                }
            }
            $data->delete();
        }
        return response()->json('Products Deleted Successfully');
    }
    public function getFolder()
    {
        // $folders = File::directories(public_path().'/assets/images');
        // $files = File::files(public_path().'/assets/images');
        $files = [];
        $allimg = [];
        $curPath = public_path().'/assets/images';
        $filesInFolder = \File::directories($curPath);
        $img = \File::files($curPath);
        foreach($filesInFolder as $path)
        {
            $files[] = pathinfo($path);
        }
        foreach($img as $path)
        {
            $allimg[] = pathinfo($path);
        }
        return view('admin.bulkimage.index',compact('files','curPath','allimg'));
    }
    public function getCurFolder()
    {
        $curPath = request()->path;
        $files = [];
        $allimg = [];
        $filesInFolder = \File::directories($curPath);
        $img = \File::files($curPath);
        foreach($filesInFolder as $path)
        {
            $files[] = pathinfo($path);
        }
        foreach($img as $path)
        {
            $allimg[] = pathinfo($path);
        }
        return view('admin.bulkimage.partials.sub_folders',compact('files','curPath','allimg'))->render();
        // return response()->json($files);
    }
    public function createFolder()
    {
        $folderName = request()->name;
        $path = request()->path;
        if (! File::exists($path.'/'.$folderName)) {
            File::makeDirectory($path.'/'.$folderName);
        }
        return redirect()->route('admin-bulk-image');
    }
    public function uploadImg()
    {
        ini_set('max_execution_time', 1180);
        $path = request()->path;
        $files= request()->file('imgs');
        if(request()->file('imgs')){
            foreach($files as $file){
                $name=$file->getClientOriginalName();
                $file->move($path,$name);
            }
        }
        // foreach ($files as  $file){
        //         $name = $file->getClientOriginalName();
        //         $file->move($path,$name);
        // }
        return redirect()->route('admin-bulk-image');
    }
    public function deleteImg()
    {
        $path = request()->path;
        foreach ($path as  $key => $img){
            if (file_exists($img)) {
                unlink($img);
            }
        }
        return response()->json(['status' => 'Images Delete SuccessFull']);
    }
    public function getComission()
    {
        $id = request()->id;
        $ccat = Childcategory::findOrFail($id);
        $commision = $ccat->comission;
        return response()->json($commision);
    }
    public function bulkhighlight(Request $request)
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
        $sku=$this->CsvGetColumnIndex('sku',$header);
        $featured=$this->CsvGetColumnIndex('featured',$header);
        $best=$this->CsvGetColumnIndex('best',$header);
        $top=$this->CsvGetColumnIndex('top',$header);
        $hot=$this->CsvGetColumnIndex('hot',$header);
        $latest=$this->CsvGetColumnIndex('latest',$header);
        $big=$this->CsvGetColumnIndex('big',$header);
        $trending=$this->CsvGetColumnIndex('trending',$header);
        $sale=$this->CsvGetColumnIndex('sale',$header);

        if($this->log!=""){
            return $this->log;
        }
        while (($line = fgetcsv($file)) !== FALSE) {
                //Checking SKU not exist in column (Insert)
                if(Product::where('sku',$line[$sku])->exists())
                {
                    $data = Product::where('sku',$line[$sku])->first();
                    if($line[$featured] != null || $line[$featured] != '')
                    {
                        $data->featured = $line[$featured];
                    }
                    if($line[$best] != null || $line[$best] != '')
                    {
                        $data->best = $line[$best] ;
                    }
                    if($line[$top] != null || $line[$top] != '')
                    {
                        $data->top = $line[$top] ;
                    }
                    if($line[$hot] != null || $line[$hot] != '')
                    {
                        $data->hot = $line[$hot] ;
                    }
                    if($line[$latest] != null || $line[$latest] != '')
                    {
                        $data->latest = $line[$latest] ;
                    }
                    if($line[$big] != null || $line[$big] != '')
                    {
                        $data->big = $line[$big] ;
                    }
                    if($line[$trending] != null || $line[$trending] != '')
                    {
                        $data->trending = $line[$trending] ;
                    }
                    if($line[$sale] != null || $line[$sale] != '')
                    {
                        $data->sale = $line[$sale] ;
                    }

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

        $msg = 'Bulk Highlight File Imported Successfully'. $this->log;
        return response()->json($msg);
    }
}
