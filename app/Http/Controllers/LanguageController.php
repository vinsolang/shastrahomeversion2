<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(Request $request, $locale)
    {
        $availableLocales = ['en', 'km', 'ch'];

        // Check if the requested locale is valid
        if (in_array($locale, $availableLocales)) {
            $request->session()->put('locale', $locale);
        }

        return redirect()->back();
    }
}
