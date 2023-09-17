<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Indicator;

class IndicatorController extends Controller
{
    /**
     * インジケーター管理の表示
     */
    public function index()
    {
        $indicator_lists = Indicator::all();
        return view('indicator.index', ['indicator_lists' => $indicator_lists]);
    }
}
