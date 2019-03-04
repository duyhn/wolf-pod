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

    protected $fillable = ['title', 'link_id', 'description', 'branch', 'image_mockup', 'price','asin', 'public_date', 'rank', 'image_original', 'image_clean'];
    protected $hidden = [];
    
    
    public static function boot()
    {
        parent::boot();

        ExtractResult::observe(new \App\Observers\UserActionsObserver);
    }

    /**
     * Get the features
     *
     * @return hasMany
     */
    public function features()
    {
        return $this->hasMany(ExtractResultFeature::class);
    }
}
