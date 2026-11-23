<?php

namespace App\Http\Controllers;

use App\Jobs\KirimEmailSelamatDatang;
use App\Models\User;
use App\Notifications\UserBaruNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect()->route('login')
                ->with('error', 'Login dengan Google gagal atau dibatalkan. Silakan coba lagi.');
        }

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        $userBaru = false;

        if (! $user) {
            $user = User::create([
                'name'              => $googleUser->getName(),
                'email'             => $googleUser->getEmail(),
                'google_id'         => $googleUser->getId(),
                'avatar'            => $googleUser->getAvatar(),
                'email_verified_at' => now(),
                'level'             => 'user',
            ]);
            $userBaru = true;
        } else {
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
            ]);
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        if ($userBaru) {
            KirimEmailSelamatDatang::dispatch($user);

            $admin = User::where('level', 'admin')->first();
            $admin?->notify(new UserBaruNotification($user));
        }

        return redirect()->intended(route('dashboard'))
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }
}

