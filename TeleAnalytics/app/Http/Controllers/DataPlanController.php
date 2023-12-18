<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\DataPlan;
use Illuminate\Http\Request;

class DataPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $dataPlans = DataPlan::all();
        return view('data_plan.index', ['dataPlans' => $dataPlans]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DataPlan $dataPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataPlan $dataPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataPlan $dataPlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataPlan $dataPlan)
    {
        //
    }
}
