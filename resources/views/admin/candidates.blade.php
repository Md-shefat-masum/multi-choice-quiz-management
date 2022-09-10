@extends('layouts.app',[
    'title' => 'admin'
])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        @include('admin.includes.navbar')
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class=" card border-0 shadow-sm">
                    <div class="card-body table-responsive">
                        <table id="user_table" class="table">
                            <thead>
                                <tr>
                                    <th>SI</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>CV</th>
                                    <th style="width: 200px;">
                                        Quiz <br>
                                        <small style="white-space: nowrap; word-break: break-all; text-overflow: ellipsis;">click to preview submission</small>
                                    </th>
                                    <th>Status</th>
                                    <th style="width: 246px;">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="quiz_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Warning</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        sure!! Would you like to delete?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
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

            let get_delete_modal = document.getElementById('deleteModal');
            let edit_modal = document.getElementById('edit_modal');
            if (get_delete_modal) {
                var deleteModal = new bootstrap.Modal(get_delete_modal);

                function show_delete_form(event) {
                    event.preventDefault();
                    document.querySelector('#deleteModal form').action = event.target.href;
                    deleteModal.show();
                }
            }
            if (edit_modal) {
                var bedit_modal = new bootstrap.Modal(edit_modal);
                function show_edit_form(event) {
                    event.preventDefault();
                    fetch(event.target.href)
                        .then(res=>res.text())
                        .then(res=>{
                            document.querySelector('#edit_modal .modal-content').innerHTML = res;
                            bedit_modal.show();
                        })
                }
            }

            $(document).ready(function () {
                window.get_page = 1;
                let dTable = $('#user_table').DataTable({
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
                        url: '/admin/candidates',
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
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'email' },
                        { data: 'phone' },
                        {
                            mData: 'cv_link',
                            mRender: function(data){
                                return `
                                    <a href="${data}" target="_blank" class="btn btn-sm btn-primary">Preview</a>
                                `
                            }
                        },
                        {
                            mData: 'id',
                            bSortable: false,
                            mRender: function(data,type,row){
                                let quiz = `<ul>`;
                                row.submitted_quiz.forEach(item => {
                                    quiz += `
                                        <li>
                                            <a onclick="load_answers(event,${item.quiz.id},1,${row.id})" href="#">
                                                ${item.quiz.title}: ${item.obtain_mark}
                                            </a>
                                        </li>
                                    `;
                                });
                                quiz += `<li>Total: ${row.quiz_mark}</li>`;
                                quiz += `</ul>`;
                                return quiz;
                            }
                        },
                        {
                            mData: 'status',
                            mRender: function(data){
                                if(data === 'approved'){
                                    return `
                                        <span class="badge bg-success p-2">approved</span>
                                    `
                                }else if(data === 'rejected'){
                                    return `
                                        <span class="badge bg-warning text-dark p-2">rejected</span>
                                    `
                                }else{
                                    return `
                                        <span class="badge bg-info p-2">pending</span>
                                    `
                                }
                            }
                        },
                        // {
                        //     mData: 'created_at',
                        //     mRender: function(data){
                        //         return moment(data).format('d MMMM,YYYY hh:mm:ss')
                        //     }
                        // },
                        {
                            "mData": "id",
                            "mRender": function (data, type, row) {
                                // console.log(data, type, row);
                                let btn = ``;
                                if(row.status === 'pending'){
                                    btn += `
                                        <a href="/admin/candidate/${data}/accept" class="btn m-1 btn-secondary btn-sm" onclick="return confirm('sure want to accept')">approve</a>
                                        <a href="/admin/candidate/${data}/reject" class="btn m-1 btn-danger btn-sm" onclick="return confirm('sure want to reject')">reject</a>
                                    `;
                                }else if(row.status === 'approved'){
                                    btn += `
                                        <a href="/admin/candidate/${data}/reject" class="btn m-1 btn-danger btn-sm" onclick="return confirm('sure want to reject')">reject</a>
                                    `;
                                }else{
                                    btn += `
                                        <a href="/admin/candidate/${data}/accept" class="btn m-1 btn-secondary btn-sm" onclick="return confirm('sure want to accept')">approve</a>
                                    `;
                                }
                                btn += `
                                    <a onclick="show_edit_form(event)" href="/user-details-modal/${data}" class="btn m-1 btn-secondary btn-sm" >details</a>
                                    <a onclick="show_edit_form(event)" href="/user-info-get/${data}" class="btn m-1 btn-primary btn-sm" >edit</a>
                                    <a onclick="show_delete_form(event)" href="/admin/candidate/${data}/delete" class="btn m-1 btn-info btn-sm">delete</a>
                                `;

                                return btn;
                            }
                        }
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

            function load_answers(event, quiz_id, render_html = true, user_id) {
                event.preventDefault();
                fetch(`/admin/get-user-submission/${quiz_id}/${render_html}/${user_id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            'Content-Type': 'text/html',
                        }
                    })
                    .then(res => res.text())
                    .then(async (res) => {
                        var quizModal = new bootstrap.Modal(document.getElementById('quiz_modal'));
                        document.getElementById('modal-content').innerHTML = res;
                        await quizModal.show();
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        </script>
    @endpush
@endsection
