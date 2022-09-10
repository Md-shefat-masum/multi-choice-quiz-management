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
                        <h5>Create Question</h5>
                        <a href="{{ route('question_index') }}" class="btn btn-success"><- Back</a>
                    </div>
                    <div class="card-body table-responsive">
                        <form id="quiz_question_form" action="{{ route('question_store') }}" method="POST">
                            @csrf
                            {{-- <div class="form-group mb-4 d-flex align-items-center flex-wrap">
                                <label for="" class="w-25">Select Quiz Topics: </label>
                                <select required name="quiz_id" class="form-control w-75" >
                                    <option value="">select</option>
                                    @foreach ($quizes as $quiz)
                                        <option value="{{$quiz->id}}">{{$quiz->title}}</option>
                                    @endforeach
                                </select>
                                @error('quiz_id')
                                    <span class="text-danger w-100">{{ $message }}</span>
                                @enderror
                            </div> --}}
                            <table class="table quiz_creation_table table-hover">
                                <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Title</th>
                                        <th>Options</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <button type="button" onclick="add_question()" class="btn btn-sm btn-warning">append more</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <button id="submit_btn" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('cjs')

        <script src="/js/admin.js"></script>
    @endpush

@endsection
