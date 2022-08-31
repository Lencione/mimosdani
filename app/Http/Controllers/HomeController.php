<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Click;
use App\Models\Counter;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::with('products')->get();

        return view('welcome',[
            'categories' => $categories
        ]);
    }

    public function dashboard()
    {
        $counter = Counter::all();
        $clicks = Click::all();
        return view('home',[
            'counter' => $counter,
            'clicks' => $clicks
        ]);
    }

    public function counter(Request $request)
    {
        $clientIp = $request->getClientIp();
        

        Counter::create([
            'count' => 1,
            'ip' => $clientIp
        ]);
    }

    public function clickCounter(Request $request)
    {
        $clientIp = $request->getClientIp();
        
        Click::create([
            'count' => 1,
            'ip' => $clientIp
        ]);
    }

    public function contact(Request $request)
    {
        Message::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'message' => $request->message
        ]);
        
    }
}
