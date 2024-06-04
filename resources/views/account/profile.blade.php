@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row my-5">
        
     @include('account.sidebar')

        <div class="col-md-9">

            @if(Session::has('success'))
            <div class="alert alert-success">{{Session::get('success')}}</div>
            @endif

            <div class="card border-0 shadow">
                <div class="card-header  text-white">
                    Profile
                </div>

            <form method="post" action="{{route('accounts.profile_update')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{old('name',$users->name)}}" class="form-control @error('name') is-invalid  @enderror" placeholder="Name" name="name" id="" />
                        @error('name')
                        <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Email</label>
                        <input type="text" value="{{old('email',$users->email)}}" class="form-control @error('email') is-invalid  @enderror" placeholder="Email"  name="email" id="email"/>
                        @error('email')
                        <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid  @enderror">
                        @error('image')
                        <p class="invalid-feedback">{{$message}}</p>
                    @enderror

                    @if(Auth::user()->image!='')
                    <img src="{{asset('uploads/profile/thumb/'.Auth::user()->image)}}" class="img-fluid mt-4" alt="Luna John">                      
                    @endif
                

                    </div>   
                    <button class="btn btn-primary mt-2">Update</button>                     
                </div>
            </form>
            </div> 

        </div>
    </div>       
</div>
@endsection