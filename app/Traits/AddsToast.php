<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait AddsToast
{
    protected function addToast(string $status, string $message, bool $show = true)
    {
        $toast = [
            'status' => $status,
            'message' => $message,
            'show' => $show
        ];

        Request::session()->flash('toast', $toast);
    }
}
