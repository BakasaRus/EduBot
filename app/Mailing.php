<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{
    protected $fillable = ['name', 'text', 'attachments', 'send_at', 'mailing_list_id'];

    public function mailingList() {
        return $this->belongsTo(MailingList::class);
    }
}
