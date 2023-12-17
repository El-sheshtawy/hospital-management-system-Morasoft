<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Events\MyEvent;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
    //    event(new MyEvent('hello world', auth()->user()->name));
        return view('dashboard.user.index');
    }
}
