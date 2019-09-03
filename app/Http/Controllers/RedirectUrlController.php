<?php

namespace App\Http\Controllers;

use App\RedirectUrl;
use Illuminate\Http\Request;
use Hashids\Hashids;

class RedirectUrlController extends Controller
{
    public function home()
    {
        return view('index');
    }

    public function redirect($hash)
    {
        try {
            $long_url = RedirectUrl::where('hash', $hash)->pluck('long_url')->firstOrFail();

            return redirect($long_url);
        } catch(\Exception $error) {
            return $error;
        }
    }

    public function store(Request $request)
    {
        $redirect_url = new RedirectUrl;
        $redirect_url = $redirect_url->create($request->all());

        $hashids = new Hashids(env('HASH_ID_SALT'), env('HASH_ID_PADDING'));
        $redirect_url->hash = $hashids->encode($redirect_url->id);
        $redirect_url->save();

        return response()->json($redirect_url->only(['hash', 'long_url']));
    }
}
