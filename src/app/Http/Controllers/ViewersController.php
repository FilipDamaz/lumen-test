<?php

namespace App\Http\Controllers;

use App\Models\Viewers;
use Illuminate\Http\Request;

class ViewersController extends Controller
{
    /**
     * Shows all viewers
     *
     * @return json
     */
    public function showAllViewers()
    {
        if(\Auth::user()->is_admin) {
            $Viewers = Viewers::all();
            $Viewers->makeVisible(['token']);
            return response()->json($Viewers);
        } else {
            return response()->json("you don't have access to this endpoint");
        }
    }

    /**
     * Show one Viewer based on id
     * @param  int  $id
     * @return json
     */
    public function showOneViewer($id)
    {
        if(\Auth::user()->is_admin || \Auth::user()->id == $id) {
            try {
                return response()->json(Viewers::find($id));
            } catch (Exception $e) {
                return response('Error when trying to Get Viewer :'.$e->getMessage(), 420);
            }

        } else {
            return response()->json("you don't have access to this endpoint");
        }
    }

    /**
     * Creates new Viewer
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function create(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:viewers,name',
            'token' => 'required|numeric|unique:viewers,token'
        ]);

        if(\Auth::user()->is_admin) {
            $viewer = Viewers::create($request->all());
            return response()->json($viewer, 201);
        } else {
            return response()->json("you don't have access to this endpoint");
        }
    }

    /**
     * update Viewer
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function update($id, Request $request)
    {
        if(\Auth::user()->is_admin || \Auth::user()->id == $id) {
            try {
                $viewer = Viewers::findOrFail($id);
                $viewer->update($request->all());
                return response()->json($viewer, 200);
            } catch (Exception $e) {
                return response('Error when trying to Update Viewer :'.$e->getMessage(), 420);
            }
        } else {
            return response()->json("you don't have access to this endpoint");
        }
    }
}
