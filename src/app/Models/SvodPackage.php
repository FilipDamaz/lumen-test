<?php

namespace App\Models;

use App\Models\Interfaces\ResourcesInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SvodPackage extends Model implements ResourcesInterface
{
    protected $primaryKey = 'id_package';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'currency', 'description', 'is_active', 'duration'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['parent_id'];



    /**
     * Get the direct video subscription associated with the Viewer.
     */
    public function videos()
    {
        $time = Carbon::now();
        return $this->belongsToMany('App\Models\Videos', 'videos_svod_packages', 'id_package', 'id_video')
            ->where('start_date', '<=', $time->toDateTimeString())
            ->where('end_date', '>=', $time->toDateTimeString());
    }

    /**
     * check if curent user have access to SVOD Package
     *
     * @var boolen
     */
    public function checkIfUserHasAccess():bool
    {
        if(isset($this->id_package)) {
            if (\Auth::user()->is_admin) {
                return true;
            }

            $currentUserPackages = \Auth::user()->svodPackage->all();
            foreach ($currentUserPackages as $currentUserPackage) {
                if ($currentUserPackage->id_package == $this->id_package || empty($currentUserPackage->parent_id)) {
                    return true;
                }
                if (!empty($this->parent_id)) {
                    $parent_id = $this->parent_id;
                    do {
                        $parenPackage = SvodPackage::where('is_active', true)->find($parent_id);
                        if ($parenPackage->id_package == $currentUserPackage->id_package) {
                            return true;
                        }
                        $parent_id = $parenPackage->parent_id;
                    } while (!empty($parent_id));
                }
            }
        }

        return false;
    }
}
