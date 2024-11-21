<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    use HasFactory;

    // Define the table name (optional if naming conventions are followed)
    protected $table = 'pages_content';

    // Mass-assignable fields
    protected $fillable = ['pages_id', 'blockable_id', 'blockable_type'];

    /**
     * Define the polymorphic relationship for the blockable field.
     */
    public function blockable()
    {
        return $this->morphTo();
    }

    /**
     * Relationship with the parent page.
     */
    public function page()
    {
        return $this->belongsTo(Pages::class, 'pages_id');
    }
}
