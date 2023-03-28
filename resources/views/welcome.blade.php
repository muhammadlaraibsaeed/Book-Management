@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    @guest
        @else
        <a href="{{ route('books.index') }}" class="btn btn-primary mb-3">Book Management</a>
    @endguest

    @forelse ($books as $book)
            <div class="col-md-4 mt-2">
            <div class="card" >
                <img class="card-img-top img-thumbnail" src="{{ asset('storage/'.$book->image) }}" alt="Book Image">
                <div class="card-body">
                    <h4 class="card-title d-flex justify-content-lg-around bg-info">{{ $book->title }}</h4>
                    <h4 class="card-title bg-secondary p-2"> <span class="d-block mb-2 text-justify"><span>{{ $book->description }}</span></h4>
                    <h4 class="card-title d-flex justify-content-lg-around bg-info"> <span>ISBN</span> <span>{{ $book->isbn }}</span></h4>
                    <h4 class="card-title d-flex justify-content-lg-around bg-info"> <span>Public Date</span> <span>{{ $book->pdate }}</span></h4>
                    <h4 class="card-title d-flex justify-content-lg-around bg-info"> <span>Price</span> <span>{{ $book->pdate }}</span></h4>
                    <h4 class="card-title d-flex justify-content-lg-around bg-info"> <span>number of page</span> <span>{{ $book->page }}</span></h4>
                </div>
            </div>
            </div>
            @empty
             <h1>No data Avaiable</h1>
    @endforelse

</div>
@endsection
