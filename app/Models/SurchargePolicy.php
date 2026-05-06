<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurchargePolicy extends Model
{
    protected $table = 'surcharge_policies';
    protected $fillable = ['policy_type', 'hour_mark', 'price'];
    public $timestamps = false;

    const POLICY_EARLY_CHECKIN = 'early_checkin';
    const POLICY_LATE_CHECKOUT = 'late_checkout';
}
