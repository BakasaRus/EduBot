<?php

namespace App;

use ATehnix\VkClient\Client;
use ATehnix\VkClient\Exceptions\VkException;
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
}
