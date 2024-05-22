<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patients;
use App\Models\Facility;
use App\Models\Province;
use App\Models\Muncity;
use App\Models\Barangay;
use App\Models\Fundsource;
use App\Models\Proponent;
use App\Models\ProponentInfo;
use App\Models\User;
use App\Models\MailHistory;
use App\Models\PatientLogs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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


     public function index(Request $request){
        $filter_date = $request->input('filter_dates');
        
        $patients = Patients::where('created_by', Auth::user()->userid)->with([
            'province' => function ($query) {
                $query->select('id', 'description');
            },
            'muncity' => function ($query) {
                $query->select('id', 'description');
            },
            'barangay' => function ($query) {
                $query->select('id', 'description');
            },
            'encoded_by' => function ($query) {
                $query->select('userid', 'fname', 'lname');
            },
            'facility' => function ($query) {
                $query->select('id','name');
            },
            'proponentData' => function ($query) {
                $query->select('id','proponent');
            }
        ]);
       
        if($filter_date){
            $dateRange = explode(' - ', $filter_date);
            $start_date = date('Y-m-d', strtotime($dateRange[0]));
            $end_date = date('Y-m-d', strtotime($dateRange[1]));
            $patients = $patients ->whereBetween('created_at', [$start_date, $end_date . ' 23:59:59'])->orderBy('id', 'desc')->get();
        }else{
            $patients = $patients ->orderBy('id', 'desc')->get();
        }

        return view('home', [
            'patients' => $patients,
            'keyword' => $request->keyword,
            'provinces' => Province::get(),
            'municipalities' => Muncity::get(),
            'barangays' => Barangay::get(),
            'facilities' => Facility::get(),
            'user' => Auth::user()
        ]);
     }

     public function facilityProponentGet($facility_id) {

        $ids = ProponentInfo::where(function ($query) use ($facility_id) {
                        $query->whereJsonContains('proponent_info.facility_id', '702')
                            ->orWhereJsonContains('proponent_info.facility_id', [$facility_id]);
                    })
                    ->orWhereIn('proponent_info.facility_id', [$facility_id, '702'])
                    ->pluck('proponent_id')->toArray();

        $proponents = Proponent::select( DB::raw('MAX(proponent) as proponent'), DB::raw('MAX(id) as id'))
            ->groupBy('proponent_code') ->whereIn('id', $ids)
            ->get();
        return $proponents;
    }


     public function fetchAdditionalData(){
        return [
            'all_pat' => Patients::get(),
            'proponents' => Proponent::get()
        ];
     }

    public function updateAmount($patientId, $amount){

        $patient = Patients::find($patientId);
        $newAmount = str_replace(',', '',$amount);

        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }else{
            if($patient->group_id !== null && $patient->group_id !== ""){
                $group = Group::where('id', $patient->group_id)->first();
                $updated_a = floatval(str_replace(',', '', $group->amount)) - floatval($patient->actual_amount) + floatval($newAmount);
                $stat = $group->status;
                $group->status = 1;
                $group->amount = number_format($updated_a, 2, '.',',');
                $group->save();
            }
            $patient->actual_amount = $newAmount;
            $patient->save();
            // session()->flash('actual_amount', true);
        }
    }

    public function createPatientSave(Request $request) {
        
        $data = $request->all();
        Patients::create($request->all());
        $patientCount = Patients::where('fname', $request->fname)
            ->where('lname', $request->lname)
            ->where('mname', $request->mname)
            ->where('region', $request->region)
            ->where('province_id', $request->province_id)
            ->where('muncity_id', $request->muncity_id)
            ->where('barangay_id', $request->barangay_id)
            ->count();
        if($patientCount>0){
            session()->flash('patient_exist', $patientCount);
        }else{
            session()->flash('patient_save', true);
        }

        return redirect()->back();
    }

    public function fetchPatient($id){
        $patient =  Patients::where('id',$id)
                        ->with(
                            [
                                'muncity' => function ($query) {
                                    $query->select(
                                        'id',
                                        'description'
                                    );
                                },
                                'barangay' => function ($query) {
                                    $query->select(
                                        'id',
                                        'description'
                                    );
                                },
                                'fundsource',
                            ])->orderBy('updated_at', 'desc')
                        ->first();

        $municipal = Muncity::select('id', 'description')->get();
        $barangay = Barangay::select('id', 'description')->get();
        return [
            'patient' => $patient
        ];        
    }

    public function editPatient(Request $request) {
        $patient =  Patients::where('id',$request->patient_id)
                        ->with(
                            [
                                'muncity' => function ($query) {
                                    $query->select(
                                        'id',
                                        'description'
                                    );
                                },
                                'barangay' => function ($query) {
                                    $query->select(
                                        'id',
                                        'description'
                                    );
                                },
                                'fundsource',
                            ])->orderBy('updated_at', 'desc')
                        ->first();

        $municipal = Muncity::select('id', 'description')->get();
        $barangay = Barangay::select('id', 'description')->get();
        return view('maif.update_patient',[
            'provinces' => Province::get(),
            'fundsources' => Fundsource::get(),
            'proponents' => Proponent::get(),
            'facility' => Facility::get(),
            'patient' => $patient,
            'municipal' => $municipal,
            'barangay' => $barangay,
        ]);
    }
 
    public function updatePatient($id, Request $request){
        // $patient_id = $request->input('patient_id');
        $patient_id = $id;
        $patient = Patients::where('id', $patient_id)->first();

        if(!$patient){
            return redirect()->back()->with('error', 'Patient not found');
        }
        
        $patientLogs = new PatientLogs();
        $patientLogs->patient_id = $patient->id;
        $patientLogs->fill($patient->toArray());
        unset($patientLogs->id);
        $patientLogs->save();

        session()->flash('patient_update', true);
        $patient->fname = $request->input('fname');
        $patient->lname = $request->input('lname');
        $patient->mname = $request->input('mname');
        $patient->dob   = $request->input('dob');
        $patient->region = $request->input('region');

        if($patient->region !== "Region 7"){
            $patient->other_province = $request->input('other_province');
            $patient->other_muncity = $request->input('other_muncity');
            $patient->other_barangay = $request->input('other_barangay');
        }
        
        $patient->province_id = $request->input('province_id');
        $patient->muncity_id  = $request->input('muncity_id');
        $patient->barangay_id = $request->input('barangay_id');
        // $patient->fundsource_id = $request->input('fundsource_id');
        $patient->proponent_id = $request->input('proponent_id');
        $patient->facility_id = $request->input('facility_id');
        $patient->patient_code = $request->input('patient_code');
        $patient->guaranteed_amount = $request->input('guaranteed_amount');
        $patient->actual_amount = $request->input('actual_amount');
        $patient->remaining_balance = $request->input('remaining_balance');
        $patient->pat_rem = $request->input('pat_rem');

        $patient->save();
        return redirect()->back();
    }

    public function removePatient($id){
        if($id){
            Patients::where('id', $id)->delete();
        }
        return redirect()->back()->with('remove_patient', true);
    }

    public function muncityGet(Request $request) {
        return Muncity::where('province_id',$request->province_id)->whereNull('vaccine_used')->get();
    }

    public function barangayGet(Request $request) {
        return Barangay::where('muncity_id',$request->muncity_id)->get();
    }

    public function transactionGet() {
        $facilities = Facility::where('hospital_type','private')->get();
        return view('fundsource.transaction',[
            'facilities' => $facilities
        ]);
    }

    public function forPatientCode($proponent_id, $facility_id) {
        $user = Auth::user();
        $proponent= Proponent::where('id', $proponent_id)->first();
        $proponent_ids= Proponent::where('proponent', $proponent->proponent)->pluck('id')->toArray();
        $facility = Facility::find($facility_id);
        $patient_code = $proponent->proponent_code.'-'.$this->getAcronym($facility->name).date('YmdHi').$user->id;
        
        $proponent_info = ProponentInfo::where(function ($query) use ($facility_id, $proponent_ids) {
                                $query->where(function ($subquery) use ($facility_id) {
                                    $subquery->whereJsonContains('proponent_info.facility_id', '702')
                                            ->orWhereJsonContains('proponent_info.facility_id', [$facility_id]);
                                })
                                ->orWhereIn('proponent_info.facility_id', [$facility_id, '702']);
                            })
                            ->whereIn('proponent_id', $proponent_ids)
                            ->with('fundsource')
                            ->get();
        $sum = $proponent_info->sum(function ($info) {
                    return (float) str_replace(',', '', $info->remaining_balance);
                });                                

        return [
            'patient_code' => $patient_code,
            'proponent_info' => $proponent_info,
            'balance' => $sum,
        ];
    }

    public function forPatientFacilityCode($fundsource_id) {

        $proponentInfo = ProponentInfo::where('fundsource_id', $fundsource_id)->first();
        
        if($proponentInfo){
            $facility = Facility::find($proponentInfo->facility_id);

            $proponent = Proponent::find($proponentInfo->proponent_id);
            $proponentName = $proponent ? $proponent->proponent : null;
            return response()->json([

                'proponent' => $proponentName,
                'proponent_id' => $proponentInfo? $proponentInfo->proponent_id : null,
                'facility' => $facility ? $facility->name : null,
                'facility_id' => $proponentInfo ? $proponentInfo->facility_id : null,
            ]);
        }else{
            return response()->json(['error' => 'Proponent Info not found'], 404);
        }
    }

    public function getAcronym($str) {
        $words = explode(' ', $str); 
        $acronym = '';
        
        foreach ($words as $word) {
            $acronym .= strtoupper(substr($word, 0, 1)); 
        }

        return $acronym;
    }

    public function patientHistory($id){
        return view('maif.patient_history',[
            'logs' => PatientLogs::where('patient_id', $id)->with('modified', 'facility', 'province', 'muncity', 'barangay', 'proponent')->get()
        ]);
    }

    public function mailHistory($id){
        return view('maif.mail_history',[
            'history' => MailHistory::where('patient_id', $id)->with('patient', 'sent', 'modified')->get()
        ]);
    }

    // public function transactionGet() {
    //     $randomBytes = random_bytes(16); 
    //     $uniqueCode = bin2hex($randomBytes);
    //     $facilities = Facility::where('hospital_type','private')->get();
    //     return view('fundsource.transaction',[
    //         'facilities' => $facilities,
    //         'uniqueCode' => $uniqueCode
    //     ]);
    // }
}
