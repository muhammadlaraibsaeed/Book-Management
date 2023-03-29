@extends('layouts.app')

@section('content')
      <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update Book') }}</div>
                <div class="card-body">
                   <form method="POST" action="{{ route('books.update',$book->id)   }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('partials.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
