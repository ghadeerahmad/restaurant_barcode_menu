<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Plan;
use App\Models\Question;
use App\Models\Setting;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /**
     * display index page
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        get_locale();
        $theme = 'light';
        if (session('theme') == 'dark') $theme = 'dark';
        $plans = Plan::all();
        $settings = Setting::where('key', 'currency_id')->first();
        $currency = Currency::find($settings->value);
        return view('welcome', [
            'theme' => $theme,
            'plans' => $plans,
            'currency' => $currency
        ]);
    }
    /**
     * change main theme
     * @param string $theme
     * @return \Illuminate\Http\Response
     * 
     */
    public function changeTheme($theme)
    {
        session(['theme' => $theme]);
        return back();
    }
    public function dashboard()
    {
        get_locale();
        if (auth()->user()->site_privilege_id != null) return redirect('/admin/dashboard');
        if (get_current_store() == null)
            return redirect('store/create');
        return redirect('/store/dashboard');
    }
    /**
     * change language
     * @param string $lang
     */
    public function switch_lang($locale)
    {
        if ($locale != 'en' && $locale != 'ar') return back();
        $cookie = Cookie::forever('lang', $locale);
        session(['lang' => $locale]);
        return back()->withCookie($cookie);
    }
    /**
     * instructions page
     * @return \Illuminate\Http\Response
     */
    public function instructions()
    {
        get_locale();
        $theme = 'light';
        if(session('theme') != null) $theme = session('theme');
        $questions = Question::where('is_active', 1)->get();
        return view('visitors.questions.index', ['questions' => $questions,'theme'=>$theme]);
    }
    /**
     * get privacy plicy
     * @return \Illuminate\Http\Response
     */
    public function privacy()
    {
        get_locale();
        $privacy = Setting::where('key', 'privacy_en')->first();
        if (App::isLocal('ar'))
            $privacy = Setting::where('key', 'privacy_ar')->first();

        return view('privacy', ['privacy' => $privacy]);
    }
    /**
     * get terms of use
     * @return \Illuminate\Http\Response
     */
    public function terms()
    {
        get_locale();
        $terms = Setting::where('key', 'terms_en')->first();
        if (App::isLocal('at'))
            $terms = Setting::where('key', 'terms_ar')->first();
        return view('terms', ['terms' => $terms]);
    }
}
