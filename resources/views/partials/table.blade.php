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
    {{-- <a href="{{ route('addBook.form') }}" class="btn btn-primary mb-3">Add Book</a> --}}

          <?php $num = 1; ?>
      @foreach ($books as $book)
    <tr class="user{{$book->id}}" id="user-id">
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

                <a href="" onclick="deleteRecord();event.preventDefault();" id="deleteRecord" data-id="{{$book->id}}"><i class="bi bi-trash3 text-danger"></i></a>
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


