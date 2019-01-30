<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    public function lists() {
        return $this->belongsToMany(MailingList::class);
    }
}
