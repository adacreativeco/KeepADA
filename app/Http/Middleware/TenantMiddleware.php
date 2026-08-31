<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Company;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $slug = $request->route('company');

        if ($slug instanceof Company) {
            $company = $slug;
        } else {
            $company = Company::where('slug', $slug)->first();
        }

        if (!$company) {
            // If user has companies, redirect to the first one
            $firstCompany = $user->companies()->first();
            if ($firstCompany) {
                return redirect()->route('panel.dashboard', ['company' => $firstCompany->slug]);
            }
            abort(404, 'Şirket / Tesis bulunamadı.');
        }

        if (!$user->canAccessCompany($company)) {
            abort(403, 'Bu şirkete/tesise erişim yetkiniz bulunmuyor.');
        }

        // Share globally with views and URL generator
        app()->instance('currentCompany', $company);
        View::share('currentCompany', $company);
        URL::defaults(['company' => $company->slug]);

        return $next($request);
    }
}
