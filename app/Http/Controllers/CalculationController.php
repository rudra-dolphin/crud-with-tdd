<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculationRequest;
use App\Models\Calculation;
use Brick\Math\Internal\Calculator;
use Illuminate\Http\Request;

class CalculationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $calculationData = Calculation::all();
        return view('calculation.index', compact('calculationData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('calculation.main-form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CalculationRequest $request)
    {

        $requestData = $request->all();
        $requestData['result'] = ($request->amount * $request->percentage / 100);
         Calculation::create($requestData);
        return redirect()->route('calculation.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Calculation::findOrFail($id);
        return view('calculation.main-form', compact('data', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CalculationRequest $request, string $id)
    {
        $requestData = $request->all();
        // dd($requestData);
        $calculatedData = Calculation::findOrFail($id);
        $requestData['result'] = ($request->amount * $request->percentage / 100);
        $calculationData = $calculatedData->update($requestData);
        if ($calculationData) {
            return redirect()->route('calculation.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $calculatedDataDestroy = Calculation::destroy($id);
        if ($calculatedDataDestroy) {
            return redirect()->route('calculation.index')->with('success', 'Calculation deleted successfully');
        }
    }
}
