<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    protected array $supportedLocales = ['tr', 'en', 'de'];

    public function switch(string $locale)
    {
        if (in_array($locale, $this->supportedLocales)) {
            Session::put('locale', $locale);
        }

        return back();
    }
}
