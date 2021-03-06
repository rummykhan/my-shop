<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Category
 * @package App\Models
 *
 * @property int $id
 *
 * @property string $name
 * @property string $image
 *
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Item[] $items
 */
class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name'
    ];

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'category_id', 'id');
    }

    public function getImageUrl()
    {
        if (!$this->image) {
            return "https://via.placeholder.com/500x500.png/006644?text=asperiores";
        }

        return asset('/categories/' . $this->image);
    }
}
