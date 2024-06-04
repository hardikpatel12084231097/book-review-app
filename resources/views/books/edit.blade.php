@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row my-5">
        
     @include('account.sidebar')

     <div class="col-md-9">
        <div class="card border-0 shadow">
            <div class="card-header  text-white">
                Edit Book
            </div>
            <form method="post" action="{{route('books.update',$books->id)}}" enctype="multipart/form-data">
                @csrf
                @method('put')
            <div class="card-body">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control  @error('title') is-invalid @enderror" placeholder="Title" value="{{$books->title}}" name="title" id="title" />

                    @error('title')
                        <p class="invalid-feedback">{{$message}}</p>
                    @enderror

                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" class="form-control @error('author') is-invalid @enderror" placeholder="Author" value="{{$books->author}}"  name="author" id="author"/>

                    @error('author')
                    <p class="invalid-feedback">{{$message}}</p>
                @enderror
                
                </div>

                <div class="mb-3">
                    <label for="author" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" placeholder="Description" cols="30" rows="5">{{$books->description}}</textarea>
                </div>

                <div class="mb-3">
                    <label for="Image" class="form-label">Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror"  name="image" id="image"/>
                    @error('image')
                    <p class="invalid-feedback">{{$message}}</p>
                @enderror

                @if($books->image!='')
                <img src="{{asset('uploads/books/thumb/'.$books->image)}}" class="img-fluid mt-4" alt="Luna John">                      
                @endif
            

                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" {{$books->status==1?'selected':''}}>Active</option>
                        <option value="0" {{$books->status==0?'selected':''}}>Block</option>
                    </select>
                </div>


                <button class="btn btn-primary mt-2">Update</button>                     
            </div>
            <form>

        </div>                
    </div>
     
    </div>       
</div>
@endsection