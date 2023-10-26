<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePantryIngredientRequest;
use App\Http\Requests\UpdatePantryIngredientRequest;
use App\Models\PantryIngredient;

class PantryIngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePantryIngredientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePantryIngredientRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PantryIngredient  $pantryIngredient
     * @return \Illuminate\Http\Response
     */
    public function show(PantryIngredient $pantryIngredient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PantryIngredient  $pantryIngredient
     * @return \Illuminate\Http\Response
     */
    public function edit(PantryIngredient $pantryIngredient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePantryIngredientRequest  $request
     * @param  \App\Models\PantryIngredient  $pantryIngredient
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePantryIngredientRequest $request, PantryIngredient $pantryIngredient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PantryIngredient  $pantryIngredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(PantryIngredient $pantryIngredient)
    {
        //
    }
}
