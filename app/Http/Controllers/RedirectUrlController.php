<?php

namespace App\Http\Controllers;

use App\RedirectUrl;
use Illuminate\Http\Request;
use Hashids\Hashids;
use Exception;

class RedirectUrlController extends Controller
{
    public function home()
    {
        return view('index');
    }

    public function redirect($hash)
    {
        try {
            $redirect_url = RedirectUrl::where('hash', $hash)->firstOrFail();

            return redirect($redirect_url->long_url);
        } catch(Exception $e) {
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                abort(404);
            } else {
                return $e->errors();
            }
        }
    }

    public function store(Request $request)
    {
        $redirect_url = new RedirectUrl;
        $long_url = $redirect_url->parseAndValidateUrl($request->long_url);

        // check if long_url already exists
        if ($existing_redirect_url = RedirectUrl::where('long_url', $long_url)->first()) {
            return response()->json($existing_redirect_url->only(['hash', 'long_url']));
        }

        $redirect_url->long_url = $long_url;
        $redirect_url->save();

        $hashids = new Hashids(env('HASH_ID_SALT'), env('HASH_ID_PADDING'));
        $redirect_url->hash = $hashids->encode($redirect_url->id);
        $redirect_url->save();

        return response()->json($redirect_url->only(['hash', 'long_url']));
    }
}
