@extends('layouts.app')

@section('content')
      <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Book') }}</div>
                <div class="card-body">
                   <form method="POST" action="{{ route('books.store')   }}" enctype="multipart/form-data">
                        @csrf
                        @include('partials.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
