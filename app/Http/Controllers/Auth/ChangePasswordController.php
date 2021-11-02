<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ChangePasswordController extends Controller
{
    /**
     * @param ChangePasswordRequest $request
     * @return RedirectResponse
     */
    public function store(ChangePasswordRequest $request): RedirectResponse
    {
        $inputs = $request->validated();
        if(strcmp($inputs['current_password'], $inputs['new_password']) === 0){
            return redirect()->back()->with('error',trans('laravel-auth::laravel-auth.password.same'));
        }
        auth()->user()->update(['password' => Hash::make($inputs['new_password'])]);
        Log::info('Change password attempt', [auth()->user()]);
        return redirect(RouteServiceProvider::HOME)->with('success', trans('laravel-auth::laravel-auth.password.success'));
    }
}
