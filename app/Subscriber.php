<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = ['id'];

    public function lists() {
        return $this->belongsToMany(MailingList::class);
    }
}
