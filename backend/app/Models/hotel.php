<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hotel extends Model
{
    use HasFactory;
    protected $table = 'hotels';
    protected $fillable = [
        'id',
        'hotel_name',
        'address1',
        'address2',
        'city_id',
        'telephone',
        'email',
        'fax',
        'company_name',
        'tax_code',
        'user_id',
        'hotel_code',
        
    ];
    public function hotels()
    {
        return $this->hasMany(Hotel::class); // If the city has many hotels
    }
    public function city()
    {
        return $this->belongsTo(City::class); // If the hotel belongs to a city
    }
}

