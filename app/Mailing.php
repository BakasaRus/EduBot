<?php

namespace App;

use ATehnix\VkClient\Client;
use ATehnix\VkClient\Exceptions\VkException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Mailing
 *
 * @property-read \App\MailingList $mailingList
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Mailing onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Mailing withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Mailing withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $text
 * @property string|null $attachments
 * @property \Illuminate\Support\Carbon|null $send_at
 * @property int $mailing_list_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing whereMailingListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing whereSendAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing whereUpdatedAt($value)
 */
class Mailing extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'text', 'attachments', 'send_at', 'mailing_list_id'];

    protected $dates = ['deleted_at', 'send_at'];

    public function mailingList() {
        return $this->belongsTo(MailingList::class);
    }

    /**
     * Send Mailing to Subscribers
     *
     * @return bool Was sending successful or not
     * @throws \Exception
     */
    public function send() {
        if (is_null($this->send_at)) {
            $this->send_at = Carbon::now();
            $this->save();
        }
        $this->delete();

        $is_successful = true;

        $api = new Client('5.92');
        $api->setDefaultToken(config('services.vk.group_token'));

        $count = 100;
        $all = $this->mailingList->subscribers->pluck('id');
        $random_id = random_int(PHP_INT_MIN, PHP_INT_MAX);

        while ($all->isNotEmpty()) {
            $current = $all->splice(0, $count);

            try {
                $api->request('messages.send', [
                    'user_ids' => $current->all(),
                    'message' => $this->text,
                    'attachment' => $this->attachments,
                    'random_id' => $random_id
                ]);
            }
            catch (VkException $e) {
                \Log::error("VK Error {$e->getCode()}: {$e->getMessage()}");
                $is_successful = false;
            }
        }

        return $is_successful;
    }
}
