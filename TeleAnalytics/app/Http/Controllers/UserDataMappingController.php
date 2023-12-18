<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\UserDataMapping;
use App\Models\User;
class UserDataMappingController extends Controller
{
    //
    /**
     * Store a newly created resource in storage.
     */
    

    public function create() : View
    {
        $user = User::find(Auth::user()->id);

        // Retrieve data plans for the user

        $dataPlans = $user->dataPlans;
        
        return view('user_data_mapping.show', ['user_data_mapping' => $dataPlans]);
    }

    public function store(Request $request):RedirectResponse
    {
        $plan_id=$request->input('data_plan_id');
        $user_id=Auth::user()->id;
        $userMapping = new UserDataMapping([
            'user_id' => $user_id,
            'data_plan_id' => $plan_id,
            'subs_date' => now(), // You can customize the subscription date as needed
        ]);
        
        $userMapping->save();
        return redirect(RouteServiceProvider::SELECTED_PLANS);
    }
}
