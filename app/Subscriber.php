<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends Model
{
    use SoftDeletes;

    protected $fillable = ['id'];
    protected $dates = ['deleted_at'];

    public function lists() {
        return $this->belongsToMany(MailingList::class);
    }
}
