<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';
    public $timestamps = false;

    protected $fillable = [
        'name', 
        'equipment_category_id',
        'import_price',
    ];

    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class, 'equipment_category_id');
    }
}
