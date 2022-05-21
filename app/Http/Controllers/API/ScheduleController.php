<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ScheduleController extends Controller
{
    public function get_schedules(Request $request)
    {
        $user = Auth::user();

        $data = array();
        if ($user && $user->type == 'Admin') {
            $data = Schedule::with('user_details')->get();
        } else if ($user && $user->type == 'Teacher') {
            $data = Schedule::with('user_details')->where('user_id', $user->id)->get();
        }
        return response()->json([
            'data' => $data
        ]);
    }

    public function create_schedule(Request $request)
    {
        $user = Auth::user();
        $user_details = array();

        if ($user && ($user->type == 'Admin' || $user->type == 'Teacher')) {
            $form = new Schedule();
            $form->day = $request->day;
            $form->start_time = $request->start_time;
            $form->end_time = $request->end_time;
            $form->status = $request->status;
            if ($user->type == 'Teacher') {
                $form->user_id = $user->id;
                $form->department = $user->department;
                $user_details = $user;
            }
            if ($user->type == 'Admin') {
                $form->user_id = $request->user_id;
                $teacher = User::where('id', $request->user_id)->first();
                $form->department = $teacher->department;
                $user_details = $teacher;
            }

            // check same schedule exists or not
            $st = $form->start_time;
            $et = $form->end_time;
            $added = false;
            $schedule = Schedule::where('user_id', $form->user_id)->where('day', $form->day)->get();

            if (sizeof($schedule) > 0) {
                for ($i = 0; $i < sizeof($schedule); $i++) {
                    if (
                        $st == $schedule[$i]->start_time ||
                        ($st > $schedule[$i]->start_time && $st < $schedule[$i]->end_time) ||
                        ($et > $schedule[$i]->start_time && $et < $schedule[$i]->end_time) ||
                        ($st < $schedule[$i]->start_time && $et > $schedule[$i]->end_time) ||
                        ($st < $schedule[$i]->start_time && $et == $schedule[$i]->end_time)
                    ) {
                        $added = true;
                        break;
                    } else {
                        $added = false;
                    }
                }
            } else {
                $added = false;
            }
            // end check same schedule exists or not

            if ($added == false) {
                $form->save();
                $form['user_details'] = $user_details;
                return response()->json([
                    'data' => $form
                ]);
            } else {
                return response()->json([
                    'data' => false,
                    'msg' => 'Already added'
                ]);
            }
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }

    public function update_schedule(Request $request)
    {
        $user = Auth::user();
        $user_details = array();

        if ($user && ($user->type == 'Admin' || $user->type == 'Teacher')) {
            $exist = Schedule::where('id', $request->id)->first();
            $form = array();
            $added = false;
            if (isset($request->day)) {
                $form['day'] = $request->day;
            }
            if (isset($request->start_time)) {
                $form['start_time'] = $request->start_time;
            }
            if (isset($request->end_time)) {
                $form['end_time'] = $request->end_time;
            }
            if (isset($request->status)) {
                $form['status'] = $request->status;
            }
            if ($user->type == 'Teacher') {
                $form['user_id'] = $user->id;
                if (isset($request->status)) {
                    $form['status'] = $request->status;
                }
                $form['department'] = $user->department;
                $user_details = $user;
            }
            if ($user->type == 'Admin') {
                $form['user_id'] = $request->user_id;
                $teacher = User::where('id', $request->user_id)->first();
                $form['department'] = $teacher->department;
                $user_details = $teacher;
            }

            // check same schedule exists or not
            if (isset($request->start_time) && isset($request->end_time)) {
                $st = $form['start_time'];
                $et = $form['end_time'];
                $schedule = Schedule::where('id', '!=', $request->id)->where('user_id', $form['user_id'])->where('day', $form['day'])->get();

                if (sizeof($schedule) > 0) {
                    for ($i = 0; $i < sizeof($schedule); $i++) {
                        if (
                            $st == $schedule[$i]->start_time ||
                            ($st > $schedule[$i]->start_time && $st < $schedule[$i]->end_time) ||
                            ($et > $schedule[$i]->start_time && $et < $schedule[$i]->end_time) ||
                            ($st < $schedule[$i]->start_time && $et > $schedule[$i]->end_time) ||
                            ($st < $schedule[$i]->start_time && $et == $schedule[$i]->end_time)
                        ) {
                            $added = true;
                            break;
                        } else {
                            $added = false;
                        }
                    }
                } else {
                    $added = false;
                }
            }
            // end check same schedule exists or not

            if ($added == false) {
                $exist->update($form);
                $form['user_details'] = $user_details;
                return response()->json([
                    'data' => $form
                ]);
            } else {
                return response()->json([
                    'data' => false,
                    'msg' => 'Already added'
                ]);
            }
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }

    public function delete_schedule(Request $request)
    {
        $user = Auth::user();
        if ($user && ($user->type == 'Admin' || $user->type == 'Teacher')) {
            if ($user->type == 'Teacher') {
                Schedule::where('user_id', $user->id)->where('id', $request->id)->delete();
            } else if ($user->type == 'Admin') {
                Schedule::where('id', $request->id)->delete();
            }
            return response()->json([
                'data' => true
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }

    public function get_all_schedule_for_dashboard(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $teachers = Schedule::with('user_details')->get();
            return response()->json([
                'data' => $teachers
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }

    public function find_a_user(Request $request)
    {
        $user = Auth::user();
        $data = array();
        if ($user) {
            if ($request->search == 'All') {
                $data = Schedule::with('user_details')->get();
            } else {
                $data = Schedule::with('user_details')->where('user_id', '=', $request->search)->orWhere('department', '=', $request->search)->get();
            }
            return response()->json([
                'data' => $data
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
}
