<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePricingPlanRequest;
use App\Http\Requests\Admin\UpdatePricingPlanRequest;
use App\Models\PricingPlan;

class PricingPlanController extends Controller
{
    public function index()
    {
        $plans = PricingPlan::ordered()->get();

        return view('admin.pricing.index', compact('plans'));
    }

    public function create()
    {
        $plan = new PricingPlan();

        return view('admin.pricing.create', compact('plan'));
    }

    public function store(StorePricingPlanRequest $request)
    {
        $data = $request->validated();
        $data['is_highlighted'] = $request->boolean('is_highlighted');
        $data['is_active'] = $request->boolean('is_active', true);

        PricingPlan::create($data);

        return redirect()
            ->route('admin.pricing.index')
            ->with('status', 'Paket harga berhasil ditambahkan.');
    }

    public function edit(PricingPlan $pricingPlan)
    {
        return view('admin.pricing.edit', ['plan' => $pricingPlan]);
    }

    public function update(UpdatePricingPlanRequest $request, PricingPlan $pricingPlan)
    {
        $data = $request->validated();
        $data['is_highlighted'] = $request->boolean('is_highlighted');
        $data['is_active'] = $request->boolean('is_active', true);

        $pricingPlan->update($data);

        return redirect()
            ->route('admin.pricing.index')
            ->with('status', 'Paket harga berhasil diperbarui.');
    }

    public function destroy(PricingPlan $pricingPlan)
    {
        $pricingPlan->delete();

        return redirect()
            ->route('admin.pricing.index')
            ->with('status', 'Paket harga berhasil dihapus.');
    }
}