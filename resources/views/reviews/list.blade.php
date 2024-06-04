@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row my-5">
        
     @include('account.sidebar')

     <div class="col-md-9">
                
        @if (Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger">{{Session::get('error')}}</div>
                @endif

        <div class="card border-0 shadow">
            <div class="card-header  text-white">
                My Reviews
            </div>
            
            <div class="card-body pb-0">  
                <div class="d-flex justify-content-end">
                    <form method="get" class="d-flex align-items-center">
                        <div class="d-flex">
                            <input type="text" name="keyword" value="" class="form-control">
                            <button type="submit" class="mx-1 btn btn-primary btn-custom-height">Search</button>
                        </div>
                    </form>
                </div>
                
                <table class="table  table-striped mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>Book</th>
                            <th>Review</th>
                            <th>Rating</th>
                            <th>Status</th>                                  
                            <th width="100">Action</th>
                        </tr>
                        <tbody>

                            @if($reviews->isNotEmpty())

                            @foreach ($reviews as $review)
                            <tr>
                                <td>{{$review->book->title}}</td>
                                <td>
                                    {{ $review->review }}<br>
                                    <strong>{{ $review->user->name }}</strong>
                                </td>                                      
                                <td>{{$review->rating}}</td>

                                <td>
                                    @if($review->status == 0)
                                        <p class="text-danger">Block</p>
                                    @else
                                        <p class="text-success">Active</p>
                                    @endif
                                </td>
                                

                                <td>
                                    <a href="{{route('reviews.edit',$review->id)}}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                    </a>


                                    <a href="#" onclick="deleteReview({{$review->id}})" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>

                                    <form id="deleteReviewForm-{{$review->id}}" action="{{route('reviews.destroy',$review->id)}}" method="post" >
                                        @csrf
                                        @method('delete')
                                    </form>


                                </td>
                            </tr>  
                            @endforeach

                            @else
                            <tr><td>Reviews Not Found...</td></tr>
                            @endif
                        </tbody>

                    </thead>
                </table>   
               {{$reviews->links()}}              
            </div>
            
        </div>                
    </div>
    </div>       
</div>
@endsection

@section('script')
    <script>
        function deleteReview(id)
        {

            if(confirm("delete this review..."))
            {
                document.getElementById('deleteReviewForm-'+id).submit();
            }
        
        }
    </script>
@endsection