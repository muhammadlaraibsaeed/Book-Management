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
                <img class="card-img-top img-thumbnail" src="{{ asset($book->image) }}" alt="Book Image">
                <div class="card-body">
                    <h4 class="card-title d-flex justify-content-lg-around bg-info">{{ $book->title }}</h4>
                    <a href="{{ route('books.show',$book->id) }}" class="btn btn-info mt-2"> Read More </a>
                </div>
            </div>
            </div>
            @empty
             <h1>No data Avaiable</h1>
    @endforelse

</div>
@endsection
