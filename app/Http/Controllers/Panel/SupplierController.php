<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index(Company $company)
    {
        $suppliers = Supplier::where('company_id', $company->id)
            ->withCount(['equipment', 'spareParts'])
            ->latest()
            ->paginate(15);

        return view('panel.suppliers.index', compact('company', 'suppliers'));
    }

    public function create(Company $company)
    {
        return view('panel.suppliers.create', compact('company'));
    }

    public function store(Company $company, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $validated['company_id'] = $company->id;

        Supplier::create($validated);

        return redirect()->route('panel.suppliers.index', ['company' => $company->slug])
            ->with('success', 'Tedarikçi başarıyla eklendi.');
    }

    public function edit(Company $company, Supplier $supplier)
    {
        return view('panel.suppliers.edit', compact('company', 'supplier'));
    }

    public function update(Company $company, Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $supplier->update($validated);

        return redirect()->route('panel.suppliers.index', ['company' => $company->slug])
            ->with('success', 'Tedarikçi bilgileri güncellendi.');
    }

    public function destroy(Company $company, Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('panel.suppliers.index', ['company' => $company->slug])
            ->with('success', 'Tedarikçi silindi.');
    }
}
