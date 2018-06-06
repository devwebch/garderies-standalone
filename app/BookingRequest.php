<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingRequest extends Model
{
    use SoftDeletes;

    public const STATUS_PENDING     = 0;
    public const STATUS_APPROVED    = 1;
    public const STATUS_DENIED      = 2;



}
