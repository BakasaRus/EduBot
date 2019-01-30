<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
