<?php

namespace App\Http\Controllers\Web\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('user.show', [
            'user' => $user,
        ]);
    }
}
