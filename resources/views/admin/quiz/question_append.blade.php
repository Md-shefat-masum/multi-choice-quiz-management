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
                        <h5>Select question for ( {{ $quiz->title }} ) quiz</h5>
                        <a href="{{ route('quiz_index') }}" class="btn btn-success"><- Back</a>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="card-body table-responsive">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                  <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Question List</button>
                                  <button onclick="selected_question_render()" class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Selected ( <span id="selected_count">0</span> )</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active py-3" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <table class="table question_append_table table-hover" id="question_table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>SI</th>
                                                <th>Title</th>
                                                {{-- <th class="text-end pe-5">Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade py-3" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <table class="table question_selected_table table-hover">
                                        <thead>
                                            <tr>
                                                <th>SI</th>
                                                <th>Title</th>
                                                <th class="text-end pe-5">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <form method="POST" onsubmit="create_quiz_question(event)" action="{{ route('attach_quiz_question_store') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $quiz->id }}">
                                        <button class="btn btn-success">Create Quiz</button>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('cjs')
        <link rel="stylesheet" type="text/css" href="/css/datatables.min.css"/>
        <script type="text/javascript" src="/js/jquery-3.6.1.min.js"></script>
        <script type="text/javascript" src="/js/moment.min.js"></script>
        <script type="text/javascript" src="/js/pdfmake.min.js"></script>
        <script type="text/javascript" src="/js/vfs_fonts.js"></script>
        <script type="text/javascript" src="/js/jszip.min.js"></script>
        <script type="text/javascript" src="/js/datatables.min.js"></script>

        <script>
            window.moment = moment;
            window.selected_question_list = JSON.parse(`{!!$related_quesions!!}`);
            selected_count.innerHTML = selected_question_list?.length;

            $(document).ready(function () {
                window.get_page = 1;
                let dTable = $('#question_table').DataTable({
                    processing: true,
                    serverSide: true,
                    dom: 'Bfrtip',
                    buttons: [
                        'pageLength',
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: ':visible',
                            },
                        },
                        {
                            extend: 'copy',
                            exportOptions: {
                                columns: ':visible',
                            },
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: ':visible',
                            },
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: ':visible',
                            },
                        },
                        'colvis',
                    ],
                    ajax: {
                        url: '/admin/question/json',
                        data: function(d,e){
                            d.key = d.search.value||null;
                            d.paginate = d.length;
                            d.orderByColumn = d.columns[d.order[0].column].data;
                            d.orderBy = d.order[0].dir.toUpperCase();
                            return {
                                paginate: d.paginate,
                                page: window.get_page,
                                key: d.key,
                                orderBy: d.orderBy,
                                orderByColumn: d.orderByColumn,
                            }
                        },
                        dataFilter: function(data){
                            data = JSON.parse(data);
                            data.recordsTotal = data.total;
                            data.recordsFiltered = data.total;
                            // console.log(data);
                            return JSON.stringify( data );
                        }
                    },
                    "aoColumns": [
                        {
                            bSortable: false,
                            mData: 'id',
                            mRender: function(data, type, row){
                                let checked = window?.selected_question_list?.indexOf(data.toString())>=0?'checked':'';
                                return `
                                    <input ${checked} onchange="add_question(event)" type="checkbox" value="${data}"/>
                                `
                            }
                        },
                        { data: 'id' },
                        { data: 'title' },
                        // {
                        //     "mData": "id",
                        //     "mRender": function (data, type, row) {
                        //         // console.log(data, type, row);
                        //         return `
                        //             <div class="text-end">
                        //                 <a class="btn btn-sm btn-warning m-2" href="/admin/question/edit/${data}">Edit</a>
                        //                 <a class="btn btn-sm btn-danger m-2" onclick="show_delete_form(event)" href="/admin/question/soft-delete?id=${data}">Delete</a>
                        //             </div>
                        //         `;
                        //     }
                        // }
                    ],
                });

                dTable.on( 'page.dt', function () {
                    window.get_page = dTable.page.info().page + 1;
                })
                .on('search.dt', function(){
                    window.get_page = 1;
                })
                .on('order.dt', function(){
                    window.get_page = 1;
                });
            });
        </script>

        <script src="/js/admin.js"></script>
    @endpush

@endsection
