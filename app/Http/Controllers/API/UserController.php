<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($user->status == 'Pending') {
                $success = false;
                $message = "You are not approved yet by admin!";
            } else {
                if (Auth::attempt($credentials)) {
                    $success = true;
                    $message = "User login successfully";
                } else {
                    $success = false;
                    $message = "Unautorised";
                }
            }
        } else {
            $success = false;
            $message = "Unautorised";
        }




        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }


    public function register(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->type = $request->type;
            $user->student_id = $request->student_id;
            $user->course = $request->course;
            $user->department = $request->department;
            $user->save();

            $success = true;
            $message = "User register successfully";
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }


    public function logout()
    {
        try {
            Session::flush();
            $success = true;
            $message = "Logout successfully";
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }
    public function get_all_teacher(Request $request)
    {
        $user = Auth::user();

        if ($user && $user->type == 'Admin') {
            $teachers = User::where('type', 'Teacher')->get();
            return response()->json([
                'data' => $teachers
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
    public function get_all_dashboard_teacher(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $teachers = User::where('type', 'Teacher')->where('status', 'Approved')->get();
            return response()->json([
                'data' => $teachers
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }

    public function get_all_student(Request $request)
    {
        $user = Auth::user();

        if ($user && $user->type == 'Admin') {
            $teachers = User::where('type', 'Student')->get();
            return response()->json([
                'data' => $teachers
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
    public function create_new_student(Request $request)
    {
        $user = Auth::user();

        if ($user && $user->type == 'Admin') {
            $student = new User();
            $student->name = $request->name;
            $student->email = $request->email;
            $student->password = Hash::make($request->password);
            $student->type = 'Student';
            $student->student_id = $request->student_id;
            $student->status = $request->status;
            $student->department = $request->department;
            $student->save();
            return response()->json([
                'data' => $student
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
    public function create_new_teacher(Request $request)
    {
        $user = Auth::user();

        if ($user && $user->type == 'Admin') {
            $teacher = new User();
            $teacher->name = $request->name;
            $teacher->email = $request->email;
            $teacher->password = Hash::make($request->password);
            $teacher->type = 'Teacher';
            $teacher->course = $request->course;
            $teacher->department = $request->department;
            $teacher->status = $request->status;
            $teacher->save();
            return response()->json([
                'data' => $teacher
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
    public function update_user(Request $request)
    {
        $user = Auth::user();

        if ($user && $user->type == 'Admin') {
            $teacher = User::where('id', $request->id)->first();
            $object_user = array();
            if (isset($request->name)) {
                $object_user['name'] = $request->name;
            }
            if (isset($request->email)) {
                $object_user['email'] = $request->email;
            }
            if (isset($request->course)) {
                $object_user['course'] = $request->course;
            }
            if (isset($request->department)) {
                $object_user['department'] = $request->department;
            }
            if (isset($request->student_id)) {
                $object_user['student_id'] = $request->student_id;
            }
            if (isset($request->status)) {
                $object_user['status'] = $request->status;
            }
            if (isset($request->type)) {
                $object_user['type'] = $request->type;
            }
            $teacher->update($object_user);
            return response()->json([
                'data' => $teacher
            ]);
        } else if ($user && $request->id == $user->id) {
            $teacher = User::where('id', $request->id)->first();
            $object_user = array();
            if (isset($request->name)) {
                $object_user['name'] = $request->name;
            }
            if (isset($request->email)) {
                $object_user['email'] = $request->email;
            }
            if (isset($request->course)) {
                $object_user['course'] = $request->course;
            }
            if (isset($request->department)) {
                $object_user['department'] = $request->department;
            }
            if (isset($request->student_id)) {
                $object_user['student_id'] = $request->student_id;
            }
            if (isset($request->status)) {
                $object_user['status'] = $request->status;
            }
            if (isset($request->type)) {
                $object_user['type'] = $request->type;
            }
            $teacher->update($object_user);
            return response()->json([
                'data' => $teacher
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

        if ($user && $user->type == 'Admin') {
            $data = array();
            if ($request->type == 'Student') {
                $data = User::where(function ($query) use ($request) {
                    $query->where('type', '=', $request->type);
                })->where(function ($query) use ($request) {
                    $query->where('name', '=', $request->search)
                        ->orWhere('student_id', '=', $request->search)
                        ->orWhere('email', '=', $request->search);
                })->get();
            } else if ($request->type == 'Teacher') {
                $data = User::where(function ($query) use ($request) {
                    $query->where('type', '=', $request->type);
                })->where(function ($query) use ($request) {
                    $query->where('name', '=', $request->search)
                        ->orWhere('email', '=', $request->search);
                })->get();
            }

            return response()->json([
                'data' => $data
            ]);
        }
    }
}
