<?php

namespace App\Http\Controllers;
use App\Models\Patients;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Dv;
use App\Models\MailHistory;
use App\Models\AddFacilityInfo;
use App\Models\Dv2;
use App\Models\Facility;
use App\Models\Fundsource;
use App\Models\Proponent;
use Illuminate\Support\Facades\Mail;
use App\Mail\PdfEmail;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Jobs\SendMultipleEmails;

class PrintController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function calculateAge($dob) {

        $dob = Carbon::parse($dob);
        $currentDate = Carbon::now();
        $age = $currentDate->diffInYears($dob);

        if ($age >= 1) {
            if ($dob->diffInMonths($currentDate) > 0) {
                return $age . ' y/o';
            } else {
                return $age . ' y/o';
            }
        } else {
            return $dob->diffInMonths($currentDate) . ' month' . ($dob->diffInMonths($currentDate) != 1 ? 's' : '');
        }
    }
    
    public function patientPdf(Request $request, $patientid) {
        $patient = Patients::where('id',$patientid)->with('encoded_by', 'province', 'muncity', 'barangay')->first();
        if(!$patient){
            return redirect()->route('Home.index')->with('error', 'Patient not found.');
        }

        $data = [
            'title' => 'Welcome to MAIF',
            'date' => date('m/d/Y'),
            'patient' => $patient,
            'age' => $this->calculateAge($patient->dob)
        ];
        $options = [];
    
        $pdf = PDF::loadView('maif.print_patient', $data, $options);
        return $pdf->stream('patient.pdf');
    }

    public function sendPatientPdf($patientId) {

        $ids = array($patientId);
        set_time_limit(0);

        if ($ids !== null || $ids !== '') {
            SendMultipleEmails::dispatch($ids);
            return redirect()->route('home')->with('status', 'Emails are being sent in the background.');
        }

        return redirect()->route('home')->with('status', 'No emails selected.');

    }

    public function sendMultiple(Request $request)
    {
        $ids = $request->input('send_mails');
        $ids = array_map('intval', explode(',', $ids[0]));
        set_time_limit(0);

        if ($ids !== null || $ids !== '') {
            SendMultipleEmails::dispatch($ids);
            return redirect()->route('home')->with('status', 'Emails are being sent in the background.');
        }

        return redirect()->route('home')->with('status', 'No emails selected.');
    }
        
}
