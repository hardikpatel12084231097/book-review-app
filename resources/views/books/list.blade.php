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
                Books
            </div>


            <div class="card-body pb-0"> 
                
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{route('books.create')}}" class="btn btn-primary btn-custom-height">Add Book</a> 
                    <form method="get" class="d-flex align-items-center">
                        <div class="d-flex">
                            <input type="text" name="keyword" value="{{Request::get('keyword')}}" class="form-control">
                            <button type="submit" class="mx-1 btn btn-primary btn-custom-height">Search</button>
                        </div>
                    </form>
                </div>

                <table class="table  table-striped mt-3">
                    <thead class="table-dark"> 
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th width="150">Action</th>
                        </tr>
                        <tbody>

                            @if(!empty($books))

                            @foreach ($books as $book )
                            <tr>
                                <td>{{$book->title}}</td>
                                <td>{{$book->author}}</td>
                                <td>3.0 (3 Reviews)</td>
                                <td>
                                   @if($book->status==1)
                                   <p class="text-primary">Active</p>
                                   @else
                                   <p class="text-danger">Block</p>
                                   @endif
                               </td>

                                <td>
                                    <a href="#" class="btn btn-success btn-sm"><i class="fa-regular fa-star"></i></a>
                                    <a href="{{route('books.edit',$book->id)}}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <a href="#" onclick="deleteRecord({{$book->id}})" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>

                                    <form id="fromDelete-{{$book->id}}" action="{{route('books.destroy',$book->id)}}" method="POST">
                                        @csrf
                                        @method('delete')

                                    </form>
                                </td>
                            </tr>
                            @endforeach
                           

                            @else
                                <tr><td colspan="6">Books Not Found...</td></tr>
                            @endif
                           
                        </tbody>
                    </thead>
                </table>   
                @if ($books->isNotEmpty())
                 {{$books->links()}}  
                @endif
                   
            </div>
            
        </div>                
    </div>
    </div>       
</div>
@endsection

<script>
    function deleteRecord(id)
    {
        if(confirm("Do you want to delete this record..."))
        {
            document.getElementById('fromDelete-'+id).submit();
        }
    }
</script>