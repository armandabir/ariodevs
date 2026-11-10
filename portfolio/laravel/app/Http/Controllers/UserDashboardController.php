<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    public function index(): View
    {
        return view('users.dashboard', [
            'visitorsCount' => Visitor::count(),
        ]);
    }
}
