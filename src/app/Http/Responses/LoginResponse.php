<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponse
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

