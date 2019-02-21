<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

/**
 * Class ExtractManager
 *
 * @package App
 * @property string $title
 * @property string $description
*/
class ExtractResult extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $fillable = ['title', 'link_id', 'description', 'branch', 'bullet_4', 'bullet_5', 'image_mockup', 'asin', 'date_first_amazon', 'best_sellter_rank', 'image_original'];
    protected $hidden = [];
    
    
    public static function boot()
    {
        parent::boot();

        ExtractResult::observe(new \App\Observers\UserActionsObserver);
    }
    
    /**
     * Get the ExtractResult's original image
     *
     * @param  string  $value
     * @return string
     */
    public function getImageOriginalAttribute()
    {
        return env('AMAZONE_DOMAIN_DOWNLOAD_IMAGE').$this->attributes['image_original'];
    }
}
