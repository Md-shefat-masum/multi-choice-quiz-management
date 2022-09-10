let get_delete_modal = document.getElementById('deleteModal');
if (get_delete_modal) {
    var deleteModal = new bootstrap.Modal(get_delete_modal);
}

function show_delete_form(event) {
    event.preventDefault();
    document.querySelector('#deleteModal form').action = event.target.href;
    deleteModal.show();
}

let quiz_creation_table = document.querySelector('.quiz_creation_table');
let quiz_edit_table = document.querySelector('.quiz_edit_table');

if (quiz_creation_table) {
    let questions = [];

    let question_schema = {
        title: '',
        options: [{
                title: '',
                is_correct: false,
            },
            {
                title: '',
                is_correct: false,
            },
            {
                title: '',
                is_correct: false,
            },
            {
                title: '',
                is_correct: false,
            },
        ]
    };

    function add_question() {
        questions.push(JSON.parse(JSON.stringify(question_schema)));
        render();
    }

    function remove_question(index) {
        questions.splice(index, 1);
        render();
    }

    function add_option(index) {
        let temp = [...questions[index].options];
        temp.push({
            title: '',
            is_correct: false,
        });
        questions[index].options = temp;
        render();
    }

    function remove_option(index, question_index) {
        let temp = [...questions[index].options]
        temp.splice(question_index, 1);
        questions[index].options = temp;
        render();
    }

    function set_question_title(question_index, event) {
        questions[question_index].title = event.target.value;
    }

    function set_question_option_title(question_index, option_index, event) {
        questions[question_index].options[option_index].title = event.target.value;
    }

    function set_question_option_check(question_index, option_index, event) {
        questions[question_index].options[option_index].is_correct = event.target.checked;
    }

    function render_options(question_index, options) {
        return options.map((option, option_index) => {
            let option_body = `
                <li key="${option_index+1}" class="mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <span>${option_index+1}.</span>
                        <input ${option.is_correct?'checked':''} onchange="set_question_option_check(${question_index},${option_index},event)" value="${option}" type="checkbox">
                        <textarea value="" onkeyup="set_question_option_title(${question_index},${option_index},event)" type="text" class="form-control">${option.title}</textarea>
            `;
            if (options.length > 1) {
                option_body += `
                    <button type="button" onclick="remove_option(${question_index},${option_index})" class="btn btn-danger btn-sm">-</button>
                `;
            }
            option_body += `
                </div>
                <div class="text-danger">${option.title_error || ''}</div>
            </li>
            `
            return option_body;
        }).join('');
    }

    function render() {
        let quiz_maker_body = questions.map((item, question_index) => {
            let option_html = render_options(question_index, item.options);
            let table_rows = `
                <tr>
                    <td>${question_index+1}</td>
                    <td>
                        <textarea type="text" onkeyup="set_question_title(${question_index},event)" value="" class="form-control">${item.title||''}</textarea>
                        <div class="text-danger">${item.title_error || ''}</div>
                    </td>
                    <td>
                        <ul class="list-unstyled">
                            ${option_html}
                        </ul>
                        <div class="text-center">
                            <button onclick="add_option(${question_index})" type="button" class="btn btn-sm btn-success">add more</button>
                        </div>
                    </td>
            `;

            if (questions.length > 1 && !quiz_edit_table) {
                table_rows += `
                    <td>
                        <button onclick="remove_question(${question_index})" class="btn btn-sm btn-danger">delete</button>
                    </td>
                </tr>
                `;
            } else {
                table_rows += `</tr>`;
            }
            return table_rows;
        }).join('');
        document.querySelector('.quiz_creation_table tbody').innerHTML = quiz_maker_body;
    }

    function reset_question() {
        questions = [];
        add_question();
        render();
    }

    if (quiz_edit_table) {
        fetch(`/admin/question/single-question/${quiz_edit_table.dataset.id}`)
            .then(res => res.json())
            .then(res => {
                question_schema = res;
                reset_question();
            })
    } else {
        reset_question();
    }

    document.getElementById('quiz_question_form').addEventListener('submit', function (e) {
        e.preventDefault();
        document.querySelectorAll('.text-danger').forEach(i => i.innerHTML = '');
        submit_btn.disabled = true;

        let form_data = new FormData(e.target);
        form_data.append('questions', JSON.stringify(questions));
        fetch(e.target.action, {
                method: 'POST',
                body: form_data,
            })
            .then(res => res.json())
            .then(res => {
                submit_btn.disabled = false;
                if (res.status === 422) {
                    alert('inaccuracy in data validation. kindly review below')
                    questions = res.data;
                    render();
                }
                if (res === 'success') {
                    alert('question submitted successfully');
                    if (!quiz_edit_table) {
                        reset_question();
                    }
                }
            })
            .catch(err => {
                console.log(err);
            })
    })

}

let question_append_table = document.querySelector('.question_append_table');
if (question_append_table) {
    let selected_count = document.getElementById('selected_count');
    // window.selected_question_list = [];

    function add_question(event) {
        let checked = event.target.checked;
        let data = event.target.value;

        if (checked) {
            selected_question_list.push(data);
        } else {
            const index = selected_question_list.indexOf(data.toString())
            if (index >= 0) {
                selected_question_list.splice(index, 1);
            }
        }

        selected_count.innerHTML = selected_question_list.length;
    }

    function selected_question_remove(data) {
        const index = selected_question_list.indexOf(data.toString())
        if (index >= 0) {
            selected_question_list.splice(index, 1);
            selected_question_render();
        }
    }

    function selected_question_render() {
        // console.log(selected_question_list);
        let form_data = new FormData();
        form_data.append('id', JSON.stringify(selected_question_list));

        fetch('/admin/question/json-by-id', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                },
                body: form_data
            })
            .then(res => res.json())
            .then(res => {
                let html = res.map((i) => `
                    <tr>
                        <td>${i.id}</td>
                        <td>${i.title}</td>
                        <td>
                            <a onclick="selected_question_remove(${i.id})" class="btn btn-sm btn-warning m-2" href="#">Remove</a>
                        </td>
                    </tr>
                `).join('');
                document.querySelector('.question_selected_table tbody').innerHTML = html;
            })
    }

    function create_quiz_question(event) {
        event.preventDefault();
        let form_data = new FormData(event.target);
        form_data.append('question_ids', JSON.stringify(selected_question_list));

        fetch('/admin/quiz/attach-quiz-question-store', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                },
                body: form_data
            })
            .then(res => res.json())
            .then(res => {
                console.log(res);
                if (res == "success") {
                    alert('Quiz created successfully. ');
                }
            })
    }
}
