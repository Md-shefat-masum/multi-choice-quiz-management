var quizModal = new bootstrap.Modal(document.getElementById('quiz_modal'));

function load_quiz(event, id) {
    event.preventDefault();

    fetch(`/user/get-quiz/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Content-Type': 'text/html',
            },
            body: {
                quiz_id: id,
            },
        })
        .then(res => res.text())
        .then(async (res) => {
            document.getElementById('modal-content').innerHTML = res;
            await quizModal.show();
            quiz_form_init();
        })
        .catch(err => {
            console.log(err);
        })
}

function load_answers(event, id) {
    event.preventDefault();

    fetch(`/user/get-quiz-result/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Content-Type': 'text/html',
            },
            body: {
                quiz_id: id,
            },
        })
        .then(res => res.text())
        .then(async (res) => {
            document.getElementById('modal-content').innerHTML = res;
            await quizModal.show();
        })
        .catch(err => {
            console.log(err);
        })
}

// init form submit functionalities
function quiz_form_init() {
    document.getElementById('quiz_form').onsubmit = function (e) {
        e.preventDefault();
        reset_quiz_sebmission_alerts();

        let form_data = new FormData(e.target);
        fetch('/user/submit-quiz', {
                method: "POST",
                body: form_data,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                },
            })
            .then(res => res.json())
            .then(res => {
                toggle_quiz_submit_btn();

                if (res.status !== 200) {
                    // Check for errors and provide warning messages on the status code.
                    switch (res.status) {

                        case 422: // validation error
                            document.getElementById('alert_text').innerHTML = "No question has been answered yet."
                            break;

                        case 406: // not acceptable error
                            document.getElementById('alert_text').innerHTML = res.error_message;
                            if (res.data && res.data.items) {
                                let items = res.data.items;
                                items = Object.keys(items).map((key) => items[key]);
                                items.forEach(item => {
                                    document.getElementById(item).classList.add('text-danger');
                                });
                            }
                            break;

                        default: // others server error
                            document.getElementById('alert_text').innerHTML = "There is a problem, please try again."
                            break;
                    }
                } else {
                    document.getElementById('success_text').innerHTML = res.success_message;
                    document.getElementById('obtain_mark'+res.data.quiz_id).innerHTML = res.data.correct_answers;
                    document.getElementById('quiz_load_btn'+res.data.quiz_id).remove();
                    document.getElementById('action_btns'+res.data.quiz_id).innerHTML = `
                        <a onclick="load_answers(event, ${res.data.quiz_id})" href="#">Preview Submission</a>
                    `;

                    document.getElementById('modal-content').innerHTML = res.data.preview_correct_answers;
                    // the quiz popup is hidden after 300 milliseconds.
                    // setTimeout(() => {
                    //     quizModal.hide();
                    // }, 300);
                }
            })
            .catch(err => {
                toggle_quiz_submit_btn();
                console.log(err);
            })

    }
}

//To avoid multiple submissions, clear all alerts and deactivate the submit button.

function reset_quiz_sebmission_alerts() {
    document.getElementById('alert_text').innerHTML = '';
    document.getElementById('success_text').innerHTML = '';
    document.querySelectorAll('.question_label').forEach(e => e.classList.remove("text-danger"));
    toggle_quiz_submit_btn();
}

// between the submit button and the loading button, switch the d-none class
function toggle_quiz_submit_btn() {
    let quiz_submit_processing_btn = document.getElementById('quiz_submit_processing_btn');
    let quiz_submit_btn = document.getElementById('quiz_submit_btn');

    quiz_submit_processing_btn.classList.toggle('d-none');
    quiz_submit_btn.classList.toggle('d-none');
}
