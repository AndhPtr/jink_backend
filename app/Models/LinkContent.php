<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkContent extends Model
{
    use HasFactory;

    protected $table = 'link_content';

    protected $fillable = ['url', 'label'];

    /**
     * Define the inverse of the polymorphic relationship.
     */
    public function pagesContent()
    {
        return $this->morphOne(PageContent::class, 'blockable');
    }
}
