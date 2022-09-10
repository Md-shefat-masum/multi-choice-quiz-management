<form action="/user/submit-quiz" method="POST" id="quiz_form">
    @csrf
    <div class="modal-header">
        <div>
            <h5 class="modal-title" id="exampleModalLabel">{{ $quiz->title }}</h5>
            <h6 class="text-danger m-0" id="alert_text"></h6>
            <h6 class="text-success m-0" id="success_text"></h6>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="modal_quiz_list">
            @foreach ($quiz->related_quesions as $key => $question)
                <div class="modal_quiz shadow-sm p-3 rounded-1">
                    <h5 class="d-flex gap-1">
                        <span>
                            {{ $key+1 }}.
                        </span>
                        <span id="{{ $question->slug }}" class="question_label">
                            {{ $question->title }}
                        </span>
                    </h5>
                    <ol type="i">
                        @foreach ($question->quizQuestionOption as $key => $option)
                            <li>
                                <label for="o{{$option->id.$key+1}}">
                                    <input value="{{$option->slug}}" name="qa[{{ $quiz->id }}][{{$question->id}}][]" id="o{{$option->id.$key+1}}" type="checkbox">
                                    {{ $option->title }}
                                </label>
                            </li>
                        @endforeach
                    </ol>
                </div>
            @endforeach
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary d-none" id="quiz_submit_processing_btn" type="submit" disabled>
            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
            Loading...
        </button>
        <button type="submit" id="quiz_submit_btn" class="btn btn-primary">Submit</button>
    </div>
</form>
