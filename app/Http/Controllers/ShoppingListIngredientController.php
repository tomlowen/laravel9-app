<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShoppingListIngredientRequest;
use App\Http\Resources\ShoppingListIngredientResource;
use App\Models\ShoppingListIngredient;
use App\Services\IngredientService;
use App\Traits\AddsToast;
use COM;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ShoppingListIngredientController extends Controller
{
    use AddsToast;

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
     * @param  \App\Http\Requests\StoreShoppingListIngredientRequest  $request
     * @param  \App\Models\ShoppingListIngredient  $shoppingListIngredient
     * @return \Illuminate\Http\Response
     */
    public function update(StoreShoppingListIngredientRequest $request, ShoppingListIngredient $shoppingListIngredient)
    {
        $user = $request->user();

        if (!$user) {
            return Redirect::route('login');
        }

        if($user->id != $shoppingListIngredient->user_id) {
            abort(404);
        }

        $shoppingListIngredient->update([
            'bought' => $request['shoppingListIngredient']['bought']
        ]);

        return Redirect::route(
            'shopping-list.index',
            [],
            303
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\ShoppingListIngredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ShoppingListIngredient $shoppingListIngredient)
    {
        if($request->user()->id != $shoppingListIngredient->user_id) {
            abort(404);
        }

        $shoppingListIngredient->delete();

        return Redirect::route(
            'shopping-list.index',
            [],
            303
        );
    }

    /**
     * Delete all ShoppingListIngredients.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        if (!$request->user()) {
            abort(404);
        }

        $request->user()->shoppingListIngredients()->delete();

        return Redirect::route(
            'shopping-list.index',
            [],
            303
        );
    }

    /**
     * Convert the recipe ingredients to ShoppingListIngredients.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function convertRecipeIngredients(Request $request)
    {
        if (!$request->user()) {
            abort(404);
        }

        try {
            app(IngredientService::class)->convertIngredients($request['recipe']['ingredients']);

            $message = [
                'id' => $request['recipe']['id'],
                'status' => 'success',
                'description' => 'Ingredients added successfully'
            ];
        } catch (Exception $e) {
            info($e);

            $message = [
                'id' => $request['recipe']['id'],
                'status' => 'error',
                'description' => 'There was a problem adding these ingredients'
            ];
        }

        return Redirect::back()->with(
            'messages', [$message]
        );
    }
}
