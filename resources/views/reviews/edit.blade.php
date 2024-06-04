@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row my-5">
        
     @include('account.sidebar')

     <div class="col-md-9">
        <div class="card border-0 shadow">
            <div class="card-header  text-white">
                Edit Review
            </div>


            <form method="post" action="{{route('reviews.update',$reviews->id)}}" >
                @csrf
                @method('put')
            <div class="card-body">
                <div class="mb-3">
                    <label for="author" class="form-label">Review</label>
                    <textarea name="review" id="review" class="form-control @error('review') is-invalid
                    @enderror" placeholder="Review" cols="30" rows="5">{{$reviews->review}}</textarea>

                    @error('review')
                    <p class="invalid-feedback">{{$message}}</p>
                    @enderror

                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" {{$reviews->status==1?'selected':''}}>Active</option>
                        <option value="0" {{$reviews->status==0?'selected':''}}>Block</option>
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