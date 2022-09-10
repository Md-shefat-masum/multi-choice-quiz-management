![visitors](https://visitor-badge.laobi.icu/badge?page_id=Md-shefat-masum.hiring-portal.readme)
# Welcome to Hiring Portal

##  Table of contents
* [Introduction](#introduction)
* [Features](#features)
* [Technologies](#technologies)
* [Demo Screenshots](#demo-screenshots)
* [Setup](#setup)

##  Introduction
The "Hiring Portal" is a website where applicants can post their resumes and take skill tests. The recruitment team is capable of managing applicants, monitoring their outcomes and information, and even developing quizzes.

##  Features

This website has two Roles:

 - Applicants
 - Admin

 ### Applicants:
 - May change the details of their profile
 - Can update CV/Resume Links
 - Can see whether a confirmation is pending, accepted, or refused.
 - If the admin deleted him, the user account will be marked as blocked.
 
 ### Admin:
 - can manage all applicants.
	 - approve, reject, and delete
	 - observe applicant information
	 - see the results of the applicant quiz

 - quiz management
	 - manage quiz topics
		 - create
		 - edit
		 - update
		 - delete
	 - manage quiz questions
		 - create
		 - edit
		 - update
		 - delete
	 - manage quiz
		 - attach quiz question to each topics
		 - edit
		 - delete
		 - 
## Technologies
* PHP Laravel
* mySQL
* HTML
* Java Script
* Bootstrap

## Demo Screenshots
<div>
	<h3> Login </h3>
	<img width="700" src="https://github.com/Md-shefat-masum/hiring-portal/blob/main/demo/login.jpg?raw=true">
</div>

<div>
	<h3> Registration </h3>
	<img width="700" src="https://github.com/Md-shefat-masum/hiring-portal/blob/main/demo/registration.jpg?raw=true">
</div>

<div>
	<h3> User dashboard</h3>
	<img width="700" src="https://github.com/Md-shefat-masum/hiring-portal/blob/main/demo/user dashboard.jpg?raw=true">
</div>

<div>
	<h3> Update information</h3>
	<img width="700" src="https://github.com/Md-shefat-masum/hiring-portal/blob/main/demo/update-info.jpg?raw=true">
</div>

<div>
	<h3>Quiz test</h3>
	<img width="700" src="https://github.com/Md-shefat-masum/hiring-portal/blob/main/demo/quiz-test.jpg?raw=true">
</div>

<div>
	<h3>Quiz result</h3>
	<img width="700" src="https://github.com/Md-shefat-masum/hiring-portal/blob/main/demo/quiz-result.jpg?raw=true">
</div>

<div>
	<h3>Admin dashboard</h3>
	<img width="700" src="https://github.com/Md-shefat-masum/hiring-portal/blob/main/demo/admin-dashboard.jpg?raw=true">
</div>

<div>
	<h3>Candidate list</h3>
	<img width="700" src="https://github.com/Md-shefat-masum/hiring-portal/blob/main/demo/candidate-list.jpg?raw=true">
</div>

<div>
	<h3>Quiz topics</h3>
	<img width="700" src="https://github.com/Md-shefat-masum/hiring-portal/blob/main/demo/quiz-topics.jpg?raw=true">
</div>
<div>
	<h3>Quiz preview</h3>
	<img width="700" src="https://github.com/Md-shefat-masum/hiring-portal/blob/main/demo/quiz-preview.jpg?raw=true">
</div>

<div>
	<h3>Select question for quiz</h3>
	<img width="700" src="https://github.com/Md-shefat-masum/hiring-portal/blob/main/demo/select-question-for-quiz.jpg?raw=true">
</div>

<div>
	<h3>Submit selected question</h3>
	<img width="700" src="https://github.com/Md-shefat-masum/hiring-portal/blob/main/demo/check-selected-question-submit.jpg?raw=true">
</div>

<div>
	<h3>Question Bank</h3>
	<img width="700" src="https://github.com/Md-shefat-masum/hiring-portal/blob/main/demo/question-list.jpg?raw=true">
</div>

<div>
	<h3>Question create</h3>
	<img width="700" src="https://github.com/Md-shefat-masum/hiring-portal/blob/main/demo/question-create.jpg?raw=true">
</div>

<div>
	<h3>Error validation</h3>
	<img width="700" src="https://github.com/Md-shefat-masum/hiring-portal/blob/main/demo/create-validation.jpg?raw=true">
</div>

<div>
	<h3>Question edit</h3>
	<img width="700" src="https://github.com/Md-shefat-masum/hiring-portal/blob/main/demo/edit-question.jpg?raw=true">
</div>

## Setup

####  Installation
**requirements**

 1. PHP: 7.3 | ^8.0
 2. Laravel : ^8.75

First clone this repository, install the dependencies, and setup your .env file.

**run the commands**
```
git clone https://github.com/Md-shefat-masum/hiring-portal.git
composer install
cp .env.example .env
```

**database setup**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=root
DB_PASSWORD=
```

Then migrate database, and seed
```
fresh migration db and seed
	php artisan migrate:fresh --seed 
	
custom seed:
	php artisan db:seed UserSeeder
	php artisan db:seed QuizSeeder
```

Finally run
```
php artisan serve
or
php artisan serve --port=8001 | any supported port number
```
the project will open at http://127.0.0.1:8000

**database seed will generate**

 -  login information for one administrator and ten users.
 -  30 question tests on HTML, CSS, and Github

####  login credentials

**admin:** 
email: admin@gmail.com 
pass: @12345678

##### Candidates login:

|     Email      |   password                                            
|----------------|-------------------------------------|
|user1@gmail.com |`@12345678`                        |
|user2@gmail.com |`@12345678`                       |
|user3@gmail.com |`@12345678`
|user4@gmail.com |`@12345678`
|user5@gmail.com |`@12345678`
|user6@gmail.com |`@12345678`
|user7@gmail.com |`@12345678`
|user8@gmail.com |`@12345678`
|user9@gmail.com |`@12345678`
|user10@gmail.com |`@12345678`
