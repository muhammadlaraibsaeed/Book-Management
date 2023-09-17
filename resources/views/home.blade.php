@extends('layouts.app')

@section('content')
<div class="container-fluid">
   <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#exampleModal">
                Add Book
            </button>

            <div id="table"></div>
{{-- pop up form --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_btn">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form method="POST" action="#" id="myForm" name="myForm" class="form-horizontal" enctype="multipart/form-data" >
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
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
                                <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" name="price" >
                                        <p class="alert alert-danger price mt-3 error-tag d-none"></p>
                            </div>
                            <div class="form-group">
                                <label>Page</label>
                                <input id="page" type="number" class="form-control @error('page') is-invalid @enderror" value="{{ old('page') }}" name="page" >
                                        <p class="alert alert-danger page mt-3 error-tag d-none"></p>
                            </div>
                            <div class="form-group">
                                <label>Published date</label>
                                    <input id="pdate" type="text" class="form-control @error('pdate') is-invalid @enderror" value="{{ old('pdate') }}"  name="pdate" placeholder="mm/dd/yyyy" >
                                        <p class="alert alert-danger pdate mt-3 error-tag d-none"></p>
                            </div>

                            <label>Image</label>
                            <div class="form-group">
                                    <input id="BookFrame" type="file" onchange="previewFile(this);" class="form-control @error('BookFrame') is-invalid @enderror" value="{{ old('BookFrame') }}"  name="BookFrame">
                                    <img src="" class="img-thumbnail" id="previewImg" >
                                    <p class="alert alert-danger  BookFrame mt-3 error-tag d-none"></p>
                            </div>

                        </form>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes
                        </button>
      </div>
</div>

<script>

    $(document).ready(function () {
        //----- Open model CREATE -----//
        $("#btn-save").click(function (e) {


            e.preventDefault();
            var form = $('#myForm')[0];
            var formData = new FormData(form);

            var state = $('#btn-save').val();
            var type = "POST";
            var ajaxurl = "{{ route('books.store') }}";
            $.ajax({
                type: type,
                url: ajaxurl,
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#close_btn').click();
                    fetch_record();
                },
                error: function(data) {
                    $(".error-tag").addClass("d-none");
                    $.each(data.responseJSON, function(key, value) {
                    console.log(value[0]);
                    $('.' + key).removeClass("d-none").empty().html(value[0]);
                    });
                }
            });
        });
    });

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
        });
             fetch_record();
    });

    function fetch_record()
    {
        $.ajax({
            type:"GET",
            url:"{{ route('books.index') }}",
            success:function(data)
            {
                $('#table').empty().html(data);

            }
        });
    }

    // that is use to review the image

    function previewFile(input)
        {
            var file = $("input[type=file]").get(0).files[0];

            if(file){
                var reader = new FileReader();
                reader.onload = function(){
                    $("#previewImg").attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }
        {{-- scripting File --}}


        function deleteRecord()
        {

            $(document).ready(function(){

                    var user_id = $('#deleteRecord').attr('data-id');
                        // Make an Ajax DELETE request to the server
                        $.ajax({
                        type: "DELETE",
                        url: `{{ route('books.destroy',":user_id") }}`.replace(':user_id', user_id), // Replace with your API endpoint
                        success: function (response) {

                            $(".user"+response.user_id).remove();
                            // Handle success, e.g., remove the deleted record from the UI
                            console.log("Record deleted successfully.");
                        },
                        error: function (error) {
                            // Handle error, e.g., show an error message
                            console.error("Error deleting record: " + error.statusText);
                        },
                });
            });

        }


</script>

@endsection
