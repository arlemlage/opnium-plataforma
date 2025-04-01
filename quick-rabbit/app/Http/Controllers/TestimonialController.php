<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Testimonial;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Testimonial::live()->get();
        return view('testimonial.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = User::notAi()->where('role_id',3)->where('del_status','Live')->get();
        return view('testimonial.testimonial_add_edit', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required',
            'rating' => 'required',
            'review' => 'required',
        ], [
            'customer_id.required' => __('index.customer_id_required'),
            'rating.required' => __('index.rating_required'),
            'review.required' => __('index.review_required'),
        ]);

        $row = new Testimonial();
        $row->user_id = $request->customer_id;
        $row->rating = $request->rating;
        $row->review = $request->review;
        $row->save();
        return redirect()->route('testimonial.index')->with(saveMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customers = User::notAi()->where('role_id',3)->where('del_status','Live')->get();
        $obj = Testimonial::find(encrypt_decrypt($id, 'decrypt'));
        return view('testimonial.testimonial_add_edit', compact('obj', 'customers'));

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
        $this->validate($request, [
            'customer_id' => 'required',
            'rating' => 'required',
            'review' => 'required',
        ], [
            'customer_id.required' => __('index.customer_id_required'),
            'rating.required' => __('index.rating_required'),
            'review.required' => __('index.review_required'),
        ]);

        $row = Testimonial::find(encrypt_decrypt($id, 'decrypt'));
        $row->user_id = $request->customer_id;
        $row->rating = $request->rating;
        $row->review = $request->review;
        $row->save();
        return redirect()->route('testimonial.index')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Testimonial::find(encrypt_decrypt($id, 'decrypt'))->delete();
        return redirect()->route('testimonial.index')->with(deleteMessage());
    }
}
