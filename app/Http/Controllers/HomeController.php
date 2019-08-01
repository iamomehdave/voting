<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('users/contestants');
    }

public function contestants()
    {
        return view('home');
    }

    public function votesDetails(){
        $data['paystack_key'] = env('PAYSTACK_PUBLIC_KEY');
        $data = request()->validate([
        'name' => 'required|min:5',
        'email' => 'required|email',
        'phone' => 'required',
        'contestant' => 'required',
        'votes'    => 'required',
        'amount'    => 'required',
    ]);

dd($data);

    }

    private function validateRequest(){

    return request()->validate([
        'name' => 'required|min:5',
        'email' => 'required|email',
        'phone' => 'required',
        'contestant' => 'required',
        'votes'    => 'required',
        'votes'    => 'amount',
    ]);
}
}
