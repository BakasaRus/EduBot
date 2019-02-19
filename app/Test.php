<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'name', 'description', 'is_available', 'time_limit', 'max_attempts'
    ];

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
                    ->withPivot(['started_at', 'attempts', 'max_points', 'points'])
                    ->as('info');
    }

    public function current_subscribers() {
        return $this->hasMany(Subscriber::class, 'test_id');
    }

    public function getTimeLimitHumansAttribute() {
        if (intdiv($this->time_limit, 60) > 0)
            return intdiv($this->time_limit, 60) . " ч. " . $this->time_limit % 60 . " мин.";
        else
            return $this->time_limit % 60 . " мин.";
    }

    static function availableList() {
        $available = static::where('is_available', true)->get();
        $list = "";
        foreach ($available as $test) {
            $list .= $test->id . ". " . $test->name . "\r\n";
        }

        if ($list == "")
            $list = null;

        return $list;
    }
}
