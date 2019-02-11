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

    static function availableList(Subscriber $subscriber) {
        $available = static::where('is_available', true)->get();
        $list = "";
        foreach ($available as $test) {
            $status = $test->subscribers
                ->where('id', $subscriber->id)
                ->first()
                ->info
                ->status;
            $list .= $test->id . ". " . $test->name .
                ($status == 2 ? " (Пройден)" : " (Не пройден)") . "\r\n";
        }

        if ($list == "")
            $list = null;

        return $list;
    }
}
