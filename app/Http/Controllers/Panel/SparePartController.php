<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\SparePart;
use App\Models\Supplier;
use App\Models\StockTransaction;

class SparePartController extends Controller
{
    public function index(Company $company, Request $request)
    {
        $query = SparePart::where('company_id', $company->id)
            ->with(['supplier']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->boolean('critical_only')) {
            $query->whereColumn('stock_quantity', '<=', 'min_stock');
        }

        $parts = $query->latest()->paginate(15)->withQueryString();
        $suppliers = Supplier::where('company_id', $company->id)->get();

        return view('panel.inventory.index', compact('company', 'parts', 'suppliers'));
    }

    public function create(Company $company)
    {
        $suppliers = Supplier::where('company_id', $company->id)->get();

        return view('panel.inventory.create', compact('company', 'suppliers'));
    }

    public function store(Company $company, Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'nullable|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100',
            'unit' => 'required|string|max:50',
            'stock_quantity' => 'required|numeric|min:0',
            'min_stock' => 'required|numeric|min:0',
            'unit_cost' => 'required|numeric|min:0',
        ]);

        $validated['company_id'] = $company->id;

        $part = SparePart::create($validated);

        // Record initial stock transaction
        if ($validated['stock_quantity'] > 0) {
            $part->stockTransactions()->create([
                'company_id' => $company->id,
                'user_id' => auth()->id(),
                'type' => 'in',
                'quantity' => $validated['stock_quantity'],
                'notes' => 'İlk stok girişi',
            ]);
        }

        return redirect()->route('panel.inventory.index', ['company' => $company->slug])
            ->with('success', 'Yedek parça stoğu başarıyla eklendi.');
    }

    public function edit(Company $company, SparePart $part)
    {
        $suppliers = Supplier::where('company_id', $company->id)->get();

        return view('panel.inventory.edit', compact('company', 'part', 'suppliers'));
    }

    public function update(Company $company, Request $request, SparePart $part)
    {
        $validated = $request->validate([
            'supplier_id' => 'nullable|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100',
            'unit' => 'required|string|max:50',
            'min_stock' => 'required|numeric|min:0',
            'unit_cost' => 'required|numeric|min:0',
        ]);

        $part->update($validated);

        return redirect()->route('panel.inventory.index', ['company' => $company->slug])
            ->with('success', 'Yedek parça bilgileri güncellendi.');
    }

    public function adjustStock(Company $company, Request $request, SparePart $part)
    {
        $validated = $request->validate([
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string|max:255',
        ]);

        $part->adjustStock($validated['quantity'], $validated['type'], null, $validated['notes']);

        return back()->with('success', "Stok hareketi işlendi. Yeni stok: {$part->fresh()->stock_quantity} {$part->unit}");
    }

    public function transactions(Company $company)
    {
        $transactions = StockTransaction::where('company_id', $company->id)
            ->with(['sparePart', 'user', 'task'])
            ->latest()
            ->paginate(20);

        return view('panel.inventory.transactions', compact('company', 'transactions'));
    }

    public function destroy(Company $company, SparePart $part)
    {
        $part->delete();

        return redirect()->route('panel.inventory.index', ['company' => $company->slug])
            ->with('success', 'Yedek parça silindi.');
    }
}
