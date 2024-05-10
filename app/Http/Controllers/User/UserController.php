<?php

namespace App\Http\Controllers\User;

use App\Classes\GeniusMailer;
use App\Models\VendorOrder;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Subscription;
use App\Models\Generalsetting;
use App\Models\UserSubscription;
use App\Models\FavoriteSeller;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Directprofit;
use App\Models\InDirectprofit;
use App\Models\WithdrawRequest;
use App\Models\KYC;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function activate_user($id){
        $affected = DB::table('users')->where("id","=",$id)->update(array('referal_status' => 1));
        if($affected > 0){
            return response()->json(array('success' => "true"));
        }else{
            return response()->json(array('success' => "false"));
        }
    }
    public  function kyc(){
        $kyc_information = KYC::where("user_id","=",Auth::user()->id)->get();
        if(count($kyc_information) == 0)
            $kyc_information = null;

        return view('user.kyc',compact('kyc_information'));
    }
    public  function kyc_store(Request $request){
        $kyc = new KYC();
        $kyc->name = $request->nic_name;
        $kyc->father_name = $request->father_name;
        $kyc->name = $request->nic_name;
        $kyc->dob = $request->dob;
        $kyc->cnic = $request->cnic;
        $kyc->address = $request->address;
        $kyc->user_id = Auth::user()->id;
        if ($file = $request->file('cnic_front'))
        {
            $name = time().str_replace(' ', '', $file->getClientOriginalName());
            $file->move('assets/images/users/',$name);
            $kyc->nic_front = $name;
        }if ($file = $request->file('cnic_back'))
        {
            $name = time().str_replace(' ', '', $file->getClientOriginalName());
            $file->move('assets/images/users/',$name);
            $kyc->nic_back = $name;
        }
        if($kyc->save()){
            return redirect()->back()->with('message',"Legal infromation successfully saved.");
        }
    }
    public function distribute_commision_view(){
        return view('user.withdraw.comission_distribute');
    }


    public  function show_tree_view($id){

        dd($this->tree_view($id));

    }

    public function tree_view($id){
        $tree_array = array();
        $first_user = User::where("id","=",$id)->get();
        foreach($first_user as $f){
            $tree_array["main"][] = $f;
            $refers_c = User::where("refer_by","=",$f->refer_id)->get();
            foreach ($refers_c as $tt){
                $tree_array["main"]["parent"][] = $tt;
                $tree_array["main"]["parent"]["child"][] = $this->tree_view($tt->id);
            }
        }
        return $tree_array;
    }

    public function  set_profit_distribution(Request $request){
        $investors = Deposit::all();
        foreach ($investors as $investor){
            $amount = ($investor->amount * $request->percentage);
            $_investor = new Directprofit();
            $_investor->user_id = $investor->user_id;
            $_investor->deposit_id = $investor->id;
            $_investor->profit = $amount;
            $_investor->comission_percent = $request->percentage;
            $_investor->is_profit = 1;
            if($_investor->save()){
                $this->_ProfitDistribution($investor->id,$investor->user_id,$amount);
            }
        }
        return redirect()->back()->with('message',"Profit Successfully Shared");
    }
    public function index()
    {
        if(Auth::user()->is_vendor == 11){
            $user = Auth::user();
            $referel = User::where("refer_by","=",Auth::user()->refer_id)->get();
            $count_team = count($referel);
            foreach ($referel as $ref){
                $count_team += $this->GetReferalCount($ref->refer_id);
            }
            $teams = $this->GetReferalTeam(Auth::user()->refer_id);
            $team = $count_team;
            $direct = count($referel);
            $mydeposit = Deposit::where("user_id","=",Auth::user()->id)->where("is_verify","=","1")->sum('amount');
            $roi = Directprofit::where("user_id","=",Auth::user()->id)->sum("profit");
            $profit_shared = InDirectprofit::where("user_id","=",Auth::user()->id)->sum("profit");
            $direct_commission = Directprofit::where("user_id","=",Auth::user()->id)->sum("amount");
            $indirect_commission = InDirectprofit::where("user_id","=",Auth::user()->id)->sum("amount");
            $balance = ($direct_commission + $indirect_commission);
            $references = User::where("refer_by","=",Auth::user()->refer_id)->get();
            $pending = VendorOrder::where('user_id','=',$user->id)->where('status','=','pending')->get();
            $processing = VendorOrder::where('user_id','=',$user->id)->where('status','=','processing')->get();
            $completed = VendorOrder::where('user_id','=',$user->id)->where('status','=','completed')->get();
            return view('vendor.index',compact('roi','profit_shared','balance','direct_commission','indirect_commission','mydeposit','direct','team','user','pending','processing','completed','references'));
        }else{
            $user = Auth::user();
            return view('user.dashboard',compact('user'));
        }
    }
    public function deposit(){
        $sign = "dsfadsf";
        return view('user.withdraw.deposit',compact('sign'));
    }
    public function deposit_store(Request $request){
        $dposit = new Deposit();
        $dposit->deposit_date = $request->date;
        $dposit->bank_name = $request->bank_name;
        $dposit->account_title = $request->account_title;
        $dposit->account_no = $request->iban_no;
        $dposit->iban_no = $request->account_no;
        $dposit->amount = $request->amount;
        $dposit->slip_no = $request->slip_no;
        $dposit->remarks = $request->remarks;
        $dposit->payment_mode = $request->payment_mode[0];
        $dposit->epin = $request->e_pin;
        $dposit->status = "pending";
        $dposit->deposit_date = $request->deposit_date;
        $dposit->user_id = Auth::user()->id;
        if($dposit->save()){
            $this->ComissionDistribution($dposit->id,$request->amount);
        }
        return redirect()->back()->with('message', 'Thanks for your deposit to ECP, Your account will be activate with in 48 working hours after bank verification');
    }
    public function ProfitDistribution(){
        $commision = [];
        $main_user = User::where("refer_id","=",Auth::user()->refer_id)->firstOrFail();
        $direct_user = User::where("refer_by","=",Auth::user()->refer_id)->get();
        foreach ($direct_user as $dir_user) {
            $commision[$main_user->name."__10%"][] = $dir_user->name;
            $ind_one = User::where("refer_by","=",$dir_user->refer_id)->get();
            foreach ($ind_one as $ind_one_) {
                $commision[$dir_user->name."__10%"][$main_user->name."__8%"][] = $ind_one_->name;
                $ind_two = User::where("refer_by","=",$ind_one_->refer_id)->get();
                foreach ($ind_two as $ind_two_) {
                    $commision[$ind_one_->name."__10%"][$dir_user->name."__8%"][$main_user->name."__6%"][] = $ind_two_->name;
                    $ind_three = User::where("refer_by","=",$ind_two_->refer_id)->get();
                    foreach ($ind_three as $ind_three_){
                        $commision[$ind_two_->name."__10%"][$ind_one_->name."__8%"][$dir_user->name."__6%"][$main_user->name."__4%"][] = $ind_three_->name;
                        $ind_four = User::where("refer_by","=",$ind_three_->refer_id)->get();
                        foreach ($ind_four as $ind_four__){
                            $commision[$ind_three_->name."__10%"][$ind_two_->name."__8%"][$ind_one_->name."__6%"][$dir_user->name."__4%"][$main_user->name."__4%"][] = $ind_four__->name;
                            $ind_five = User::where("refer_by","=",$ind_four__->refer_id)->get();
                            foreach ($ind_five as $ind_five__){
                                $commision[$ind_four__->name."__10%"][$ind_three_->name."__8%"][$ind_two_->name."__6%"][$ind_one_->name."__4%"][$dir_user->name."__4%"][$main_user->name."__3%"][] = $ind_five__->name;
                                $ind_six = User::where("refer_by","=",$ind_five__->refer_id)->get();
                                foreach ($ind_six as $ind_six__){
                                    $commision[$ind_five__->name."__10%"][$ind_four__->name."__8%"][$ind_three_->name."__6%"][$ind_two_->name."__4%"][$ind_one_->name."__4%"][$dir_user->name."__3%"][$main_user->name."__3%"][] = $ind_six__->name;
                                    $ind_seven = $ind_six = User::where("refer_by","=",$ind_six__->refer_id)->get();
                                    foreach ($ind_seven as $ind_seven__){
                                        $commision[$ind_six__->name."__10%"][$ind_five__->name."__8%"][$ind_four__->name."__6%"][$ind_three_->name."__4%"][$ind_two_->name."__4%"][$ind_one_->name."__3%"][$dir_user->name."__3%"][$main_user->name."__2%"][] = $ind_seven__->name;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $commision;
    }
    public function  check_user_deposit($user_id){
        $result = Deposit::where("user_id","=",$user_id)->get();
        if(count($result) > 0){
            return true;
        }else{
            return  false;
        }
    }
    public function ComissionDistribution($deposit_id,$amount){
        $commision = [];
        $refer_by = User::where("refer_id","=",Auth::user()->refer_by)->get();
        foreach ($refer_by as $dir_user) {
            $deposit_user = new Directprofit();
            $deposit_user->user_id = $dir_user->id;
            $deposit_user->deposit_id = $deposit_id;
            $deposit_user->amount = ($amount * 0.05);
            $deposit_user->comission_percent = 0.05;
            $deposit_user->save();
            $ind_one = User::where("refer_id","=",$dir_user->refer_by)->get();
            if(count($ind_one) > 0){
                $deposit_user = new InDirectprofit();
                $deposit_user->user_id = $ind_one[0]->id;
                $deposit_user->deposit_id = $deposit_id;
                $deposit_user->amount = ($amount * 0.02);
                $deposit_user->comission_percent = 0.02;
                $deposit_user->save();
                $ind_two = User::where("refer_id","=",$ind_one[0]->refer_by)->get();
                if(count($ind_two) > 0) {
                    $deposit_user = new InDirectprofit();
                    $deposit_user->user_id = $ind_two[0]->id;
                    $deposit_user->deposit_id = $deposit_id;
                    $deposit_user->amount = ($amount * 0.01);
                    $deposit_user->comission_percent = 0.01;
                    $deposit_user->save();
                    $ind_three = User::where("refer_id","=",$ind_two[0]->refer_by)->get();
                    if(count($ind_three) > 0){
                        $deposit_user = new InDirectprofit();
                        $deposit_user->user_id = $ind_three[0]->id;
                        $deposit_user->deposit_id = $deposit_id;
                        $deposit_user->amount = ($amount * 0.01);
                        $deposit_user->comission_percent = 0.01;
                        $deposit_user->save();
                        $ind_four = User::where("refer_id","=",$ind_three[0]->refer_by)->get();
                        if(count($ind_four) > 0){
                            $deposit_user = new InDirectprofit();
                            $deposit_user->user_id = $ind_four[0]->id;
                            $deposit_user->deposit_id = $deposit_id;
                            $deposit_user->amount = ($amount * 0.005);
                            $deposit_user->comission_percent = 0.005;
                            $deposit_user->save();
                            $ind_five = User::where("refer_id","=",$ind_four[0]->refer_by)->get();
                            if(count($ind_five) > 0){
                                $deposit_user = new InDirectprofit();
                                $deposit_user->user_id = $ind_five[0]->id;
                                $deposit_user->deposit_id = $deposit_id;
                                $deposit_user->amount = ($amount * 0.005);
                                $deposit_user->comission_percent = 0.005;
                                $deposit_user->save();
                                $ind_six = User::where("refer_id","=",$ind_five[0]->refer_by)->get();
                                if(count($ind_six) > 0){
                                    $deposit_user = new InDirectprofit();
                                    $deposit_user->user_id = $ind_six[0]->id;
                                    $deposit_user->deposit_id = $deposit_id;
                                    $deposit_user->amount = ($amount * 0.0025);
                                    $deposit_user->comission_percent = 0.0025;
                                    $deposit_user->save();
                                    $ind_seven = User::where("refer_id","=",$ind_six[0]->refer_by)->get();
                                    if(count($ind_seven) > 0){
                                        $deposit_user = new InDirectprofit();
                                        $deposit_user->user_id = $ind_seven[0]->id;
                                        $deposit_user->deposit_id = $deposit_id;
                                        $deposit_user->amount = ($amount * 0.0025);
                                        $deposit_user->comission_percent = 0.0025;
                                        $deposit_user->save();
                                        $ind_eight = User::where("refer_id","=",$ind_seven[0]->refer_by)->get();
                                        if(count($ind_eight) > 0){
//                                            $deposit_user = new InDirectprofit();
//                                            $deposit_user->user_id = $ind_eight[0]->id;
//                                            $deposit_user->deposit_id = $deposit_id;
//                                            $deposit_user->amount = ($amount * 0.0025);
//                                            $deposit_user->comission_percent = 0.0025;
//                                            $deposit_user->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $commision;
    }
    public function _ProfitDistribution($deposit_id,$user_id,$amount){
        $investor_detail = User::where("id","=",$user_id)->firstOrFail();
        $refer_by = User::where("refer_id","=",$investor_detail->refer_by)->get();
        foreach ($refer_by as $dir_user) {
            $deposit_user = new Directprofit();
            $deposit_user->user_id = $dir_user->id;
            $deposit_user->deposit_id = $deposit_id;
            $deposit_user->profit = ($amount * 0.10);
            $deposit_user->comission_percent = 0.10;
            $deposit_user->is_profit = 1;
            $deposit_user->save();
            $ind_one = User::where("refer_id","=",$dir_user->refer_by)->get();
            if(count($ind_one) > 0){
                $deposit_user = new InDirectprofit();
                $deposit_user->user_id = $ind_one[0]->id;
                $deposit_user->deposit_id = $deposit_id;
                $deposit_user->profit = ($amount * 0.08);
                $deposit_user->comission_percent = 0.08;
                $deposit_user->is_profit = 1;
                $deposit_user->save();
                $ind_two = User::where("refer_id","=",$ind_one[0]->refer_by)->get();
                if(count($ind_two) > 0) {
                    $deposit_user = new InDirectprofit();
                    $deposit_user->user_id = $ind_two[0]->id;
                    $deposit_user->deposit_id = $deposit_id;
                    $deposit_user->profit = ($amount * 0.06);
                    $deposit_user->comission_percent = 0.06;
                    $deposit_user->is_profit = 1;
                    $deposit_user->save();
                    $ind_three = User::where("refer_id","=",$ind_two[0]->refer_by)->get();
                    if(count($ind_three) > 0){
                        $deposit_user = new InDirectprofit();
                        $deposit_user->user_id = $ind_three[0]->id;
                        $deposit_user->deposit_id = $deposit_id;
                        $deposit_user->profit = ($amount * 0.04);
                        $deposit_user->comission_percent = 0.04;
                        $deposit_user->is_profit = 1;
                        $deposit_user->save();
                        $ind_four = User::where("refer_id","=",$ind_three[0]->refer_by)->get();
                        if(count($ind_four) > 0){
                            $deposit_user = new InDirectprofit();
                            $deposit_user->user_id = $ind_four[0]->id;
                            $deposit_user->deposit_id = $deposit_id;
                            $deposit_user->profit = ($amount * 0.04);
                            $deposit_user->comission_percent = 0.04;
                            $deposit_user->save();
                            $ind_five = User::where("refer_id","=",$ind_four[0]->refer_by)->get();
                            if(count($ind_five) > 0){
                                $deposit_user = new InDirectprofit();
                                $deposit_user->user_id = $ind_five[0]->id;
                                $deposit_user->deposit_id = $deposit_id;
                                $deposit_user->profit = ($amount * 0.03);
                                $deposit_user->comission_percent = 0.03;
                                $deposit_user->save();
                                $ind_six = User::where("refer_id","=",$ind_five[0]->refer_by)->get();
                                if(count($ind_six) > 0){
                                    $deposit_user = new InDirectprofit();
                                    $deposit_user->user_id = $ind_six[0]->id;
                                    $deposit_user->deposit_id = $deposit_id;
                                    $deposit_user->profit = ($amount * 0.03);
                                    $deposit_user->comission_percent = 0.03;
                                    $deposit_user->save();
                                    $ind_seven = User::where("refer_id","=",$ind_six[0]->refer_by)->get();
                                    if(count($ind_seven) > 0){
                                        $deposit_user = new InDirectprofit();
                                        $deposit_user->user_id = $ind_seven[0]->id;
                                        $deposit_user->deposit_id = $deposit_id;
                                        $deposit_user->profit = ($amount * 0.02);
                                        $deposit_user->comission_percent = 0.02;
                                        $deposit_user->save();
                                        $ind_eight = User::where("refer_id","=",$ind_seven[0]->refer_by)->get();
                                        if(count($ind_eight) > 0){
//                                            $deposit_user = new InDirectprofit();
//                                            $deposit_user->user_id = $ind_eight[0]->id;
//                                            $deposit_user->deposit_id = $deposit_id;
//                                            $deposit_user->amount = ($amount * 0.0025);
//                                            $deposit_user->comission_percent = 0.0025;
//                                            $deposit_user->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
//        return $commision;
    }
    public function withdraw(){
        return view("user.withdraw.mlm-withdraw");
    }
    public function investors(){
        $investors = User::where("is_vendor",'=',11)->orderBy('id', 'DESC')->get();
        return view("user.withdraw.investors",compact('investors'));
    }
    public function withdraw_store(Request $request){
        $withdraw = new WithdrawRequest();
        $withdraw->bank_name = $request->bank_name;
        $withdraw->account_title = $request->account_title;
        $withdraw->iban = $request->iban;
        $withdraw->amount = $request->amount;
        $withdraw->user_id = Auth::user()->id;
        if($withdraw->save()){
            return redirect()->back()->with('message',"Thanks for your withdrawal request, Your fund will be transfer with in 48 working hours");
        }
    }
    public function GetReferalTeam($referid){
        $data_arr = array();
        $refrel_info = User::where("refer_id","=","$referid")->firstOrFail();
        $refers = User::where("refer_by","=",$referid)->get();
        $data_arr[$refrel_info->name] = $refers;
        foreach($data_arr[$refrel_info->name] as $f){
            $refers_c = User::where("refer_by","=",$f->refer_id)->get();
            $data_arr[$f->name] = $refers_c;
            foreach ($refers_c as $tt){
                 $data_arr[$tt->name] = $this->GetReferalTeam($tt->refer_id);
            }
        }
        return $data_arr;
    }
    public function GetReferalCount($referid){
        $count = 0;
        $refers = User::where("refer_by","=",$referid)->get();
        $count += count($refers);
        foreach($refers as $f){
                    $refers_c = User::where("refer_by","=",$f->refer_id)->get();
                    $count += count($refers_c);
                    foreach ($refers_c as $tt){
                        $count += $this->GetReferalCount($tt->refer_id);
                    }
        }
        return $count;
    }
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile',compact('user'));
    }
    public function profileupdate(Request $request)
    {
        //--- Validation Section

        $rules =
        [
            'photo' => 'mimes:jpeg,jpg,png,svg',
            'email' => 'unique:users,email,'.Auth::user()->id
        ];



        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
        $input = $request->all();
        $data = Auth::user();
            if ($file = $request->file('photo'))
            {
                $name = time().str_replace(' ', '', $file->getClientOriginalName());
                $file->move('assets/images/users/',$name);
                if($data->photo != null)
                {
                    if (file_exists(public_path().'/assets/images/users/'.$data->photo)) {
                        unlink(public_path().'/assets/images/users/'.$data->photo);
                    }
                }
                $input['photo'] = $name;
            }
        $data->update($input);
        $msg = 'Successfully updated your profile';
        return response()->json($msg);
    }
    public function resetform()
    {
        return view('user.reset');
    }
    public function reset(Request $request)
    {
        $user = Auth::user();
        if ($request->cpass){
            if (Hash::check($request->cpass, $user->password)){
                if ($request->newpass == $request->renewpass){
                    $input['password'] = Hash::make($request->newpass);
                }else{
                    return response()->json(array('errors' => [ 0 => 'Confirm password does not match.' ]));
                }
            }else{
                return response()->json(array('errors' => [ 0 => 'Current password Does not match.' ]));
            }
        }
        $user->update($input);
        $msg = 'Successfully change your passwprd';
        return response()->json($msg);
    }
    public function package()
    {
        $user = Auth::user();
        $subs = Subscription::all();
        $package = $user->subscribes()->where('status',1)->orderBy('id','desc')->first();
        return view('user.package.index',compact('user','subs','package'));
    }
    public function vendorrequest($id)
    {
        $subs = Subscription::findOrFail($id);
        $gs = Generalsetting::findOrfail(1);
        $user = Auth::user();
        $package = $user->subscribes()->where('status',1)->orderBy('id','desc')->first();
        if($gs->reg_vendor != 1)
        {
            return redirect()->back();
        }
        return view('user.package.details',compact('user','subs','package'));
    }
    public function vendorrequestsub(Request $request)
    {
        $this->validate($request, [
            'shop_name'   => 'unique:users',
           ],[
               'shop_name.unique' => 'This shop name has already been taken.'
            ]);
        $user = Auth::user();
        $package = $user->subscribes()->where('status',1)->orderBy('id','desc')->first();
        $subs = Subscription::findOrFail($request->subs_id);
        $settings = Generalsetting::findOrFail(1);
                    $today = Carbon::now()->format('Y-m-d');
                    $input = $request->all();
                    $user->is_vendor = 2;
                    $user->date = date('Y-m-d', strtotime($today.' + '.$subs->days.' days'));
                    $user->mail_sent = 1;
                    $user->update($input);
                    $sub = new UserSubscription;
                    $sub->user_id = $user->id;
                    $sub->subscription_id = $subs->id;
                    $sub->title = $subs->title;
                    $sub->currency = $subs->currency;
                    $sub->currency_code = $subs->currency_code;
                    $sub->price = $subs->price;
                    $sub->days = $subs->days;
                    $sub->allowed_products = $subs->allowed_products;
                    $sub->details = $subs->details;
                    $sub->method = 'Free';
                    $sub->status = 1;
                    $sub->save();
                    if($settings->is_smtp == 1)
                    {
                    $data = [
                        'to' => $user->email,
                        'type' => "vendor_accept",
                        'cname' => $user->name,
                        'oamount' => "",
                        'aname' => "",
                        'aemail' => "",
                        'onumber' => "",
                    ];
                    $mailer = new GeniusMailer();
                    $mailer->sendAutoMail($data);
                    }
                    else
                    {
                    $headers = "From: ".$settings->from_name."<".$settings->from_email.">";
                    mail($user->email,'Your Vendor Account Activated','Your Vendor Account Activated Successfully. Please Login to your account and build your own shop.',$headers);
                    }

                    return redirect()->route('user-dashboard')->with('success','Vendor Account Activated Successfully');

    }
    public function favorite($id1,$id2)
    {
        $fav = new FavoriteSeller();
        $fav->user_id = $id1;
        $fav->vendor_id = $id2;
        $fav->save();
    }
    public function favorites()
    {
        $user = Auth::guard('web')->user();
        $favorites = FavoriteSeller::where('user_id','=',$user->id)->get();
        return view('user.favorite',compact('user','favorites'));
    }
    public function favdelete($id)
    {
        $wish = FavoriteSeller::findOrFail($id);
        $wish->delete();
        return redirect()->route('user-favorites')->with('success','Successfully Removed The Seller.');
    }
}
