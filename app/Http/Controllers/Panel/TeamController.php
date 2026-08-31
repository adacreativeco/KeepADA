<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TeamController extends Controller
{
    public function index(Company $company)
    {
        $members = $company->users()
            ->with(['roles', 'maintenanceTasks' => function ($q) use ($company) {
                $q->where('company_id', $company->id)->whereIn('status', ['pending', 'in_progress']);
            }])
            ->get();

        $roles = Role::whereIn('name', ['manager', 'technician'])->get();

        return view('panel.team.index', compact('company', 'members', 'roles'));
    }

    public function store(Company $company, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
            'role' => 'required|in:manager,technician',
        ]);

        // Kullanıcı var mı kontrol et, yoksa oluştur
        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
            $user->assignRole($validated['role']);
        }

        // Şirkete bağla (eğer bağlı değilse)
        if (!$company->users()->where('user_id', $user->id)->exists()) {
            $company->users()->attach($user->id);
        }

        return redirect()->route('panel.team.index', ['company' => $company->slug])
            ->with('success', "{$user->name} başarıyla ekibe eklendi.");
    }

    public function destroy(Company $company, User $user)
    {
        // Kendini veya son üyeyi silme kontrolü
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kendi oturumunuzu ekipten çıkaramazsınız.');
        }

        $company->users()->detach($user->id);

        return redirect()->route('panel.team.index', ['company' => $company->slug])
            ->with('success', 'Kullanıcı ekipten çıkarıldı.');
    }
}
