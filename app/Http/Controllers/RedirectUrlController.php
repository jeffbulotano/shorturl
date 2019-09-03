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
            $redirect_url = RedirectUrl::where('hash', $hash)->firstOrFail();

            return redirect($redirect_url->long_url);
        } catch(\Exception $error) {
            if ($error instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                abort(404);
            } else {
                return $error;
            }
        }
    }

    public function store(Request $request)
    {
        // check if long_url already exists
        if ($redirect_url = RedirectUrl::where('long_url', $request->long_url)->first()) {
            return response()->json($redirect_url->only(['hash', 'long_url']));
        }

        $redirect_url = new RedirectUrl;
        
        try {
            $long_url = $redirect_url->parseUrl($request->long_url);
            $redirect_url->long_url = $long_url;
            $redirect_url->save();

            $hashids = new Hashids(env('HASH_ID_SALT'), env('HASH_ID_PADDING'));
            $redirect_url->hash = $hashids->encode($redirect_url->id);
            $redirect_url->save();
    
            return response()->json($redirect_url->only(['hash', 'long_url']));
        } catch(\Exception $error) {
            return response()->json($error);
        }
    }
}
