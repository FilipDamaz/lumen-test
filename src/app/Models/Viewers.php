<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Viewers extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'token'
    ];

    /**
     * Get the svod Package associated with the Viewer.
     */
    public function svodPackage()
    {
        $time = Carbon::now();
        return $this->belongsToMany('App\Models\SvodPackage', 'viewers_svod_package', 'id_viewer', 'id_package')
            ->where('start_date', '<=', $time->toDateTimeString())
            ->where('end_date', '>=', $time->toDateTimeString());
    }

    /**
     * Get the direct video subscription associated with the Viewer.
     */
    public function directVideos()
    {
        $time = Carbon::now();
        return $this->belongsToMany('App\Models\Videos', 'viewer_videos', 'id_viewer', 'id_video')
            ->where('start_date', '<=', $time->toDateTimeString())
            ->where('end_date', '>=', $time->toDateTimeString());
    }
}
