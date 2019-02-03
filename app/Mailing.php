<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Mailing
 *
 * @property-read \App\MailingList $mailingList
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $text
 * @property string|null $attachments
 * @property string|null $send_at
 * @property int $mailing_list_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
    protected $fillable = ['name', 'text', 'attachments', 'send_at', 'mailing_list_id'];

    public function mailingList() {
        return $this->belongsTo(MailingList::class);
    }
}
