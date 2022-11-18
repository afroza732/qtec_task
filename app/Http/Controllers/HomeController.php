<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pattern = "data";
        $text = "tadadattaetadadadafa";
        $pattern_length = strlen($pattern);
        $text_length = strlen($text);
        $count = 0;
        for($i=0;$i<=$text_length-$pattern_length;$i++)
        {
            $match = true;
            for($j=0;$j<$pattern_length;$j++)
            {
                if($text[$i+$j] != $pattern[$j])
                {
                    $match = false;
                    break;
                }
            }
            if($match)
            {
                $count++;
            }
        }
        return view('task2',compact("pattern","count","text"));
    }
    public function home()
    {

        return view('welcome');
    }
    public function product()
    {

        $categories = Category::all();
        $users      = User::all();
        $products   = Product::orderByDesc('created_at')->get();
        $time_ranges = ["Yestarday","Last Week","Last Month"];
        return view('task1',compact("categories","users","products","time_ranges"));
    }
    public function autocomplete(Request $request)
    {

       //return $request->all();

        $products =  Product::query()->orderByDesc("created_at");
        if(!empty($request->keyword)){
            $products = $products
                        ->where('keyword', 'LIKE', "%{$request->keyword}%")
                        ->Orwhere('name', 'LIKE', "%{$request->keyword}%");
        }
        if(!empty($request->category)){
            $products = $products->whereIn("category_id",$request->category);
        }
        if(!empty($request->user)){
            $products = $products->whereIn("user_id",$request->user);
        }
        if(!empty($request->time)){
            $yesterday = date("Y-m-d", strtotime( '-1 days' ) );
            return [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()];
            if($request->time == "Yestarday"){
                $products  = $products->whereDate('created_at',$yesterday);
            }elseif($request->time == "Last Week"){
                $start_week = Carbon::now()->subWeek()->startOfWeek()->toDateString();
                $end_week =Carbon::now()->subWeek()->endOfWeek()->toDateString();
                $products  = $products->where("created_at",">=",$start_week)->where("created_at","<=",$end_week);
            }else{
                $start_month = Carbon::now()->subMonth()->startOfMonth()->toDateString();
                $end_month =Carbon::now()->subMonth()->endOfMonth()->toDateString();
                $products  = $products->where("created_at",">=",$start_month)->where("created_at","<=",$end_month);
            }
            //$products = $products->whereIn("user_id",$request->time);
        }
        if(!empty($request->start_date) && !empty($request->end_date)){
            $star_date = date("Y-m-d",strtotime($request->start_date));
            $end_date  = date("Y-m-d",strtotime($request->end_date));
            $products  = $products->where("created_at",">=",$star_date)->where("created_at","<=",$end_date);
        }
        $products = $products->get();
        //$data = Product::where('name', 'LIKE', '%'. $request->get('search'). '%')->get();

        return response()->json($products);
    }

}
