<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books=Book::orderBy('created_at','DESC');

        if(!empty($request->keyword))
        {
            $books->where('title','like','%'.$request->keyword.'%');
        }
        
        $books=$books->paginate(10);
        
        return view('books.list',compact('books'));
        
    }
    public function create()
    {
        return view('books.create');
    }
    public function store(Request $request)
    {
        // validation
        $rules=[
            'title'=>'required|min:5',
            'author'=>'required|min:3',
            'status'=>'required'
        ];

        if(!empty($request->image))
        {
            $rules['image']='image';
        }

        $validator=Validator::make($request->all(),$rules);

        if($validator->fails())
        {
            return redirect()->route('books.create')->withInput()->withErrors($validator);
        }

        $books=new Book();
        $books->title=$request->title;
        $books->author=$request->author;
        $books->description=$request->description;
        $books->status=$request->status;
        $books->save();

        // store image
        if(!empty($request->image))
        {
            $image=$request->image;
            $ext=$image->getClientOriginalExtension();
            $imageName=time().'.'.$ext;

            $image->move(public_path('uploads/books'),$imageName);

            $books->image=$imageName;
            $books->save();

            $manager = new ImageManager(new Driver());
            $img = $manager->read(public_path('uploads/books/'.$imageName));

            $img->resize(900);
            $img->save(public_path('uploads/books/thumb/'.$imageName));


        }


        return redirect()->route('books.index')->with('success','Book added successfully.');

    }
    public function edit($id)
    {
        $books=Book::findOrFail($id);
        return view('books.edit',compact('books'));
    }
   
   
    public function update(Request $request,$id)
    {
        $books=Book::findOrFail($id);
 // validation
 $rules=[
    'title'=>'required|min:5',
    'author'=>'required|min:3',
    'status'=>'required'
];

if(!empty($request->image))
{
    $rules['image']='image';
}

$validator=Validator::make($request->all(),$rules);

if($validator->fails())
{
    return redirect()->route('books.edit',$books->id)->withInput()->withErrors($validator);
}

$books->title=$request->title;
$books->author=$request->author;
$books->description=$request->description;
$books->status=$request->status;
$books->save();

// store image
if(!empty($request->image))
{

    File::delete(public_path('uploads/books/'.$books->image));
    File::delete(public_path('uploads/books/thumb/'.$books->image));

    $image=$request->image;
    $ext=$image->getClientOriginalExtension();
    $imageName=time().'.'.$ext;

    $image->move(public_path('uploads/books'),$imageName);

    $books->image=$imageName;
    $books->save();

    $manager = new ImageManager(new Driver());
    $img = $manager->read(public_path('uploads/books/'.$imageName));

    $img->resize(900);
    $img->save(public_path('uploads/books/thumb/'.$imageName));
}

    return redirect()->route('books.index')->with('success','Book Updated successfully.');

    }


    public function destroy($id)
    {
        $books=Book::findOrFail($id);
        File::delete(public_path('uploads/books/'.$books->image));
        File::delete(public_path('uploads/books/thumb/'.$books->image));
        $books->delete();
        return redirect()->route('books.index')->with('error','Book Deleted successfully.');
    }
}
