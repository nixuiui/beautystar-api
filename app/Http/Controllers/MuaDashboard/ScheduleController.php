<?php

namespace App\Http\Controllers\MuaDashboard;

use App\Http\Controllers\Controller;
use App\Models\MuaSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ScheduleController extends Controller
{
    
    public function index() {
        $schedule = MuaSchedule::whereDate('start_time', '>=', date('Y-m-d'))
                    ->where("mua_id", Auth::user()->mua->id)
                    ->orderBy('start_time', 'asc')
                    ->get();
        return $this->responseOK(null, $schedule);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'description'   => 'required',
            'start_time'    => 'required|date',
            'end_time'      => 'required|date',
            'color'         => 'nullable'
        ]);
        if ($validator->fails()) {
            return $this->responseNotValidInput("Ada field yang tidak valid", $validator->errors());
        }

        $schedule = new MuaSchedule;
        $schedule->title = $request->title;
        $schedule->description = $request->description;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->color = $request->color;
        $schedule->mua_id = Auth::user()->mua->id;
        $schedule->save();

        return $this->responseOK(null, MuaSchedule::mapData($schedule));
    }
    
    public function edit(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'description'   => 'required',
            'start_time'    => 'required|date',
            'end_time'      => 'required|date',
            'color'         => 'nullable'
        ]);
        if ($validator->fails()) {
            return $this->responseNotValidInput("Ada field yang tidak valid", $validator->errors());
        }

        $schedule = MuaSchedule::where("mua_id", Auth::user()->mua->id)
                                ->where("id", $id)
                                ->first();
        $schedule->title = $request->title;
        $schedule->description = $request->description;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->color = $request->color;
        $schedule->save();

        return $this->responseOK(null, MuaSchedule::mapData($schedule));
    }
    
    public function deteleSchedule($id) {
        $schedule = MuaSchedule::where("mua_id", Auth::user()->mua->id)
                                ->where("id", $id)
                                ->first();

        if(!$schedule) return $this->responseError("Data schedule tidak ada", null);

        if($schedule->delete()) return $this->responseOK("Schedule berhasil dihapus", null);

        return $this->responseError("Kesalahan saat menghapus data", null);
    }
    
    public function detail($id) {
        return $schedule = MuaSchedule::where("mua_id", Auth::user()->mua->id)
                                ->where("id", $id)
                                ->first();
        return $this->responseOK(null, MuaSchedule::mapData($schedule));
    }

}
