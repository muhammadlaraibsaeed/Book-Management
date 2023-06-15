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

       <button class="btn btn-success btn-block mb-3" id="btn-add">
                Add Book
            </button>


    {{-- <a href="{{ route('addBook.form') }}" class="btn btn-primary mb-3">Add Book</a> --}}

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

{{-- pop up form --}}
        <div class="modal fade" id="formModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="formModalLabel">Create Todo</h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('addBook.form') }}" id="myForm" name="myForm" class="form-horizontal" enctype="multipart/form-data" >
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="hjdskjhaksjhak">
                                        <p class="alert alert-danger error title mt-3 error-tag d-none"></p>

                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                    <input type="text" class="form-control" id="description" name="description"
                                        placeholder="Enter Description">
                                        <p class="alert alert-danger description mt-3 error-tag d-none"></p>
                            </div>

                            <div class="form-group">
                                <label>ISBN</label>
                                    <input id="isbn" type="text" class="form-control @error('isbn') is-invalid @enderror" name="isbn" value="{{ old('isbn') }}" placeholder="0000-0000-0000" >
                                        <p class="alert alert-danger isbn mt-3 error-tag d-none"></p>

                            </div>

                            <div class="form-group">
                                <label>Price</label>
                                <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" name="price" >
                                        <p class="alert alert-danger price mt-3 error-tag d-none"></p>


                            </div>
                            <div class="form-group">
                                <label>Page</label>
                                <input id="page" type="text" class="form-control @error('page') is-invalid @enderror" value="{{ old('page') }}" name="page" >
                                        <p class="alert alert-danger page mt-3 error-tag d-none"></p>

                            </div>

                            <div class="form-group">
                                <label>Published date</label>
                                    <input id="pdate" type="text" class="form-control @error('pdate') is-invalid @enderror" value="{{ old('pdate') }}"  name="pdate" placeholder="mm/dd/yyyy" >
                                        <p class="alert alert-danger pdate mt-3 error-tag d-none"></p>

                            </div>
                        </form>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes
                        </button>
                        <input type="hidden" id="todo_id" name="todo_id" value="0">
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
    //----- Open model CREATE -----//
    $('#btn-add').click(function () {
        $('#myForm').trigger("reset");
        $('#formModal').modal('show');
    });

    $("#btn-save").click(function (e) {

        $.ajaxSetup({
        headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
    });

        e.preventDefault();
        e.stopPropagation();
        var formData = {
            title: $('#title').val(),
            description: $('#description').val(),
            isbn: $('#isbn').val(),
            price: $('#price').val(),
            page: $('#page').val(),
            pdate: $('#pdate').val()
        };
        var state = $('#btn-save').val();
        var type = "POST";
        var ajaxurl = "{{ route('books.store') }}";
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {

                console.log(data[0]);
                // return;
                location.reload();
                $('#myForm').trigger("reset");
                $('#formModal').modal('hide');
            },
            error: function (data) {
                $(".error-tag").addClass("d-none");
                 for(key in data.responseJSON)
                                {
                                    console.log(data.responseJSON[key][0]);
                                    $('.'+key).removeClass("d-none");
                                    $('.'+key).empty().html(data.responseJSON[key][0]);

                                }

            }
        });
    });
});

        </script>

@endsection
