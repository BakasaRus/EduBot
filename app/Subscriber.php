<?php

namespace App;

use ATehnix\VkClient\Client;
use ATehnix\VkClient\Exceptions\VkException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Subscriber
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\MailingList[] $lists
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Subscriber onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Subscriber withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Subscriber withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $full_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereUpdatedAt($value)
 */
class Subscriber extends Model
{
    use SoftDeletes;

    protected $fillable = ['id'];
    protected $dates = ['deleted_at'];

    public function lists() {
        return $this->belongsToMany(MailingList::class);
    }

    public function questions() {
        return $this->belongsToMany(Question::class, 'question_result')
                    ->using(QuestionResult::class)
                    ->withTimestamps()
                    ->withPivot(['answer'])
                    ->as('results');
    }

    public function tests() {
        return $this->belongsToMany(Test::class, 'test_result')
                    ->using(TestResult::class)
                    ->withTimestamps()
                    ->withPivot(['started_at', 'attempts', 'max_points', 'points'])
                    ->as('info');
    }

    public function current_question() {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function current_test() {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function getTestInfoAttribute() {
        $info = TestResult::firstOrCreate([
            'test_id' => $this['test_id'],
            'subscriber_id' => $this['id']
        ]);
        return $info;
    }

    /**
     * Useful getter for full name
     *
     * @return string
     */
    public function getFullNameAttribute() {
        return $this->name . ' ' . $this->surname;
    }

    /**
     * Get Subscriber's name and surname from VK and save them here.
     */
    public function setNameFromVk() {
        $api = new Client('5.92');
        $api->setDefaultToken(config('services.vk.group_token'));

        try {
            $response = $api->request('users.get', [
                'user_ids' => $this->id
            ])['response'][0];

            $this->name = $response['first_name'];
            $this->surname = $response['last_name'];
            $this->save();
        }
        catch (VkException $e) {
            \Log::error("VK Error {$e->getCode()}: {$e->getMessage()}");
        }
    }

    public function startTest() {
        $info = $this->test_info;
        $info->started_at = Carbon::now();
        $info->attempts++;
        $info->max_points = $this->current_test->questions()->count();
        $info->points = 0;
        $info->save();

        $ids = $this->questions()->where('test_id', $this['test_id'])->get()->pluck('id');
        $this->questions()->detach($ids);

    }

    public function finishTest() {
        $this->current_question()->dissociate();
        $this->current_test()->dissociate();
        $this->save();
    }
}
