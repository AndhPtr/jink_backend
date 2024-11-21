<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextContent extends Model
{
    use HasFactory;

    protected $table = 'text_content';

    protected $fillable = ['content'];

    /**
     * Define the inverse of the polymorphic relationship.
     */
    public function pagesContent()
    {
        return $this->morphOne(PageContent::class, 'blockable');
    }
}
