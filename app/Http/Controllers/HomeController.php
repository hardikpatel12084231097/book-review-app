<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $books=Book::orderBy('created_at','DESC');
        if($request->keywords!='')
        {
            $books->where('title','like','%'.$request->keywords.'%');
        }
        $books=$books->where('status',1)->paginate(5);

        return view('frontend.home',compact('books'));
    }

    public function book_detail($id)
    {
        $books=Book::findOrFail($id);

        $reviews=Review::with('user')->where('book_id',$id)->where('status',1)->get();

        // dd($reviews);

        if($books->status==0)
        {
            abort(404);
        }
        $bookreaders=Book::where('status',1)->take(3)->where('id','!=',$id)->inRandomOrder()->get();

        return view('frontend.book_detail',compact('books','bookreaders','reviews'));
    }

    public function book_review(Request $request)
    {
       $validator=Validator::make($request->all(),
       [
        'review'=>'required|min:10',
        'rating'=>'required'
       ]);

       if($validator->fails())
       {
        return response()->json([
            'status'=>false,
            'errors'=>$validator->errors(),
        ]);
       }

       $review=new Review();
       $review->review=$request->review;
       $review->rating=$request->rating;
       $review->user_id=Auth::user()->id;
       $review->book_id=$request->book_id;
       $review->save();

       session()->flash('success','Your Review added successfully.');

        return response()->json([
            'status'=>true,
        ]);

    }
}
