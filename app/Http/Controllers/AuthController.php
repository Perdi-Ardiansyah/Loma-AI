<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('app');
        }
        return view('auth.login', ['mode' => 'login']);
    }

    /**
     * Show registration form.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('app');
        }
        return view('auth.login', ['mode' => 'register']);
    }

    /**
     * Process user login.
     */
    public function login(Request $request)
    {
        // If request is from registration mode or name is present, dispatch to register
        if ($request->input('auth_mode') === 'register' || ($request->filled('name') && !$request->has('login_only'))) {
            return $this->register($request);
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 4 karakter.',
        ]);

        try {
            if (Auth::attempt(['email' => strtolower(trim($credentials['email'])), 'password' => $credentials['password']], $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended('/app')->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
            }
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kendala pada database: ' . $e->getMessage());
        }

        return back()->withInput()->with('error', 'Email atau kata sandi tidak cocok. Silakan periksa kembali atau daftar akun baru!');
    }

    /**
     * Process user registration.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|min:4',
        ], [
            'name.required' => 'Nama lengkap wajib diisi untuk pendaftaran.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan pilih menu Masuk Akun.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 4 karakter.',
        ]);

        try {
            $user = User::create([
                'name' => trim($data['name']),
                'email' => strtolower(trim($data['email'])),
                'password' => Hash::make($data['password']),
                'exp' => 100, // Starter bonus 100 EXP
                'level' => 1,
                'streak' => 1,
                'role' => 'Siswa Baru',
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            return redirect('/app')->with('success', 'Selamat datang ' . $user->name . '! Akun berhasil dibuat (+100 EXP).');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Gagal mendaftarkan akun: ' . $e->getMessage());
        }
    }

    /**
     * One-click demo login.
     */
    public function demoLogin(Request $request)
    {
        try {
            $user = User::updateOrCreate(
                ['email' => 'guest@loma.ai'],
                [
                    'name' => 'Guest',
                    'password' => Hash::make('password123'),
                    'exp' => 100,
                    'level' => 1,
                    'streak' => 1,
                    'role' => 'Guest',
                ]
            );

            // Update any old demo user to Guest
            User::where('email', 'demo@loma.ai')->update([
                'name' => 'Guest',
                'role' => 'Guest',
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            return redirect('/app')->with('success', 'Berhasil masuk sebagai Akun Guest!');
        } catch (Exception $e) {
            return redirect('/app')->with('success', 'Masuk ke mode Loma.AI Studio!');
        }
    }

    /**
     * Redirect to Google OAuth consent screen.
     */
    public function redirectToGoogle()
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->route('login')->with('error', 'Kredensial Google Sign-In belum dikonfigurasi di file .env. Silakan tambahkan GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET dari Google Cloud Console.');
        }

        try {
            $redirectUrl = $this->resolveGoogleRedirectUrl();
            return Socialite::driver('google')
                ->redirectUrl($redirectUrl)
                ->stateless()
                ->redirect();
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal menghubungkan ke Google: ' . $e->getMessage());
        }
    }

    /**
     * Handle callback from Google OAuth.
     */
    public function handleGoogleCallback(Request $request)
    {
        if ($request->has('error')) {
            return redirect()->route('login')->with('error', 'Login Google dibatalkan atau terjadi kendala: ' . $request->get('error'));
        }

        try {
            $redirectUrl = $this->resolveGoogleRedirectUrl();
            $googleUser = Socialite::driver('google')
                ->redirectUrl($redirectUrl)
                ->stateless()
                ->user();
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal memproses autentikasi Google: ' . $e->getMessage());
        }

        try {
            $googleId = $googleUser->getId();
            $email = strtolower(trim($googleUser->getEmail()));
            $name = trim($googleUser->getName()) ?: 'Pelajar Loma';
            $avatar = $googleUser->getAvatar();

            if (empty($email)) {
                return redirect()->route('login')->with('error', 'Akun Google Anda tidak memiliki alamat email yang valid.');
            }

            // Find existing user by google_id or by email
            $user = User::where('google_id', $googleId)->first();

            if (!$user) {
                $user = User::where('email', $email)->first();
            }

            if ($user) {
                // Link Google account and update avatar if not set
                $user->google_id = $googleId;
                if (!empty($avatar)) {
                    $user->avatar = $avatar;
                }
                $user->save();
            } else {
                // Register new user from Google
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'google_id' => $googleId,
                    'avatar' => $avatar,
                    'password' => Hash::make(Str::random(32)),
                    'exp' => 100, // Starter bonus
                    'level' => 1,
                    'streak' => 1,
                    'role' => 'Siswa Loma',
                ]);
            }

            Auth::login($user, true);
            $request->session()->regenerate();

            return redirect()->intended('/app')->with('success', 'Selamat datang, ' . $user->name . '! Berhasil masuk menggunakan Akun Google.');
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat menyimpan data akun: ' . $e->getMessage());
        }
    }

    /**
     * Backward-compatibility alias for googleLogin.
     */
    public function googleLogin(Request $request)
    {
        return $this->redirectToGoogle();
    }

    /**
     * Update user EXP & Level directly in Database via AJAX.
     */
    public function updateExp(Request $request)
    {
        $amount = (int) $request->input('amount', 0);
        $user = Auth::user();

        if ($user && $amount > 0) {
            $user->exp += $amount;

            // Recalculate level
            if ($user->exp >= 2000) $user->level = 6;
            elseif ($user->exp >= 1400) $user->level = 5;
            elseif ($user->exp >= 900) $user->level = 4;
            elseif ($user->exp >= 500) $user->level = 3;
            elseif ($user->exp >= 200) $user->level = 2;
            else $user->level = 1;

            $user->save();

            return response()->json([
                'status' => 'success',
                'exp' => $user->exp,
                'level' => $user->level,
                'message' => 'EXP berhasil diperbarui di database!'
            ]);
        }

        return response()->json([
            'status' => 'ignored',
            'message' => 'User belum login atau jumlah EXP tidak valid'
        ]);
    }

    /**
     * Resolusi URL redirect callback Google secara cerdas (mendukung online & localhost).
     */
    private function resolveGoogleRedirectUrl()
    {
        $redirectUrl = config('services.google.redirect');
        $host = request()->header('host', '');

        // Jika sedang berjalan di domain online (misal Render) tapi config masih tertulis localhost,
        // otomatis alihkan ke HTTPS domain online tersebut!
        if (!empty($host) && !str_contains($host, 'localhost') && !str_contains($host, '127.0.0.1')) {
            if (empty($redirectUrl) || str_contains($redirectUrl, 'localhost') || str_contains($redirectUrl, '127.0.0.1')) {
                return 'https://' . $host . '/auth/google/callback';
            }
        }

        return !empty($redirectUrl) ? $redirectUrl : url('/auth/google/callback');
    }

    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('info', 'Anda telah berhasil keluar dari akun.');
    }
}
