<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['text', 'correct_answer', 'test_id'];

    public function test() {
        return $this->belongsTo(Test::class);
    }

    public function subscribers() {
        return $this->belongsToMany(Subscriber::class, 'question_result')
                    ->using(QuestionResult::class)
                    ->withTimestamps()
                    ->withPivot(['answer'])
                    ->as('results');
    }
}
