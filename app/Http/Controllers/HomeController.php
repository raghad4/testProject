<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $clients = Client::orderByDesc('id')->get();
        $clients_array = $clients->pluck('age')->toArray();
        $average = array_sum($clients_array) / count($clients_array);
        return view('home',compact('clients','average'));
    }
}
