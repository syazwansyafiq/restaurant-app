<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember') ? true : false;

        $request->merge(['email' => $request->input('email')]);

        $request->flash();

        $request->request->add(['remember' => $remember]);

        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if (auth()->user()->role === 'restaurant_manager') {
                return redirect()->route('manager.dashboard');
            }

            if (auth()->user()->role === 'customer') {
                return redirect()->route('customer.dashboard');
            }
        }

        return back();
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function profile()
    {
        return view('profile.edit');
    }

    public function profilePost(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->update([
            'name' => $request->name,
        ]);
        return redirect()->back();
    }

    public function dashboard(Request $request)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if (auth()->user()->role === 'restaurant_manager') {
            return redirect()->route('manager.dashboard');
        }

        if (auth()->user()->role === 'customer') {
            return redirect()->route('customer.dashboard');
        }

        return back();
    }


    public function register(Request $request)
    {
        return view('auth.register');
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function resetPassword(Request $request)
    {
        return view('auth.reset-password');
    }

    public function resetPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (is_null($user)) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function confirmPassword(Request $request)
    {
        return view('auth.confirm-password');
    }

    public function confirmPasswordPost(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $request->user()->update(['password' => Hash::make($request->password)]);

        return redirect()->route('login');
    }

    public function forgotPassword(Request $request)
    {
        return view('auth.forgot-password');
    }

    public function forgotPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (is_null($user)) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);

    }
}
