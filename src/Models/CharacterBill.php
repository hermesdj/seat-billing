<?php

namespace Denngarr\Seat\Billing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Seat\Eveapi\Models\Character\CharacterInfo;
use Seat\Eveapi\Models\Corporation\CorporationInfo;
use Seat\Web\Models\User;

class CharacterBill extends Model
{
    public $timestamps = true;

    protected $table = 'seat_billing_character_bill';

    protected $fillable = ['id', 'character_id', 'month', 'year', 'mining_bill', 'mining_taxrate'];

    public function character(): BelongsTo
    {
        return $this->belongsTo(CharacterInfo::class,'character_id','character_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'id','user_id');
    }

    public function corporation(): BelongsTo
    {
        return $this->belongsTo(CorporationInfo::class,'corporation_id','corporation_id');
    }

    public function tax_invoice(): HasOne
    {
        return $this->hasOne(TaxInvoice::class,'id','tax_invoice_id');
    }
}
