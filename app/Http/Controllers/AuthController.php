<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PendaftarDetails;
use App\Models\Berkas;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:128'],
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Set session timeout (30 minutes)
            $request->session()->put('last_activity', time());

            $role = Auth::user()->role;
            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role === 'dosen') {
                return redirect()->intended('/dosen/dashboard');
            } else {
                return redirect()->intended('/pendaftar/dashboard');
            }
        }

        // Log failed login attempt
        Log::warning('Failed login attempt', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|regex:/^[a-zA-Z\s\.\-,\']+$/',
            'npm' => 'required|string|regex:/^[0-9]+$/|min:8|max:15|unique:pendaftar_details,npm',
            'email' => 'required|string|email|max:255|unique:users,email|ends_with:@gunadarma.ac.id',
            'password' => 'required|string|min:12|max:128|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
            'nomor_hp' => 'required|string|regex:/^[0-9]+$/|min:10|max:15',
            'program_studi' => 'required|string|in:Sistem Informasi,Sistem Komputer,Informatika,Manajemen,Akuntansi',
            'ipk' => 'required|numeric|min:0|max:4',
            'posisi' => 'required|in:asisten,programmer',
            'cv' => 'required|mimes:pdf|max:2048',
            'krs' => 'required|mimes:pdf|max:2048',
            'transkrip' => 'required|mimes:pdf|max:2048',
            'sertifikat' => 'nullable|mimes:pdf|max:2048',
        ], [
            'nama.regex' => 'Nama hanya boleh mengandung huruf, spasi, titik, koma, tanda hubung, dan apostrof',
            'npm.regex' => 'NPM hanya boleh mengandung angka',
            'email.ends_with' => 'Email harus menggunakan domain @gunadarma.ac.id',
            'password.regex' => 'Password harus mengandung minimal 12 karakter dengan huruf besar, huruf kecil, angka, dan karakter khusus (@$!%*?&)',
            'nomor_hp.regex' => 'Nomor HP hanya boleh mengandung angka',
        ]);

        DB::beginTransaction();

        try {
            // Create User with more secure password hashing
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password, ['rounds' => 12]),
                'email_verified_at' => null, // Will be verified later
                'role' => 'pendaftar', // Fix: Role must be pendaftar for middleware/routing
            ]);

            // Create Details
            $pendaftar = PendaftarDetails::create([
                'user_id' => $user->id,
                'npm' => $request->npm,
                'nama' => $request->nama,
                'email' => $request->email,
                'nomor_hp' => $request->nomor_hp,
                'program_studi' => $request->program_studi,
                'ipk' => $request->ipk,
                'posisi' => $request->posisi, // This is stored in details
            ]);

            // Handle Files dengan keamanan yang lebih ketat
            $files = ['cv', 'krs', 'transkrip', 'sertifikat'];
            $allowedMimeTypes = ['application/pdf'];
            
            foreach ($files as $type) {
                if ($request->hasFile($type)) {
                    $file = $request->file($type);
                    
                    // Validasi MIME type secara eksplisit
                    if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
                        throw ValidationException::withMessages([
                            $type => 'File harus dalam format PDF'
                        ]);
                    }
                    
                    // Validasi ukuran file
                    if ($file->getSize() > 2 * 1024 * 1024) {
                        throw ValidationException::withMessages([
                            $type => 'Ukuran file maksimal 2MB'
                        ]);
                    }
                    
                    // Generate nama file yang aman
                    $safeFileName = preg_replace('/[^a-zA-Z0-9]/', '', $type) . '_' . time() . '.pdf';
                    $path = $file->storeAs("uploads/{$request->npm}", $safeFileName);
                    
                    Berkas::create([
                        'pendaftar_id' => $pendaftar->id,
                        'jenis_berkas' => $type,
                        'path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                    ]);
                }
            }

            DB::commit();

            Auth::login($user);

            return redirect('/pendaftar/dashboard');

        } catch (\Exception $e) {
            DB::rollBack();
            // In production, log error. For now throw or back.
            return back()->withInput()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }

    public function forgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Generate secure token
            $token = Str::random(64);
            
            // Store token
            PasswordReset::updateOrCreate(
                ['email' => $request->email],
                [
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => now(),
                ]
            );

            // In production, send email with reset link
            // For now, we'll show the token (for development only)
            // Mail::to($user->email)->send(new PasswordResetEmail($token));
            
            Log::info('Password reset token generated', [
                'email' => $request->email,
                'token' => $token,
                'ip' => $request->ip(),
            ]);
        }

        // Always show generic message to prevent email enumeration
        return back()->with('success', 'Jika email terdaftar di sistem kami, Anda akan menerima link reset password dalam beberapa menit.');
    }

    public function resetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:12|max:128|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
        ], [
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 12 karakter',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus (@$!%*?&)',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $passwordReset = PasswordReset::where('token', $request->token)
            ->where('email', $request->email)
            ->where('created_at', '>', now()->subMinutes(60))
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Token reset tidak valid atau telah kadaluarsa.']);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Reset password
        $user->password = Hash::make($request->password, ['rounds' => 12]);
        $user->save();

        // Delete used token
        PasswordReset::where('email', $request->email)->delete();

        // Log password reset
        Log::info('Password reset successful', [
            'email' => $request->email,
            'ip' => $request->ip(),
        ]);

        return redirect('/login')->with('success', 'Password berhasil direset. Silakan login dengan password baru.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
