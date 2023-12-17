<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ShowLoginFormController extends Controller
{
    /**
     * Display the login view for users and admins and ..
     */
    public function create(): View
    {
        return view('dashboard.auth.login');
    }
}
