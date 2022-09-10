
<div class="modal-header">
    <div>
        <h5 class="modal-title" id="exampleModalLabel">
            {{ $quiz->title }} ( {{ $quiz->related_quesions->count() }} )
        </h5>
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
                    <span class="question_label">
                        {{ $question->title }}
                    </span>
                </h5>
                <ol type="i">
                    @foreach ($question->quizQuestionOption as $key => $option)
                        <li>
                            <label>
                                @if ($option->is_correct)
                                    <input disabled checked type="checkbox">
                                    <span class="text-success">{{ $option->title }}</span>
                                @else
                                    <input disabled type="checkbox">
                                    <span>{{ $option->title }}</span>
                                @endif
                            </label>
                        </li>
                    @endforeach
                </ol>
            </div>
        @endforeach
    </div>
</div>
