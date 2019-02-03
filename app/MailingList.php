<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MailingList
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Mailing[] $mailings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Subscriber[] $subscribers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailingList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailingList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailingList query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailingList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailingList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailingList whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailingList whereUpdatedAt($value)
 */
class MailingList extends Model
{
    protected $fillable = ['name', 'subscribers'];

    public function subscribers() {
        return $this->belongsToMany(Subscriber::class);
    }

    public function mailings() {
        return $this->hasMany(Mailing::class);
    }
}
