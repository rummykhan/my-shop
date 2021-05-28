<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Item
 * @package App\Models
 *
 * @property int $id
 *
 * @property string $title
 * @property string $image
 * @property float $price
 * @property integer $category_id
 * @property integer $seller_id
 *
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Seller $seller
 */
class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    public function getImageUrl()
    {
        if (!$this->image) {
            return "https://via.placeholder.com/500x500.png/006644?text=asperiores";
        }

        return asset('/items/' . $this->image);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id', 'id');
    }
}
