<?php

namespace App\Http\Middleware;

use Auth;
use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Translation;
use Carbon\Carbon;
class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $auth_token = $request->session()->get('auth_token'); 
         
        if (!$auth_token && Auth::user()) {
            $auth_token = Auth::user()->createToken('myAppToken')->plainTextToken;
            session()->put('auth_token', $auth_token);
        }

        if (auth()->check()) {
            $User = auth()->user();
        } else {
            $User = (object) [
                'first_name' => 'Admin',
                'last_name'  => '',
            ];
        }

        
        $default_language = getDefaultLanguage();
        $lang_data = Translation::where('lang', $default_language)->pluck('lang_value', 'lang_key');

        return array_merge(parent::share($request), [
            'default_language' => $default_language,
            'auth_token' => $auth_token,
            'user'             => $User,
            'lang_data' => $lang_data,
        ]);

        
    }
}
