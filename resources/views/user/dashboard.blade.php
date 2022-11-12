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
                        {{-- 
                            <tr>
                                <td>CV link</td>
                                <td>:</td>
                                <td>
                                    <a class="btn btn-success" href="{{auth()->user()->cv_link}}" target="_black">Preview</a>
                                </td>
                            </tr> 
                        --}}
                        <tr>
                            <td>Submission Link</td>
                            <td>:</td>
                            <td>
                                <a class="btn btn-success" href="{{auth()->user()->submission_link}}" target="_black">Preview</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Live Link</td>
                            <td>:</td>
                            <td>
                                <a class="btn btn-success" href="{{auth()->user()->live_link}}" target="_black">Preview</a>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <a class="btn btn-warning mx-1" 
                                    onclick="show_edit_form(event)" 
                                    href="{{ route('user_information_get',auth()->user()->id) }}" 
                                    target="_black">
                                    Edit Information
                                </a>
                                <a class="btn btn-info mx-1" 
                                    onclick="show_assignment_form(event)" 
                                    href="#/show-assignment-details" 
                                    target="_black">
                                    what needs to be done as assignment
                                </a>
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
    <div class="modal fade" id="quiz_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

            </div>
        </div>
    </div>

    <div class="modal fade" id="assignment_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header">
                        <h2>what needs to be done as assignment</h2>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td style="width: 150px;"><b>Title</b></td>
                                <td style="width: 3px;">:</td>
                                <td> Agency website </td>
                            </tr>
                            <tr>
                                <td><b> Deadline </b></td>
                                <td>:</td>
                                <td> 16 nov, 2022 | wednesdy | 11:59 pm </td>
                            </tr>
                            <tr>
                                <td><b> Instruction </b></td>
                                <td>:</td>
                                <td> 
                                    <ol>
                                        <li>Follow the given PSD file</li>
                                        <li>Create a pixel-perfect website from PSD file.</li>
                                        <li>There should be complete device compatibility for the website.</li>
                                        <li>Use any CSS framework is permitted.</li>
                                        <li>upload project files to GitHub or Google Drive</li>
                                        <li>Make a live link submission using github gh-pages or any</li>
                                    </ol>     
                                </td>
                            </tr>
                            <tr>
                                <td><b> Resource Links </b></td>
                                <td>:</td>
                                <td> 
                                    <a href="https://drive.google.com/file/d/1emwkTtiGdZ3v3rsejym_X3SIzWEzUOey/view?usp=share_link" 
                                        target="_blank" 
                                        download=""
                                        class="btn btn-info btn-sm mx-1">preview</a>   
                                        
                                    <a href="https://drive.google.com/file/d/1VMh8vX5j-Sqfr0-j2C3FQS5ATh_6MnDM/view?usp=share_link" 
                                        target="_blank" 
                                        download=""
                                        class="btn btn-info btn-sm mx-1">PSD File</a>   
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
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

            let assignment_modal = document.getElementById('assignment_modal');
            if (assignment_modal) {
                var bassignment_modal = new bootstrap.Modal(assignment_modal);
                function show_assignment_form(event) {
                    event.preventDefault();
                    bassignment_modal.show();
                }
            }
        </script>
        <script src="/js/custom.js"></script>
    @endpush
@endsection

