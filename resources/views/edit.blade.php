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
                           <div class="row mb-3">
                            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Cover Image') }}</label>

                            <div class="col-md-6">
                                <img src="{{ asset($book->image) }}" alt="Book image" title="Book image" style="width: 100px;">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
