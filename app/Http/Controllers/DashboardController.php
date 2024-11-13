<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function approval()
{
    return view('approval');
}

public function doctorHome()
{
    return view('doctorHome');
}

public function caregiverHome()
{
    return view('caregiverHome');
}

public function patientHome()
{
    return view('patientHome');
}

public function familyMemberHome()
{
    return view('family_memberHome');
}

}
