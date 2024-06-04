@extends('layouts.app')

@section('content')
<div class="container mt-3 ">
    <div class="row justify-content-center d-flex mt-5">
        <div class="col-md-12">
            <a href="{{route('home')}}" class="text-decoration-none text-dark ">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp; <strong>Back to books</strong>
            </a>
            <div class="row mt-4">
                <div class="col-md-4">
                    @if(!empty($books->image))
                    <img src="{{asset('uploads/books/'.$books->image)}}" alt="" class="card-img-top"></a>
                    @else
                    <img src="https://placehold.co/580x896?text=No Image" alt="" class="card-img-top"></a>
                    @endif
                   
                </div>
                <div class="col-md-8">
                    <h3 class="h2 mb-3">{{$books->title}}</h3>
                    <div class="h4 text-muted">{{$books->author}}</div>
                    <div class="star-rating d-inline-flex ml-2" title="">
                        <span class="rating-text theme-font theme-yellow">5.0</span>
                        <div class="star-rating d-inline-flex mx-2" title="">
                            <div class="back-stars ">
                                <i class="fa fa-star " aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>

                                <div class="front-stars" style="width: 100%">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <span class="theme-font text-muted">(0 Review)</span>
                    </div>

                    <div class="content mt-3">
                        <p>
                            {{$books->description}}
                           </p>
                    </div>

                    <div class="col-md-12 pt-2">
                        <hr>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h2 class="h3 mb-4">Readers also enjoyed</h2>
                        </div>


                        @if ($bookreaders!='')

                        @foreach ($bookreaders as $bookreader)
                        <div class="col-md-4 col-lg-4 mb-4">
                            <div class="card border-0 shadow-lg">

                                @if(!empty($bookreader->image))
                                <img src="{{asset('uploads/books/thumb/'.$bookreader->image)}}" alt="" class="card-img-top"></a>
                                @else
                                <img src="https://placehold.co/580x896?text=No Image" alt="" class="card-img-top"></a>
                                @endif

                                <div class="card-body">
                                    <h3 class="h4 heading">{{$bookreader->title}}</h3>
                                    <p>by {{$bookreader->author}}</p>
                                    <div class="star-rating d-inline-flex ml-2" title="">
                                        <span class="rating-text theme-font theme-yellow">0.0</span>
                                        <div class="star-rating d-inline-flex mx-2" title="">
                                            <div class="back-stars ">
                                                <i class="fa fa-star " aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
            
                                                <div class="front-stars" style="width: 70%">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="theme-font text-muted">(0)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif                                       
                    </div>
                    <div class="col-md-12 pt-2">
                        <hr>
                    </div>
                    <div class="row pb-5">
                        <div class="col-md-12  mt-4">

                            @if(Session::has('success'))
                            <div class="alert alert-success">{{Session::get('success')}}</div>
                            @endif

                            <div class="d-flex justify-content-between">
                                <h3>Reviews</h3>
                                <div>
                                    @if (Auth::check())
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        Add Review
                                    </button>
                                    @else
                                    <a href="{{route('accounts.login')}}" class="btn btn-primary">
                                        Add Review
                                    </a>
                                    @endif
                                    
                                      
                                </div>
                            </div>                        


                            @if(!empty($reviews))

                            @foreach ($reviews as $review )
                                
                            <div class="card border-0 shadow-lg my-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="mb-3">{{$review->user->name}}</h4>
                                        <span class="text-muted">{{\Carbon\Carbon::parse($review->created_at)->format('d M, Y')}}</span>         
                                    </div>
                                   
                                    @php
                                        $averageRating = ($review->rating/5)*100;
                                    @endphp
                                   
                                    <div class="mb-3">
                                        <div class="star-rating d-inline-flex" title="">
                                            <div class="star-rating d-inline-flex " title="">
                                                <div class="back-stars ">
                                                    <i class="fa fa-star " aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                
                                                    <div class="front-stars" style="width: {{$averageRating}}%">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                                                           
                                    </div>
                                    <div class="content">
                                        <p>{{$review->review}}</p>
                                    </div>
                                </div>
                            </div>  
                            @endforeach


                            @endif

                            
                           
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>   

<!-- Modal -->
<div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Review for <strong>Atomic Habits</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="" id="formReview" name="formReview">
            
            <input type="hidden" name="book_id" value="{{$books->id}}"/>
            
            <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Review</label>
                        <textarea name="review" id="review" class="form-control" cols="5" rows="5" placeholder="Review"></textarea>

                        <p class="invalid-feedback" id="errorReview"></p>

                    
                    </div>
                    <div class="mb-3">
                        <label for=""  class="form-label">Rating</label>
                        <select name="rating" id="rating" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>


        </div>
    </div>
</div>

@endsection


{{-- data save code --}}

@section('script')

<script>
$("#formReview").submit(function (e) { 
    e.preventDefault();
    
    $.ajax({
        type: "post",
        url: "{{route('book.review')}}",
        data: $("#formReview").serializeArray(),
        success: function (response) {
            if(response.status==false)
            {
                var errors=response.errors;

                if(errors.review)
                {
                    $('#review').addClass('is-invalid');
                    $('#errorReview').html(errors.review);
                }
                else{
                    $('#review').removeClass('is-invalid');
                    $('#errorReview').html('');
                }
            }
            else
            {
                window.location.href="{{route('book.detail',$books->id)}}";

            }
            
        }
    });
});

</script>

@endsection

