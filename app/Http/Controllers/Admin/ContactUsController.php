<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactUss= ContactUs::orderByDesc('created_at')->paginate();
        return view('dashboard.contactus.index',compact('contactUss'));
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

        $validate= validator($request->all(),[
            'name'=> 'required',
            'email'=> 'required|email',
            'phone'=> 'required',
            'location'=> 'required',
            'company'=> 'required',
            'message'=> 'required',
        ], [], []);
        if ($validate->fails()){
            return response()->json(['errors'=> $validate->errors()],422);
        }
        ContactUs::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'location'=> $request->location,
            'company'=> $request->company,
            'message'=> $request->message,
        ]);

        return response()->json(null,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function show(ContactUs $contactUs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactUs $contactUs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactUs $contactUs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contactUs= ContactUs::whereId($id)->first();
        $contactUs->delete();
        return redirect()->back()->with(['success'=>'The message was deleted Successfully']);
    }
}

