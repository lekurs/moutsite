<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangeEmailRequest;
use App\Notifications\Auth\ChangeEmailNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChangeEmailController extends Controller
{
    public function store(ChangeEmailRequest $request): RedirectResponse
    {
        $inputs = $request->validated();
        auth()->user()->notify(new ChangeEmailNotification($inputs['new_email']));
        Log::info('Change email attempt', [auth()->user()]);
        return back()->with('status', trans('laravel-auth::laravel-auth.email.change', ['email' => auth()->user()->email]));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function verify(Request $request): RedirectResponse
    {
        auth()->user()->update([
            'email' => $request->query('email'),
        ]);
        $request->user()->markEmailAsVerified();
        Log::info('Change email verification', [auth()->user()]);
        return redirect(RouteServiceProvider::HOME)->with('success', trans('laravel-auth::laravel-auth.email.updated'));
    }
}
