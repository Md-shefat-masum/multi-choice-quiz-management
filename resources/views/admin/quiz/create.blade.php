@extends('layouts.app',[
    'title' => 'admin'
])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        @include('admin.includes.navbar')
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class=" card border-0 shadow-sm">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Create Quiz</h5>
                        <a href="{{ route('quiz_index') }}" class="btn btn-success"><- Back</a>
                    </div>
                    <div class="card-body table-responsive">
                        <form action="{{ route('quiz_store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-4 d-flex gap-3 align-items-center flex-wrap">
                                <label for="">Title: </label>
                                <input type="text" class="form-control w-75" value="{{ old('title') }}" name="title">
                                @error('title')
                                    <span class="text-danger w-100">{{ $message }}</span>
                                @enderror
                            </div>
                            <button class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
