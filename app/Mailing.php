<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{
    public function mailingList() {
        return $this->belongsTo(MailingList::class);
    }
}
