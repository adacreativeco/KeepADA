<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Company;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            $company = Auth::user()->companies()->first() ?? Company::first();
            if ($company) {
                return redirect()->route('panel.dashboard', ['company' => $company->slug]);
            }
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'E-posta adresi zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'password.required' => 'Şifre alanı zorunludur.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            $company = $user->companies()->first() ?? Company::first();

            if (!$company) {
                // Auto-create a default company if none exists
                $company = Company::create([
                    'name' => 'Şirketim',
                    'slug' => 'sirketim-' . Str::random(4),
                    'plan' => 'starter',
                ]);
                $user->companies()->attach($company);
            }

            return redirect()->intended(route('panel.dashboard', ['company' => $company->slug]))
                ->with('success', 'Hoş geldiniz, ' . $user->name);
        }

        return back()->withErrors([
            'email' => 'Girdiğiniz bilgiler kayıtlarımızla eşleşmiyor.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Ad Soyad zorunludur.',
            'company_name.required' => 'Şirket/Tesis adı zorunludur.',
            'email.required' => 'E-posta zorunludur.',
            'email.unique' => 'Bu e-posta adresi zaten kayıtlı.',
            'password.required' => 'Şifre zorunludur.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
            'password.confirmed' => 'Şifre tekrarı eşleşmiyor.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $companySlug = Str::slug($validated['company_name']);
        if (Company::where('slug', $companySlug)->exists()) {
            $companySlug .= '-' . Str::random(4);
        }

        $company = Company::create([
            'name' => $validated['company_name'],
            'slug' => $companySlug,
            'plan' => 'professional',
            'max_locations' => 5,
            'max_equipment' => 9999,
            'max_users' => 10,
        ]);

        $user->companies()->attach($company);

        // Assign manager role
        $role = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $user->assignRole($role);

        Auth::login($user);

        return redirect()->route('panel.dashboard', ['company' => $company->slug])
            ->with('success', 'Hesabınız ve tesisiniz başarıyla oluşturuldu!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Başarıyla çıkış yaptınız.');
    }
}
