<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionOption;
use App\Models\QuizSubmission;
use App\Models\QuizSubmissionUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quizes = [
            [
                'title' => "HTML",
                "questions" => [
                    'question_1' => [
                        'correct' => '<html>',
                        'title' => 'What is the first tag you should see in an HTML file?',
                        'option' => [
                            '<title>',
                            '<html>',
                            '<body>',
                            '<h1>',
                        ]
                    ],
                    'question_2' => [
                        'correct' => '.html',
                        'title' => 'You should save HTML files with which file extension?',
                        'option' => [
                            '.index',
                            '.html',
                            '.webpage',
                            '.htm',
                        ]
                    ],
                    'question_3' => [
                        'correct' => 'Defines a paragraph',
                        'title' => 'What is the function of the p tag?',
                        'option' => [
                            'Defines a paragraph',
                            'Makes the text purple',
                            'It pushes the text to the right',
                            'Prints the webpage',
                        ]
                    ],
                    'question_4' => [
                        'correct' => '<img>',
                        'title' => 'Name an element which doesn\'t have a closing tag.',
                        'option' => [
                            '<img>',
                            '<head>',
                            '<body>',
                            '<p>',
                        ]
                    ],
                    'question_5' => [
                        'correct' => '<title>',
                        'title' => 'What HTML element defines the title of the document?',
                        'option' => [
                            '<title>',
                            '<head>',
                            '<meta>',
                            '<link>',
                        ]
                    ],
                    'question_6' => [
                        'correct' => 'H2',
                        'title' => 'Which of the following is the largest heading? ',
                        'option' => [
                            'H3',
                            'H2',
                            'H5',
                            'H6',
                        ]
                    ],
                    'question_7' => [
                        'correct' => '<ul>',
                        'title' => 'The following tag will show a bulleted list',
                        'option' => [
                            '<ul>',
                            '<ol>',
                            '<li>',
                            '<list>',
                        ]
                    ],
                    'question_8' => [
                        'correct' => '<img src="untitled.jpg"/>',
                        'title' => 'What is the correct syntax for inserting an image?',
                        'option' => [
                            '<image source="untitled.jpg"/>',
                            '<img src="untitled.jpg"/>',
                            '<src img="untitled.jpg"/>',
                            '<img scr="untitled.jpg"/>',
                        ]
                    ],
                    'question_9' => [
                        'correct' => '/',
                        'title' => 'Which character is used to indicate an end tag?',
                        'option' => [
                            '{}',
                            '<',
                            '/',
                            '*',
                        ]
                    ],
                    'question_10' => [
                        'correct' => 'Hyper Text Markup Language',
                        'title' => 'What does HTML stand for?',
                        'option' => [
                            'Home Tool Markup Language',
                            'Hyperlinks and Text Markup Language ',
                            'Hyper Text Markup Language',
                            'Hyper Text Marker Language',
                        ]
                    ],
                ]
            ],
            [
                'title' => "CSS",
                'questions' => [
                    'question_1' => [
                        'correct' => 'font-family',
                        'title' => 'Which of the following property is used to change the face of a font?',
                        'option' => [
                            'font-family',
                            'font-style',
                            'font-variant',
                            'font-weight',
                        ]
                    ],
                    'question_2' => [
                        'correct' => 'letter-spacing',
                        'title' => 'Which of the following property is used to add or subtract space between the letters that make up a word?',
                        'option' => [
                            'color',
                            'direction',
                            'letter-spacing',
                            'word-spacing',
                        ]
                    ],
                    'question_3' => [
                        'correct' => 'list-style-type',
                        'title' => 'Which of the following property specifies an image for the marker rather than a bullet point or number?',
                        'option' => [
                            'list-style-type',
                            'list-style-position',
                            'list-style-image',
                            'list-style',
                        ]
                    ],
                    'question_4' => [
                        'correct' => 'Cascading Style Sheets',
                        'title' => 'CSS stands for',
                        'option' => [
                            'Computer Style Sheets',
                            'Creative Style Sheets',
                            'Canvas Styling System',
                            'Cascading Style Sheets',
                        ]
                    ],
                    'question_5' => [
                        'correct' => 'padding',
                        'title' => 'How can you add space between the border and inner content of the element?',
                        'option' => [
                            'padding',
                            'margin',
                            'border',
                            'spacing',
                        ]
                    ],
                    'question_6' => [
                        'correct' => 'border-radius: 30px;',
                        'title' => 'How can you created rounded corners using CSS3?',
                        'option' => [
                            'border[round]: 30px;',
                            'border-radius: 30px;',
                            'corner-effect: round;',
                            'alpha-effect: round-corner;',
                        ]
                    ],
                    'question_7' => [
                        'correct' => 'Red Green Blue alpha',
                        'title' => 'What does RGBa mean?',
                        'option' => [
                            '<Red Gold Black alpha',
                            'Review Get assistance Back-up your information acquire proof',
                            'Red Green Blue alpha',
                            'Red Gray Brown alpha',
                        ]
                    ],
                    'question_8' => [
                        'correct' => 'top, right, bottom, left',
                        'title' => 'How do four values work on border-radius',
                        'option' => [
                            'up, down, front, behind',
                            'top-left, top-right, bottom-right, bottom-left',
                            'top, right, bottom, left',
                            'bottom-left, bottom-right, top-right, top-left',
                        ]
                    ],
                    'question_9' => [
                        'correct' => 'id',
                        'title' => 'The _____________ selector is used to specify a style for a single, unique element',
                        'option' => [
                            'id',
                            'text',
                            'bit',
                            'class',
                        ]
                    ],
                    'question_10' => [
                        'correct' => 'h2 {font-size:200px;}',
                        'title' => 'Which of the below is the correct way to set a font size?',
                        'option' => [
                            'h2 {font-size:200ltr;}',
                            'h2 {font-size:200ton;}',
                            'h2 {font-size:200px;}',
                            'h2 {font-size:200;}',
                        ]
                    ],
                ],
            ],
            [
                'title' => "Github",
                'questions' => [
                    'question_1' => [
                        'correct' => 'A version/source control system',
                        'title' => 'What is Git?',
                        'option' => [
                            'A programming language',
                            'A nick name for github',
                            'A version/source control system',
                            'A remote repository platform',
                        ]
                    ],
                    'question_2' => [
                        'correct' => 'git --version',
                        'title' => 'What is the command to get the installed version of Git?',
                        'option' => [
                            'getGitVersion',
                            'git help --version',
                            'git version',
                            'git --version',
                        ]
                    ],
                    'question_3' => [
                        'correct' => 'git add .',
                        'title' => 'What is the command to add all files and changes of the current folder to the staging environment of the Git repository?',
                        'option' => [
                            'git add',
                            'git add files',
                            'git add all',
                            'git add .',
                        ]
                    ],
                    'question_4' => [
                        'correct' => 'git status',
                        'title' => 'What is the command to get the current status of the Git repository?',
                        'option' => [
                            'git getStatus',
                            'git status',
                            'git --status',
                            'git config --status',
                        ]
                    ],
                    'question_5' => [
                        'correct' => 'git init',
                        'title' => 'What is the command to initialize Git on the current repository?',
                        'option' => [
                            'start git',
                            'git init',
                            'git start',
                            'initialize git',
                        ]
                    ],
                    'question_6' => [
                        'correct' => 'false',
                        'title' => 'Git automatically adds new files to the repository and starts tracking them.',
                        'option' => [
                            'true',
                            'false',
                            'what is git',
                            'there is no need to add file',
                        ]
                    ],
                    'question_7' => [
                        'correct' => 'commit history is never automatically deleted',
                        'title' => 'Git commit history is automatically deleted:',
                        'option' => [
                            'every month',
                            'every 2 weeks',
                            'every year',
                            'commit history is never automatically deleted',
                        ]
                    ],
                    'question_8' => [
                        'correct' => 'git commit',
                        'title' => 'What is the command to commit the staged changes for the Git repository?',
                        'option' => [
                            'git branch',
                            'git add',
                            'git remote',
                            'git commit',
                        ]
                    ],
                    'question_9' => [
                        'correct' => 'git commit -m "new email"',
                        'title' => 'What is the command to commit with the message "New email"?',
                        'option' => [
                            'git commit -n "new email"',
                            'git commit -d "new email"',
                            'git commit -m "new email"',
                            'git commit -l "new email"',
                        ]
                    ],
                    'question_10' => [
                        'correct' => 'A separate version of the main repository',
                        'title' => 'In Git, a branch is:',
                        'option' => [
                            'A separate version of the main repository',
                            'A secret part of git config',
                            'A small wooden stick you can use to type commands',
                            'nothing, it is a nonesense word',
                        ]
                    ],
                ],
            ],
        ];

        DB::table('quiz_quiz_question')->truncate();
        Quiz::truncate();
        QuizQuestion::truncate();
        QuizQuestionOption::truncate();
        QuizSubmission::truncate();
        QuizSubmissionUser::truncate();

        foreach ($quizes as $item) {
            $quiz = Quiz::create([
                'title' => $item['title'],
                'creator' => 1,
                'slug' => strtolower(str_replace(' ','-',$item['title'])),
            ]);

            $question_ids = [];
            foreach ($item['questions'] as $question) {
                $quiz_question = QuizQuestion::create([
                    // 'quiz_id' => $quiz->id,
                    'title' => $question['title'],
                    'creator' => 1,
                ]);
                $quiz_question->slug = rand(1000000000,9999999999).$quiz_question->id;
                $quiz_question->save();
                $question_ids[] = $quiz_question->id;

                foreach ($question['option'] as $option) {
                    $option = QuizQuestionOption::create([
                        // 'quiz_id' => $quiz->id,
                        'quiz_question_id' => $quiz_question->id,
                        'title' => $option,
                        'is_correct' => $question['correct'] == $option ? 1 : 0,
                    ]);
                    $option->slug = rand(1000000000,9999999999).$option->id;
                    $option->save();
                }
            }

            $quiz->related_quesions()->detach();
            $quiz->related_quesions()->attach($question_ids);
        }
    }
}
