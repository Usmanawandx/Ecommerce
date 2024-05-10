<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CMSPage;
use App\Models\Product;
use Illuminate\Http\Request;
use Datatables;
use File;

class CmsPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        return view('admin.cmspage.index');
    }
    public function create()
    {
        $prods = Product::where('status',1)->orderBy('id','desc')->get();
        return view('admin.cmspage.create',compact('prods'));
    }
    public function getProduct()
    {
        $searchValue = request()->q;
        $prods = Product::Where('sku', 'like', '%' .$searchValue . '%')->get(['id','sku as text']);
        $data['results'] = $prods;
        return  response()->json($data);
    }
    public function datatables()
    {
        $datas = CMSPage::orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->addColumn('title', function(CMSPage $data) {
                                return $data->page_title;
                            })
                            ->addColumn('slug', function(CMSPage $data) {
                                return '<a href="'.route('front.cmspage',$data->page_slug).'" target="blank">'.$data->page_slug.'</a>';
                            })
                            ->addColumn('action', function(CMSPage $data) {
                                return '<div class="action-list"><a href="javascript:;" data-href="' . route('admin-cmspage-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                                // <a href="' . route('admin-cmspage-edit',$data->id) . '"> <i class="fas fa-edit"></i>Edit</a>
                            })
                            ->rawColumns(['title','slug','action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    public function store(Request $request)
    {
        $page = new CMSPage;
        $page->page_title = $request->title;
        $page->page_slug = $request->slug;
        if ($request->sliders){
            if (!File::exists('assets/images/sliders/cmspage')) {
                File::makeDirectory('assets/images/sliders/cmspage');
            }
            $path =  public_path('assets/images/sliders/cmspage/');
            $sliders = [];
            foreach($request->sliders as $slider)
            {
                $name = time().str_replace(' ', '', $slider->getClientOriginalName());
                $slider->move($path,$name);
                array_push($sliders,$name);
            }
            $sliders = implode(",",$sliders);
            $page->top_sliders = $sliders;
        }
        if($request->slider_status)
        {
            $page->slider_status = $request->slider_status;
        }
        $page->block1_title = $request->block1title;
        if($request->block1){

            $ids = [];
            foreach($request->block1 as $id)
            {
                array_push($ids,$id);
            }
            $ids = implode(",",$ids);
            $page->block1_skus = $ids;
        }
        if($request->banner1){

            if (!File::exists('assets/images/banners/cmspage')) {
                File::makeDirectory('assets/images/banners/cmspage');
            }
            $path =  public_path('assets/images/banners/cmspage/');
            $banners = [];
            foreach($request->banner1 as $banner)
            {
                $name = time().str_replace(' ', '', $banner->getClientOriginalName());
                $banner->move($path,$name);
                array_push($banners,$name);
            }
            $banners = implode(",",$banners);
            $page->block1_banner = $banners;
        }
        if($request->block1_status)
        {
            $page->block1_status = $request->block1_status;
        }
        $page->block2_title = $request->block2title;
        if($request->block2){

            $ids = [];
            foreach($request->block2 as $id)
            {
                array_push($ids,$id);
            }
            $ids = implode(",",$ids);
            $page->block2_skus = $ids;
        }
        if($request->banner2){

            if (!File::exists('assets/images/banners/cmspage')) {
                File::makeDirectory('assets/images/banners/cmspage');
            }
            $path =  public_path('assets/images/banners/cmspage/');
            $banners = [];
            foreach($request->banner2 as $banner)
            {
                $name = time().str_replace(' ', '', $banner->getClientOriginalName());
                $banner->move($path,$name);
                array_push($banners,$name);
            }
            $banners = implode(",",$banners);
            $page->block2_banner = $banners;
        }
        if($request->block2_status)
        {
            $page->block2_status = $request->block2_status;
        }
        $page->block3_title = $request->block3title;
        if($request->block3){

            $ids = [];
            foreach($request->block3 as $id)
            {
                array_push($ids,$id);
            }
            $ids = implode(",",$ids);
            $page->block3_skus = $ids;
        }
        if($request->banner3){

            if (!File::exists('assets/images/banners/cmspage')) {
                File::makeDirectory('assets/images/banners/cmspage');
            }
            $path =  public_path('assets/images/banners/cmspage/');
            $banners = [];
            foreach($request->banner3 as $banner)
            {
                $name = time().str_replace(' ', '', $banner->getClientOriginalName());
                $banner->move($path,$name);
                array_push($banners,$name);
            }
            $banners = implode(",",$banners);
            $page->block3_banner = $banners;
        }
        if($request->block3_status)
        {
            $page->block3_status = $request->block3_status;
        }
        $page->block4_title = $request->block4title;
        if($request->block4){

            $ids = [];
            foreach($request->block4 as $id)
            {
                array_push($ids,$id);
            }
            $ids = implode(",",$ids);
            $page->block4_skus = $ids;
        }
        if($request->banner4){

            if (!File::exists('assets/images/banners/cmspage')) {
                File::makeDirectory('assets/images/banners/cmspage');
            }
            $path =  public_path('assets/images/banners/cmspage/');
            $banners = [];
            foreach($request->banner4 as $banner)
            {
                $name = time().str_replace(' ', '', $banner->getClientOriginalName());
                $banner->move($path,$name);
                array_push($banners,$name);
            }
            $banners = implode(",",$banners);
            $page->block4_banner = $banners;
        }
        if($request->block4_status)
        {
            $page->block4_status = $request->block4_status;
        }
        $page->block5_title = $request->block5title;
        if($request->block5){

            $ids = [];
            foreach($request->block5 as $id)
            {
                array_push($ids,$id);
            }
            $ids = implode(",",$ids);
            $page->block5_skus = $ids;
        }
        if($request->banner5){

            if (!File::exists('assets/images/banners/cmspage')) {
                File::makeDirectory('assets/images/banners/cmspage');
            }
            $path =  public_path('assets/images/banners/cmspage/');
            $banners = [];
            foreach($request->banner5 as $banner)
            {
                $name = time().str_replace(' ', '', $banner->getClientOriginalName());
                $banner->move($path,$name);
                array_push($banners,$name);
            }
            $banners = implode(",",$banners);
            $page->block5_banner = $banners;
        }
        if($request->block5_status)
        {
            $page->block5_status = $request->block5_status;
        }
        $page->block6_title = $request->block6title;
        if($request->block6){

            $ids = [];
            foreach($request->block6 as $id)
            {
                array_push($ids,$id);
            }
            $ids = implode(",",$ids);
            $page->block6_skus = $ids;
        }
        if($request->banner6){

            if (!File::exists('assets/images/banners/cmspage')) {
                File::makeDirectory('assets/images/banners/cmspage');
            }
            $path =  public_path('assets/images/banners/cmspage/');
            $banners = [];
            foreach($request->banner6 as $banner)
            {
                $name = time().str_replace(' ', '', $banner->getClientOriginalName());
                $banner->move($path,$name);
                array_push($banners,$name);
            }
            $banners = implode(",",$banners);
            $page->block6_banner = $banners;
        }
        if($request->block6_status)
        {
            $page->block6_status = $request->block6_status;
        }
        if($request->secheck == "")
         {
            $page->meta_title = null;
            $page->meta_description = null;
         }
         else
         {
            if (!empty($request->meta_tag))
            {
                $page->meta_title = implode(',', $request->meta_tag);
            }
            $page->meta_description = $request->meta_description;
         }
         $page->save();
         return "success";
    }
    public function edit($id)
    {
        $data = CMSPage::findOrFail($id);
        return view('admin.cmspage.edit',compact('data'));
    }
    public function destroy($id)
    {
        $data = CMSPage::findOrFail($id);
        if ($data->top_sliders){
            $sliders = explode(',',$data->top_sliders);
            foreach($sliders as $slider)
            {
                if (file_exists(public_path().'/assets/images/sliders/cmspage/'.$slider)){
                    unlink(public_path().'/assets/images/sliders/cmspage/'.$slider);
                }
            }
        }

        if ($data->block1_banner){
            $banners = explode(',',$data->block1_banner);
            foreach($banners as $banner)
            {
                if (file_exists(public_path().'/assets/images/banners/cmspage/'.$banner)){
                    unlink(public_path().'/assets/images/banners/cmspage/'.$banner);
                }
            }
        }
        if ($data->block2_banner){
            $banners = explode(',',$data->block2_banner);
            foreach($banners as $banner)
            {
                if (file_exists(public_path().'/assets/images/banners/cmspage/'.$banner)){
                    unlink(public_path().'/assets/images/banners/cmspage/'.$banner);
                }
            }
        }
        if ($data->block3_banner){
            $banners = explode(',',$data->block3_banner);
            foreach($banners as $banner)
            {
                if (file_exists(public_path().'/assets/images/banners/cmspage/'.$banner)){
                    unlink(public_path().'/assets/images/banners/cmspage/'.$banner);
                }
            }
        }
        if ($data->block4_banner){
            $banners = explode(',',$data->block4_banner);
            foreach($banners as $banner)
            {
                if (file_exists(public_path().'/assets/images/banners/cmspage/'.$banner)){
                    unlink(public_path().'/assets/images/banners/cmspage/'.$banner);
                }
            }
        }
        if ($data->block5_banner){
            $banners = explode(',',$data->block5_banner);
            foreach($banners as $banner)
            {
                if (file_exists(public_path().'/assets/images/banners/cmspage/'.$banner)){
                    unlink(public_path().'/assets/images/banners/cmspage/'.$banner);
                }
            }
        }
        if ($data->block6_banner){
            $banners = explode(',',$data->block6_banner);
            foreach($banners as $banner)
            {
                if (file_exists(public_path().'/assets/images/banners/cmspage/'.$banner)){
                    unlink(public_path().'/assets/images/banners/cmspage/'.$banner);
                }
            }
        }
        $data->delete();
        //--- Redirect Section
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }
}
