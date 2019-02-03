<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Mailing
 *
 * @property int $id
 * @property string $name
 * @property string $text
 * @property string|null $attachments
 * @property string|null $send_at
 * @property int $mailing_list_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\MailingList $mailingList
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing whereMailingListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing whereSendAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mailing whereUpdatedAt($value)
 */
	class Mailing extends \Eloquent {}
}

namespace App{
/**
 * App\MailingList
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Mailing[] $mailings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Subscriber[] $subscribers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailingList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailingList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailingList query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailingList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailingList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailingList whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailingList whereUpdatedAt($value)
 */
	class MailingList extends \Eloquent {}
}

namespace App{
/**
 * App\Subscriber
 *
 * @property int $id
 * @property int $agreed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\MailingList[] $lists
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Subscriber onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereAgreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subscriber withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Subscriber withoutTrashed()
 */
	class Subscriber extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

