@extends('layouts.app',[
    'title' => 'dashboard: user'
])
@section('content')
    <section>
        <div class="container">
            <h4>Welcome to dashboard</h4>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <table class="table info_table">
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td>{{ auth()->user()->name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>{{ auth()->user()->email }}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>:</td>
                            <td>{{ auth()->user()->phone }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td>{{ auth()->user()->status }}</td>
                        </tr>
                        <tr>
                            <td>CV link</td>
                            <td>:</td>
                            <td>
                                <a class="btn btn-success" href="{{auth()->user()->cv_link}}" target="_black">Preview</a>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <a class="btn btn-warning" onclick="show_edit_form(event)" href="{{ route('user_information_get',auth()->user()->id) }}" target="_black">Edit Information</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <h4>Skill Test</h4>
                    <ul class="quiz_list p-0 m-0">
                        @foreach ($quizes as $item)
                            <li class="quiz_item">
                                <h4>{{ $item->title }}</h4>
                                <div>
                                    <p>
                                        Obtained mark:
                                        <span id="obtain_mark{{$item->id}}">
                                            {{$item->obtained_mark}}
                                            @if ($item->attend)
                                                / {{$item->questions}}
                                            @endif
                                        </span>
                                    </p>
                                </div>
                                <div id="action_btns{{$item->id}}">
                                    @if ($item->attend)
                                        <a onclick="load_answers(event, {{$item->id}})" href="#">Preview Submission</a>
                                    @else
                                        <a id="quiz_load_btn{{$item->id}}" onclick="load_quiz(event, {{$item->id}})" href="#">Start test</a>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </section>

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

    @push('cjs')
        <script>
            let edit_modal = document.getElementById('edit_modal');
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
        </script>
        <script src="/js/custom.js"></script>
    @endpush
@endsection

