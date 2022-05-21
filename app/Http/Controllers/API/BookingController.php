<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BookingController extends Controller
{

    public function create_booking(Request $request)
    {
        $user = Auth::user();
        $form = new Booking();


        if ($user && ($user->type == 'Student')) {
            $booking =  Booking::where([
                ['schedule_id', '=', $request->schedule_id],
                ['student_id', '=', $request->student_id],
                ['user_id', '=', $request->user_id],
            ])->first();

            if ($booking) {
                return response()->json([
                    'data' => false,
                    'msg' => 'You aleady requested!'
                ]);
            } else {
                $form->schedule_id = $request->schedule_id;
                $form->student_id = $request->student_id;
                $form->user_id = $request->user_id;
                $form->status = $request->status;
                $form->agenda = $request->agenda;

                $form->save();
                return response()->json([
                    'data' => $form
                ]);
            }
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }

    public function get_bookings(Request $request)
    {
        $user = Auth::user();

        $data = array();
        if ($user && $user->type == 'Admin') {
            $data = Booking::with('teacher','student','schedule')->get();
        } else if ($user && $user->type == 'Teacher') {
            $data = Booking::with('student','schedule')->where('user_id', $user->id)->get();
        }
        else if ($user && $user->type == 'Student') {
            $data = Booking::with('teacher','schedule')->where('student_id', $user->student_id)->get();
        }
        return response()->json([
            'data' => $data
        ]);
    }

    public function update_booking(Request $request)
    {
        $user = Auth::user();

        if ($user && ($user->type == 'Admin' || $user->type == 'Teacher')) {
            $form = array();
            
            if (isset($request->status)) {
                $form['status'] = $request->status;
            }
            if (isset($request->appointment)) {
                $form['appointment'] = $request->appointment;
            }
            if ($user->type == 'Teacher') {
                Booking::where('user_id',$user->id)->where('id',$request->id)->update($form);
            }
            else if ($user->type == 'Admin') {
                Booking::where('id',$request->id)->update($form);
            }
            $form['data'] = true;
            
            return response()->json($form);
            
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }

    public function delete_booking(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            if ($user->type == 'Teacher') {
                Booking::where('user_id', $user->id)->where('id', $request->id)->delete();
            } else if ($user->type == 'Admin') {
                Booking::where('id', $request->id)->delete();
            }
            else if ($user->type == 'Student') {
                Booking::where('student_id', $user->student_id)->where('id', $request->id)->delete();
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
}
