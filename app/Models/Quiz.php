<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function quizQuestion()
    {
        return $this->hasMany(QuizQuestion::class, 'quiz_id');
    }

    public function related_quesions()
    {
        return $this->belongsToMany(QuizQuestion::class);
    }
}
