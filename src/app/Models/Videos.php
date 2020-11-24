<?php

namespace App\Models;


use App\Models\Interfaces\ResourcesInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model implements ResourcesInterface
{
    protected $primaryKey = 'id_video';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'currency'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the svod Package associated with the Viewer.
     */
    public function svodPackage()
    {
        return $this->belongsToMany('App\Models\SvodPackage', 'videos_svod_packages', 'id_video', 'id_package');
    }

    /**
     * check if curent user have access to SVOD Package
     *
     * @var boolen
     */
    public function checkIfUserHasAccess():bool
    {
        if(\Auth::user()->directVideos->find($this->id_video))
        {
            return true;
        }

        $currentAssociatedPackagesToVideo = $this->svodPackage->all();
        if(!$currentAssociatedPackagesToVideo) {
            $currentAssociatedPackagesToVideo[] = SvodPackage::whereNull('parent_id')->where('is_active',true)->first();
        }

        foreach ($currentAssociatedPackagesToVideo as $currentAssociatedPackageToVideo) {
            if ($currentAssociatedPackageToVideo->checkIfUserHasAccess()) {
                return true;
            }
        }

        return false;
    }
}
