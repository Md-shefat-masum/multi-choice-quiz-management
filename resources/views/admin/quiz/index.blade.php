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
                        <h5>All Quizes</h5>
                        <a href="{{ route('quiz_create') }}" class="btn btn-success">+ Create</a>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>SI</th>
                                    <th>Title</th>
                                    <th>Total Question</th>
                                    <th class="text-end pe-5">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->related_quesions_count }}</td>
                                        <td class="text-end pe-4">
                                            <a class="btn btn-sm btn-secondary m-2" onclick="quiz_details(event)" href="{{ route('quiz_details',$item->id) }}">Preview</a>
                                            <a class="btn btn-sm btn-info m-2" href="{{ route('quiz_question_append',$item->id) }}">Manage Question</a>
                                            <a class="btn btn-sm btn-warning m-2" href="{{ route('quiz_edit',$item->id) }}">Edit</a>
                                            <a class="btn btn-sm btn-danger m-2" onclick="show_delete_form(event)" href="{{ route('quiz_soft_delete') }}?id={{$item->id}}">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{ $data->links() }}
                    </div>
                </div>
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

    <!-- Modal -->
    <div class="modal fade" id="quiz_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>

    @push('cjs')
        <script>
            let get_delete_modal = document.getElementById('deleteModal');
            if (get_delete_modal) {
                var deleteModal = new bootstrap.Modal(get_delete_modal);

                function show_delete_form(event) {
                    event.preventDefault();
                    document.querySelector('#deleteModal form').action = event.target.href;
                    deleteModal.show();
                }
            }

            function quiz_details(event){
                event.preventDefault();
                fetch(event.target.href)
                    .then(res=>res.text())
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
