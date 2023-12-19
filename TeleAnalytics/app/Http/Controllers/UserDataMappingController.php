<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UserDataMapping;
use App\Models\DataPlan;
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

    public function stateAnalysis(Request $request):View
    {

        if ($request->has('state') && $request->input('state')!="--Select State--") {
            // Input is present
            $value = $request->input('state');
            $data = DB::select('select u.state state,count(distinct u.id) totalCustomers,sum(dp.cost) revenue from users u,data_plan dp,user_data_mapping udm 
            where u.id=udm.user_id and dp.id=udm.data_plan_id and u.state=? group by u.state',[$value]);
            $data2 = DB::select('select u.state,CONCAT(CAST(udm.data_plan_id AS VARCHAR(255)), \' - \',dp.description) dpDet,count(udm.data_plan_id) up from users u,data_plan dp,user_data_mapping udm 
            where u.id=udm.user_id and dp.id=udm.data_plan_id and u.state=? group by u.state,udm.data_plan_id,dp.description order by up desc LIMIT 1;',[$value]);
            if(count($data)>0){
                $result=[
                    'totalCustomer'=>$data[0]->totalCustomers,
                    'revenue' => $data[0]->revenue,
                    'mostUsedPlan'=>$data2[0]->dpDet,
                ];
                return view('user_data_mapping.state', ['result' => $result]);
            }
            else{
                $result=[
                    'totalCustomer'=>0,
                    'revenue' => 0,
                    'mostUsedPlan'=>'',
                ];
                return view('user_data_mapping.state', ['result' => $result]);
            }
            
        } else {
            $result=[
                'totalCustomer'=>0,
                'revenue' => 0,
                'mostUsedPlan'=>'',
            ];
            return view('user_data_mapping.state', ['result' => $result]);
        }
    }
            
        public function yearAnalysis(Request $request): View
        {
            if($request->has('start_year') && $request->has('end_year')){
                $value1 = $request->input('start_year');
                $value2 = $request->input('end_year');
                $data = DB::select('select YEAR(STR_TO_DATE(subs_date, "%Y-%m-%d")) year,sum(cost) revenue from data_plan dp,user_data_mapping udm  where dp.id=udm.data_plan_id and
                YEAR(STR_TO_DATE(subs_date, "%Y-%m-%d")) between ? and ? group by year;',[$value1,$value2]);
                $result = new \stdClass();
                foreach($data as $det){
                    $d1=$det->year;
                    $d2=$det->revenue;
                    $result-> $d1= $d2;
                }
                return view('user_data_mapping.year', ['result' => $result]);
            }
            else{
                $data = DB::select('select YEAR(STR_TO_DATE(subs_date, "%Y-%m-%d")) year,sum(cost) revenue from data_plan dp,user_data_mapping udm  where dp.id=udm.data_plan_id and
                YEAR(STR_TO_DATE(subs_date, "%Y-%m-%d")) between ? and ? group by year;',[2019,2023]);
                $result = new \stdClass();
                foreach($data as $det){
                    $d1=$det->year;
                    $d2=$det->revenue;
                    $result-> $d1= $d2;
                }
                return view('user_data_mapping.year', ['result' => $result]);
            }
            

        }
    
    public function dataManagement(Request $request): View
    {
        $dataPlans = DataPlan::all();
        return view('user_data_mapping.dataManagement', ['dataPlans' => $dataPlans]);
    }
      
    public function update(Request $request):RedirectResponse
    {
        $dataPlan = DataPlan::findOrFail($request->input('id'));

        $request->validate([
            'cost' => 'required|numeric',
            'validity' => 'required|numeric',
            'data_per_day' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $is_active = $request->input('is_active') === 'on' ? 'Yes' : 'No';

        $dataPlan->update([
            'cost' => $request->input('cost'),
            'validity' => $request->input('validity'),
            'data_per_day' => $request->input('data_per_day'),
            'description' => $request->input('description'),
            'is_active' => $is_active,
            // Add other fields as needed
        ]);
        return redirect()->route('user_data_mapping.dataManagement');
    }

    public function saveDataPlan(Request $request):RedirectResponse
    {

        $request->validate([
            'price' => 'required|numeric',
            'valid' => 'required|numeric',
            'data' => 'required|numeric',
            'desc' => 'required|string',
        ]);

        $is_active = $request->input('active') === 'on' ? 'Yes' : 'No';
        $dataPlan = DataPlan::create([
            'cost' => $request->input('price'),
            'validity' => $request->input('valid'),
            'data_per_day' => $request->input('data'),
            'description' => $request->input('desc'),
            'is_active' => $is_active,
        ]);

        return redirect()->route('user_data_mapping.dataManagement');
    }
        
}

