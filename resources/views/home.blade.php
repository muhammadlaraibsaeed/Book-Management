@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-info">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Cover image</th>
      <th scope="col">ISBN</th>
      <th scope="col">Published date</th>
      <th scope="col">Price</th>
      <th scope="col">Number of pages</th>
      <th scope="col">Operation</th>

    </tr>
  </thead>
  <tbody>
    <a href="{{ route('addBook.form') }}" class="btn btn-primary mb-3">Add Book</a>
          <?php $num = 1; ?>
      @foreach ($books as $book)
    <tr>
      <th scope="row">{{ $num }}</th>
      <td>{{ $book->title }}</td>
      <td>{{ $book->description }}</td>
      <td><img src="{{ asset($book->image) }}" alt="Book image" title="Book image" style="width: 36px;"></td>
      <td>{{ $book->isbn }}</td>
      <td>{{ $book->pdate }}</td>
      <td>${{ $book->price }}</td>
      <td>{{ $book->page }}</td>
        <td>
            @can('delete-post', $book)
                <form id="delete-form" method="POST" action="{{ route('books.destroy',$book->id) }}">
                            @csrf
                            @method('delete')
                    <div class="form-group">
                                <input type="submit" class="btn btn-danger" value="Delete">
                            </div>
                </form>
                    <a href="{{ route('books.show',$book->id) }}" class="btn btn-info mt-2"> search </a>
                    <a href="{{ route('books.edit',$book->id) }}" class="btn btn-secondary mt-2"> Update </a>

                   @else
                   <p class="btn btn-primary">Unable</p>
            @endcan



        </td>
          <?php $num++; ?>
    </tr>
      @endforeach


  </tbody>
</table>
@endsection
