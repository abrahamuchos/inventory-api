<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int                             $id
 * @property string                          $name
 * @property int                             $stock
 * @property string                          $sku
 * @property float                           $retail_price
 * @property int                             $user_id
 * @property int                             $reorder_level
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
 * @method static \Database\Factories\ItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereReorderLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereUserId($value)
 * @property-read \App\Models\User           $user
 * @mixin \Eloquent
 */
class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'stock',
        'sku',
        'reorder_level',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a new SKU
     * @return string
     */
    public static function generateSku(): string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        do {
            $pin = mt_rand(1000000, 9999999) . mt_rand(1000000, 9999999) . $characters[rand(0,
                    strlen($characters) - 1)];
            $sku = str_shuffle($pin);
        } while (self::where('sku', $sku)->exists());

        return $sku;
    }


}
