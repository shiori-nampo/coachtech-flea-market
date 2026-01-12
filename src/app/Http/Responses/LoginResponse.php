<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\Request;

class LoginResponse implements LoginResponseContract
{
  public function toResponse($request)
  {
    $user = $request->user();

      if (! $user->hasVerifiedEmail()) {
        return redirect()->route('verify');
      }
      return redirect()->route('items.index');
  }
}

