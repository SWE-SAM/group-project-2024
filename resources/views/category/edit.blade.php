@extends('layouts.master');

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Add Category</h4>
                    </div>
                    <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">

                            {{-- Name input --}}
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $category->name }}">
                            </div>

                            {{-- Display an error message if 'name' field is invalid --}}
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror

                            {{-- Submit button for form --}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection