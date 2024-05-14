<?php





    namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function getAdmin()
    {
        $users = User::all();
        return view('admin_page', compact('users'));
    }
}

