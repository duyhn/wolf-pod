<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Link
 *
 * @package App
 * @property string $link
*/
class Link extends Model
{
    use SoftDeletes;

    protected $fillable = ['link', 'status'];
    protected $hidden = [];
    
    const QUEUE_STATUS_OPEN = 0;

    const QUEUE_STATUS_PROGRESS = 1;

    const QUEUE_STATUS_COMPLETE = 2;

    const QUEUE_STATUS_FAIL = 3;

    public static function boot()
    {
        parent::boot();

        Link::observe(new \App\Observers\UserActionsObserver);
    }
    
}
