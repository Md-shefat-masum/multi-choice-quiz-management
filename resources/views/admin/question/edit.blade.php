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
                        <h5>Edit Question</h5>
                        <a href="{{ route('question_index') }}" class="btn btn-success"><- Back</a>
                    </div>
                    <div class="card-body table-responsive">
                        <form id="quiz_question_form" action="{{ route('question_update') }}" method="POST">
                            @csrf
                            <input type="hidden">
                            <table data-id="{{ $question->id }}" class="table quiz_edit_table quiz_creation_table table-hover">
                                <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Title</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
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
