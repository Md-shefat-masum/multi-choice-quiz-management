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
                    <div class="card-body table-responsive">
                        <div class="dashboard_at_a_glance">
                            <div class="item">
                                <h6>Total Quiz</h6>
                                <h5>{{ $at_a_glance->total_quiz}}</h5>
                            </div>
                            <div class="item">
                                <h6>Total Question</h6>
                                <h5>{{ $at_a_glance->total_quiz_question}}</h5>
                            </div>
                            <div class="item">
                                <h6>Total Candidates</h6>
                                <h5>{{ $at_a_glance->total_candidate}}</h5>
                            </div>
                            <div class="item">
                                <h6>Pending Candidates</h6>
                                <h5>{{ $at_a_glance->pending_candidate}}</h5>
                            </div>
                            <div class="item">
                                <h6>Accepted Candidates</h6>
                                <h5>{{ $at_a_glance->accepted_candidate}}</h5>
                            </div>
                            <div class="item">
                                <h6>Rejected Candidates</h6>
                                <h5>{{ $at_a_glance->rejected_candidate}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
