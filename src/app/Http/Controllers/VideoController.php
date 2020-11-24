<?php

namespace App\Http\Controllers;

use App\Models\SvodPackage;
use App\Models\Videos;
use App\Models\Viewers;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
const VIDEO_ON_DEMAND_DURATION = '1d';

class VideoController extends Controller
{


    /**
     * shows one video based on id - if user has access to it
     * @param  int $id
     * @return json
     */
    public function showOneVideo($id)
    {

        $Video = Videos::find($id);
        if($Video)
        {
            if($Video->checkIfUserHasAccess())
            {
                unset($Video->svodPackage);
                return response()->json($Video);
            } else {
                return response("you don't have access to video id:$id", 420);
            }
        } else {
            return response("there is no video id:$id", 420);
        }
    }

    /**
     * creates ne video in db
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function createNewVideo(Request $request)
    {
        if(\Auth::user()->is_admin) {

            $this->validate($request, [
                'name' => 'required|unique:videos,name',
                'price' => 'required|numeric|gt:0',
                'currency' => 'required'
            ]);

            $video = Videos::create($request->all());
            return response()->json($video, 201);
        } else {
            return response()->json("you don't have access to this endpoint");
        }
    }

    /**
     * gives direct access to video for user
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function buyVideo(Request $request)
    {

        $Video = Videos::find($request->id_video);
        if($Video)
        {
            if(!$Video->checkIfUserHasAccess())
            {
                try {
                    $time_start = Carbon::now();
                    $time_end = Carbon::now()->add(CarbonInterval::make(VIDEO_ON_DEMAND_DURATION));

                    \Auth::user()->directVideos()->save($Video, ['start_date' => $time_start->toDateTimeString(), 'end_date'=>$time_end->toDateTimeString()]);
                    return response()->json('Succes', 200);
                } catch (Exception $e) {
                    return response('Error when trying to Buy direct access to video (ID:'.$request->id_video.'):'.$e->getMessage(), 420);
                }
            } else {
                return response("you already have access to this video id:$request->id_video", 420);
            }
        } else {
            return response("there is no video id:$request->id_video", 420);
        }
    }
}
