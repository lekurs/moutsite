<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Notifications\Auth\VerifyEmailNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * @return Application|Factory|ViewContract|View
     */
//    public function create()
//    {
//        return view('auth-register');
//    }

    /**
     * @todo disable sending email on registered event
     * @param RegisterRequest $request
     * @return RedirectResponse
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $validated = collect($request->validated());
        $user = User::create([
            'name' => $validated->get('name'),
            'email' => $validated->get('email'),
            'password' => Hash::make($validated->get('password'),),
            'terms' => $validated->has('terms') ? now() : null,
            'privacy' => $validated->has('terms') ? now() : null,
        ]);
        auth()->login($user);
        event(new Registered($user));
//        $user->notify(new VerifyEmailNotification);
        return redirect(RouteServiceProvider::HOME)->with('success', trans('laravel-auth::laravel-auth.register.validating'));
    }
}
