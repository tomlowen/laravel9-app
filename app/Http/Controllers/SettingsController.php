<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\RecipeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SettingsController extends Controller
{
    /**
     * Display the user's settings dashboard.
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

        return Inertia::render('Settings/SettingsDashboard', [
            'recipes' => RecipeResource::collection($user->recipes),
            'categories' => CategoryResource::collection($user->categories),
        ]);
    }
}
