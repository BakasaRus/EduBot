<?php

namespace App;

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
}
