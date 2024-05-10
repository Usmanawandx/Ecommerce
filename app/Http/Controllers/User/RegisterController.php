<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\User;
use Illuminate\Support\Str;
use App\Classes\GeniusMailer;
use App\Models\Notification;
use Auth;

use Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {


//        dd($request->all());

    	$gs = Generalsetting::findOrFail(1);

    //    	if($gs->is_capcha == 1)
    //    	{
    //	        $value = session('captcha_string');
    //	        if ($request->codes != $value){
    //	            return response()->json(array('errors' => [ 0 => 'Please enter Correct Capcha Code.' ]));
    //	        }
    //    	}

//        dd($request->all());

        $uuid = Str::uuid()->toString();

        //--- Validation Section

        $rules = [
		        'email'   => 'required|email|unique:users',
		        'password' => 'required|confirmed'
                ];

        if(!empty($request->referal)){
            $user = User::where("refer_id","=",$request->referal)->get();
            if(count($user) == 0){
                return response()->json(array('errors' => "Referal NOt Valid"));
            }
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

	        $user = new User;
	        $input = $request->all();
	        $input['password'] = bcrypt($request['password']);
            $input['refer_id'] = $uuid;
	        $token = md5(time().$request->name.$request->email);
	        $input['verification_link'] = $token;
	        $input['affilate_code'] = md5($request->name.$request->email);
	        if($request->select_seller  == 1){
                if(!empty($request->vendor))
                {
                    //--- Validation Section
                    $rules = [
                        'shop_name' => 'unique:users',
                        'shop_number'  => 'max:11'
                    ];
                    $customs = [
                        'shop_name.unique' => 'This Shop Name has already been taken.',
                        'shop_number.max'  => 'Shop Number Must Be Less Then 11 Digit.'
                    ];
                    $validator = Validator::make($request->all(), $rules, $customs);
                    if ($validator->fails()) {
                        return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
                    }
                    $input['is_vendor'] = 1;
                    $input['shop_slug'] = str_replace(' ', '-', strtolower($input['shop_name']));
                }
            }else{
                $input['is_vendor'] = 0;
            }
			$user->fill($input)->save();
	        if($gs->is_verification_email == 1)
	        {
	        $to = $request->email;
	        $subject = 'Verify your email address.';
	        $msg = "Dear Customer,<br> We noticed that you need to verify your email address. <a href=".url('user/register/verify/'.$token).">Simply click here to verify. </a>";
	        //Sending Email To Customer
//	        if($gs->is_smtp == 1)
//	        {
//	        $data = [
//	            'to' => $to,
//	            'subject' => $subject,
//	            'body' => $msg,
//	        ];
//
//	        $mailer = new GeniusMailer();
//	        $mailer->sendCustomMail($data);
//	        }
//	        else
//	        {
	        $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
	        mail($to,$subject,$msg,$headers);
//	        }
          	return response()->json('We need to verify your email address. We have sent an email to '.$to.' to verify your email address. Please click link in that email to continue.');
	        }
	        else {
//            $user->email_verified = 'Yes';
            $user->update();
	        $notification = new Notification;
	        $notification->user_id = $user->id;
	        $notification->save();
            Auth::guard('web')->login($user);
          	return response()->json(1);
	        }
    }

    public function token($token)
    {
        $gs = Generalsetting::findOrFail(1);

        if($gs->is_verification_email == 1)
	        {
        $user = User::where('verification_link','=',$token)->first();
        if(isset($user))
        {
            $user->email_verified = 'Yes';
            $user->update();
	        $notification = new Notification;
	        $notification->user_id = $user->id;
	        $notification->save();
            Auth::guard('web')->login($user);
            return redirect()->route('user-dashboard')->with('success','Email Verified Successfully');
        }
    		}
    		else {
    		return redirect()->back();
    		}
    }
}
