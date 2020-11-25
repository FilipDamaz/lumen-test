<?php

namespace App\Http\Controllers;

use App\Models\SvodPackage;
use App\Models\Viewers;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;

class SvodPackageController extends Controller
{
    /**
     * shows all SVOD Packages
     *
     * @return json
     */
    public function showAllSvodPackages()
    {
        $SvodPackage = SvodPackage::where('active,true')->all();
        return response()->json($SvodPackage);
    }

    /**
     * shows one SVOD Packages
     * @param  int $id
     * @return json
     */
    public function showOneSvodPackages($id,Request $request)
    {
        try {
            return response()->json(SvodPackage::where('is_active', true)->find($id));
        } catch (Exception $e) {
            return response('Error when trying to Get SvodPackage :'.$e->getMessage(), 420);
        }
    }

    /**
     * creates a new SVOD Package in db
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function createNewPackage(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:svod_packages,name',
            'duration' => 'required|integer',
            'price' => 'required|numeric|gt:0',
            'currency' => 'required',
            'description' => 'required'
        ]);

        if(\Auth::user()->is_admin) {
            $packages = SvodPackage::create($request->all());
            return response()->json($packages, 201);
        } else {
            return response()->json("you don't have access to this endpoint");
        }
    }

    /**
     * gives access to SVOD Package
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function buyPackage(Request $request)
    {
        $package = SvodPackage::where('is_active',true)->find($request->id_package);
        if(!$package)
        {
            return response()->json("we didn't found any active SVOD Package check the ID: ".$request->id_package);
        }

        if(!$package->checkIfUserHasAccess())
        {
            try {
                $time_start = Carbon::now();
                $time_end = Carbon::now()->add(CarbonInterval::make($package->duration.'d'));

                \Auth::user()->svodPackage()->save($package, ['start_date' => $time_start->toDateTimeString(), 'end_date'=>$time_end->toDateTimeString()]);
                return response()->json('Succes', 200);
            } catch (Exception $e) {
                return response('Error when trying to Buy SVOD Package (ID:'.$request->id_package.'):'.$e->getMessage(), 420);
            }
        } else {
            return response()->json("you already have access to this SVOD Package: ".$request->id_package);
        }
    }



    /**
     * change basic properties of SVOD Package
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function changeProperties(Request $request)
    {
        if(\Auth::user()->is_admin) {
                if(isset($request->active))
                {
                    return response()->json("you can't change the state of SVOD package using this endpoint, try to use: change_of_state endpoint");
                }

                $package = SvodPackage::findOrFail($request->id_package);
                if(count($package) == 0)
                {
                    return response()->json("we didn't found any SVOD Package check the ID: ".$request->id_package);
                }
                if(!$package->is_active)
                {
                    try {
                        $package->fill($request->all());
                        $package->save();
                        return response()->json($package, 200);
                    } catch (Exception $e) {
                        return response('Error when trying to Update SVOD Package (ID:'.$request->id_package.'):'.$e->getMessage(), 420);
                    }
                } else {
                    return response()->json("you can't update active SVOD Package (ID:$request->id_package)");
                }
        } else {
            return response()->json("you don't have access to this endpoint", 403);
        }
    }

    /**
     * make SVOD package active/unactive
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function changeOfState(Request $request)
    {
        if(\Auth::user()->is_admin) {
            $this->validate($request, [
                'is_active' => 'required|boolen',
            ]);

            $package = SvodPackage::findOrFail($request->id_package);
            if(count($package) == 0)
            {
                return response()->json("we didn't found any SVOD Package check the ID: ".$request->id_package);
            }

            if($request->active && !$package->active && !empty($package->parent_id))
            {
                if(!$package->videos->first())
                {
                    return response("You try to activate SVOD Package (ID: $request->id_package) the hase no resorces [videos] assigned to it", 420);
                }
            }

            try {
                $package->is_active = $request->is_active;
                $package->save();
                return response()->json($package, 200);
            } catch (Exception $e) {
                return response('Error when trying to Update SVOD Package (ID:'.$request->id_package.'):'.$e->getMessage(), 420);
            }
        } else {
            return response()->json("you don't have access to this endpoint", 403);
        }
    }
}
