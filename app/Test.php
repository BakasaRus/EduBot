<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = ['name', 'description', 'is_available'];

    protected $casts = [
        'is_available' => 'boolean'
    ];

    public function questions() {
        return $this->hasMany(Question::class);
    }

    public function subscribers() {
        return $this->belongsToMany(Subscriber::class, 'test_result')
                    ->using(TestResult::class)
                    ->withTimestamps()
                    ->withPivot(['status'])
                    ->as('info');
    }
}
