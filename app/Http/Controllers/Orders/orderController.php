<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\GuestOrder;
use App\Models\GuestOrderDoc;
use App\Models\Order;
use App\Models\OrderCategory;
use App\Models\OrderDoc;
use App\Models\OrderFormat;
use App\Models\OrderLanguage;
use App\Models\PaperPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class orderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user =  Auth::guard('api')->user();
            $order = null;
            if ($user->admin == 'Y') {
                $order = Order::where('status', 1)->paginate(100);
            } else {
                $order = Order::where('status', 1)
                    ->where('user_id', $user->id)
                    ->paginate(100);
            }
            return $order;
        } catch (\Throwable $th) {
            throw $th;
            $errReport = new ErrorHandler;
            $errReport->LogError($th);
        }
    }

    public function index_guest()
    {
        try {
            $order = null;

            $order = GuestOrder::where('status', 1)->paginate(100);

            return $order->fresh('orderCategory', 'orderFormat', 'orderLanguage', 'guestOrderDocs');
            $guest_order = GuestOrderDoc::where('status', 1)->where('order_id', 1)->paginate(100);
            return $order;
        } catch (\Throwable $th) {
            throw $th;
            $errReport = new ErrorHandler;
            $errReport->LogError($th);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();
            $validatedData = Validator::make($request->all(), [
                'title' => 'required|max:500',
                'description' => 'required',
                'order_category_id' => 'required|exists:order_categories,id',
                'order_format_id' => 'required|exists:order_formats,id',
                'order_language_id' => 'required|exists:order_languages,id',
            ]);



            if ($validatedData->fails()) {
                return ([
                    'code' => -1,
                    'msg' => $validatedData->errors()
                ]);
            }
            $user =  Auth::guard('api')->user();


            $cat = Order::create([
                "user_id" => $user->id,
                "title" => $request->title,
                "email" => $request->email,
                "pages" => $request->pages,
                "wordcount" => $request->wordcount,
                "description" => $request->description,
                "order_category_id" => $request->order_category_id,
                "order_format_id" => $request->order_format_id,
                "order_language_id" => $request->order_language_id,
            ]);

            if ($cat) {
                if ($request->hasFile('file')) {
                    $latest_order = Order::max('id');

                    foreach ($request->file('file') as $doc) {
                        OrderDoc::create([
                            'user_id' => $user->id,
                            'order_id' => $latest_order,
                            'name' => $doc->getClientOriginalName(),
                            'media_link' => Storage::putFile('public/Orders', $doc),
                            'type' => $doc->getClientOriginalExtension(),
                            'extension' => $doc->getClientOriginalExtension(),
                        ]);
                    }

                    DB::commit();

                    return ([
                        'code' => 1,
                        'msg' => "Request went Successfully, Files were added",
                        'body' => $cat
                    ]);
                }
                DB::commit();
                return ([
                    'code' => 1,
                    'msg' => "Request went Successfully, No Files ",
                    'body' => $cat
                ]);
            }

            return ([
                'code' => -1,
                'msg' => "Request Failed",
                'body' => $cat
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            $errReport = new ErrorHandler;
            $errReport->LogError($th);

            return $th;
        }
    }


    public function store_guest(Request $request)
    {
        try {

            DB::beginTransaction();
            $validatedData = Validator::make($request->all(), [
                'title' => 'required|max:500',
                'email' => 'required|max:500',
                'description' => 'required',
                'order_category_id' => 'required|exists:order_categories,id',
                'order_format_id' => 'required|exists:order_formats,id',
                'order_language_id' => 'required|exists:order_languages,id',
            ]);



            if ($validatedData->fails()) {
                return ([
                    'code' => -1,
                    'msg' => $validatedData->errors()
                ]);
            }


            $data = GuestOrder::create([
                "title" => $request->title,
                "email" => $request->email,
                "pages" => $request->pages,
                "wordcount" => $request->wordcount,
                "description" => $request->description,
                "order_category_id" => $request->order_category_id,
                "order_format_id" => $request->order_format_id,
                "order_language_id" => $request->order_language_id,
            ]);

            if ($data) {
                if ($request->hasFile('file')) {
                    $latest_order = GuestOrder::max('id');

                    foreach ($request->file('file') as $doc) {
                        GuestOrderDoc::create([
                            'user_id' => '0',
                            'order_id' => $latest_order,
                            'name' => $doc->getClientOriginalName(),
                            'media_link' => Storage::putFile('public/Orders/Guests', $doc),
                            'type' => $doc->getClientOriginalExtension(),
                            'extension' => $doc->getClientOriginalExtension(),
                        ]);
                    }

                    $maildata = array('name' => "ResearchBrisk Team");

                    Mail::send('feedback_mail', $maildata, function ($message) use ($request) {
                        $message->to($request->email, 'Placement of the Order')->subject('Placement of the Order');
                        $message->from('support@researchbrisk.com', 'Sir Benjamin');
                    });



                    Mail::send('mail', $maildata, function ($message) use ($request) {
                        $message->to('support@researchbrisk.com', 'Placement of the Order')->subject('Placement of the Order');

                        foreach ($request->file('file') as $doc) {
                            $message->attach($doc, [
                                'as' => $doc->getClientOriginalName(),
                                'mime' => $doc->getClientMimeType(),
                            ]);
                        }
                        $message->from($request->email, 'ResearchBrisk Team');
                    });

                    DB::commit();

                    return ([
                        'code' => 1,
                        'msg' => "Request went Successfully, Files were added",
                        'body' => $data
                    ]);
                }
                DB::commit();
                return ([
                    'code' => 1,
                    'msg' => "Request went Successfully, No Files ",
                    'body' => $data
                ]);
            }

            return ([
                'code' => -1,
                'msg' => "Request Failed",
                'body' => $cat
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            $errReport = new ErrorHandler;
            $errReport->LogError($th);

            return $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        if ($order->count() > 0) {
            $order->orderLanguage;
            $order->orderFormat;
            $order->orderCategory;
            $order->user;
        }

        return $order;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $count_order = Order::where('id', $id)->count();
            if ($count_order < 1) {
                return ([
                    'code' => -1,
                    'msg' => "Request Failed to find Object to Delete",
                    'body' => ""
                ]);
            }

            Order::where('id', $id)->delete();
            OrderDoc::where('order_id', $id)->delete();
            return ([
                'code' => 1,
                'msg' => "Request Successfully Deleted",
                'body' => Order::find($id)
            ]);
        } catch (\Throwable $th) {
            throw $th;
            $errReport = new ErrorHandler;
            $errReport->LogError($th);

            return $th;
        }
    }

    public function miscs(Request $request)
    {
        $misc_data = [];
        $misc_data['cats'] = OrderCategory::where('status', 1)->get();
        $misc_data['formats'] = OrderFormat::where('status', 1)->get();
        $misc_data['langs'] = OrderLanguage::where('status', 1)->get();
        $misc_data['paper_price'] = PaperPrice::where('status', 1)->get();

        return $misc_data;
    }
}
