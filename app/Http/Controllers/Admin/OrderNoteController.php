<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderNote;

use Validator;

class OrderNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


   //*** GET Request
    public function index($id)
    {
    	$order = Order::findOrFail($id);

        return view('admin.order.order-notes',compact('order'));
    }

   //*** GET Request
    public function load($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.order.track-load',compact('order'));
    }

    public function store(Request $request)
    {
        $order_note = new OrderNote;
        $order_note->user_id = $request->user_id;
        $order_note->note = $request->note;
        $order_note->order_id = $request->order_id;
        $order_note->save();
        return redirect()->back();
    }

}
