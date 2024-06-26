<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['rooms'] = Room::with('room_type')->get();
        $admin_user = \Admin::user();
        $data['admin_user'] = $admin_user;

        return view('index', compact('data'));
    }

    public function rooms()
    {
        $data['rooms'] = Room::with('room_type')->get();
        $data['lecturers'] = Administrator::whereHas('roles', function ($query) {
            $query->where('slug', 'dosen');
        })->get();

        return view('pages.rooms', compact('data'));
    }
}
