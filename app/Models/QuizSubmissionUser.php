<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSubmissionUser extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class,'quiz_id');
    }

    public function quiz_submission()
    {
        return $this->hasMany(QuizSubmission::class,'submission_id');
    }
}
