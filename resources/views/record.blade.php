@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    @guest
        @else
        <a href="{{ route('books.index') }}" class="btn btn-primary mb-3">Book Management</a>
    @endguest
            <div class="col mt-2">
            <div class="card" >
                <img class="card-img-top img-thumbnail" src="{{ asset('storage/'.$books->image) }}" alt="Book Image">
                <div class="card-body">
                    <h4 class="card-title d-flex justify-content-lg-around bg-info">{{ $books->title }}</h4>
                    <h4 class="card-title bg-secondary p-2"> <span class="d-block mb-2 text-justify"><span>{{ $books->description }}</span></h4>
                    <h4 class="card-title d-flex justify-content-lg-around bg-info"> <span>ISBN</span> <span>{{ $books->isbn }}</span></h4>
                    <h4 class="card-title d-flex justify-content-lg-around bg-info"> <span>Public Date</span> <span>{{ $books->pdate }}</span></h4>
                    <h4 class="card-title d-flex justify-content-lg-around bg-info"> <span>Price</span> <span>{{ $books->pdate }}</span></h4>
                    <h4 class="card-title d-flex justify-content-lg-around bg-info"> <span>number of page</span> <span>{{ $books->page }}</span></h4>
                </div>
            </div>
            </div>

</div>
@endsection
