<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageContent extends Model
{
    use HasFactory;

    protected $table = 'image_content';

    protected $fillable = ['image_url', 'alt_text'];

    /**
     * Define the inverse of the polymorphic relationship.
     */
    public function pagesContent()
    {
        return $this->morphOne(PageContent::class, 'blockable');
    }
}
