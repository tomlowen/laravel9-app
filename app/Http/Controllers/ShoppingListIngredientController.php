<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShoppingListIngredientRequest;
use App\Http\Requests\UpdateShoppingListIngredientRequest;
use App\Http\Resources\ShoppingListIngredientResource;
use App\Models\ShoppingListIngredient;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ShoppingListIngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return Redirect::route('login');
        }

        $ingredients = ShoppingListIngredient::where('user_id', $user->id)->get();

        return Inertia::render('ShoppingList/ShoppingList', [
            'ingredients' => ShoppingListIngredientResource::collection($ingredients),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreShoppingListIngredientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShoppingListIngredientRequest $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateShoppingListIngredientRequest  $request
     * @param  \App\Models\ShoppingListIngredient  $shoppingListIngredient
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShoppingListIngredientRequest $request, ShoppingListIngredient $shoppingListIngredient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShoppingListIngredient  $shoppingListIngredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingListIngredient $shoppingListIngredient)
    {
        //
    }
}
