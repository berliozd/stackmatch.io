<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function update(Request $request, string $id)
    {
        /** @var User $user */
        $user = auth()->user();

        if ($id !== (string)$user->id) {
            throw new \Exception('Not allowed');
        }

        $validated = $request->validate([
            'field' => 'required|string',
            'value' => 'required',
        ]);

        $fieldName = $validated['field'];
        $user->$fieldName = $validated['value'];

        $user->save();
        return $user->toArray();
    }
}
