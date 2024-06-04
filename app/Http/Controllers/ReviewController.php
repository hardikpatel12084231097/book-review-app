<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews=Review::with('book','user')->orderBy('created_at','DESC');

        if(!empty($request->keyword))
        {
            $reviews->where('review','like','%'.$request->keyword.'%');
        }
        $reviews= $reviews->paginate(5);

        return view('reviews.list',compact('reviews'));
    }

    public function edit($id)
    {
        $reviews=Review::findOrfail($id);
        return view('reviews.edit',compact('reviews'));
    }


    public function update(Request $request, $id)
    {
        $reviews=Review::findOrfail($id);

        // validtion
        $validator=Validator::make($request->all(),[
            'review'=>'required|min:10',
            'status'=>'required'
        ]);

        if($validator->fails())
        {
            return redirect()->route('reviews.edit',$id)->withInput()->withErrors($validator);
        }

        $reviews->review=$request->review;
        $reviews->status=$request->status;

        $reviews->save();
        return redirect()->route('reviews')->with('success','Review edit successfully...');

    }


    public function destroy($id)
    {
        $review=Review::findOrFail($id);
        $review->delete();

        return redirect()->route('reviews')->with('error','Review deleted successfully.');

    }



}
