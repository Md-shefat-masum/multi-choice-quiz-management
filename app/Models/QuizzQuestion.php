<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizzQuestion extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function quizQuestionOption(){
        return $this->hasMany(QuizQuestionOption::class,'quiz_question_id');
    }

    public function quizInfo()
    {
        return $this->belongsTo(Quiz::class,'quiz_id');
    }
}
