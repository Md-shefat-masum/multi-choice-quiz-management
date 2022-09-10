
<div class="modal-header">
    <div>
        <h5 class="modal-title" id="exampleModalLabel">
            {{ $quiz->title }} ( {{ $quiz->correct_answer }} / {{ $quiz->related_quesions->count() }} )
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
                    <span class="question_label {{$question->correct_answer?'text-success':'text-danger'}}">
                        {{ $question->title }}
                    </span>
                </h5>
                <ol type="i">
                    @foreach ($question->quizQuestionOption as $key => $option)
                        <li>
                            <label>
                                @if ($option->user_selected)
                                    <input disabled checked value="{{$option->slug}}" type="checkbox">
                                @else
                                    <input disabled value="{{$option->slug}}" type="checkbox">
                                @endif

                                @if ($option->is_correct && $option->user_selected_correct)
                                    <span class="text-success">
                                        {{ $option->title }}
                                    </span>
                                @elseif($option->is_correct && !$option->user_selected_correct)
                                    <span class="text-success">
                                        {{ $option->title }}
                                    </span>
                                @elseif(!$option->is_correct && $option->user_selected_correct)
                                    <span class="text-danger">
                                        {{ $option->title }}
                                    </span>
                                @elseif(!$option->is_correct && $option->user_selected)
                                    <span class="text-danger">
                                        {{ $option->title }}
                                    </span>
                                @else
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
