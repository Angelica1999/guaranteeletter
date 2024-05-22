<?php

namespace App\Jobs;

use App\Models\Patients;
use App\Models\Proponent;
use App\Models\AddFacilityInfo;
use App\Models\MailHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use PDF;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Exception;
use Carbon\Carbon;

class SendMultipleEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $patientIds;

    public function __construct($patientIds)
    {
        $this->patientIds = $patientIds;
    }

    public function handle()
    {
        $ids = $this->patientIds;

        if ($ids !== null || $ids !== '') {
            $patients = Patients::whereIn('id', $ids)->with('facility')->get();
            if ($patients) {
                foreach ($patients as $patient) {
                    $proponent = Proponent::where('id', $patient->proponent_id)->first();
                    $name_file = $patient->lname . ', ' . $patient->fname . ' - ' . $proponent->proponent;
                    $facility = AddFacilityInfo::where('facility_id', $patient->facility_id)->first();
                    if ($facility) {
                        if ($facility->official_mail !== null || $facility->official_mail !== "" || $facility->official_mail !== "none") {
                            $data = [
                                'title' => 'Welcome to MAIF',
                                'date' => date('m/d/Y'),
                                'patient' => $patient,
                                'age' => $this->calculateAge($patient->dob)
                            ];
                            $options = [];
                            $recipientEmail = $facility->official_mail;
                            $cc = str_replace(' ', '', $facility->cc);
                            $cc_mails = explode(',', $cc);

                            $pdf = PDF::loadView('maif.print_patient', $data, $options);
                            $pdfFilePath = storage_path("app/pdf");
                            $pdf->save($pdfFilePath);

                            try {
                                $this->sendMail($recipientEmail, $pdfFilePath, $cc_mails, $name_file);
                                $patient->remarks = 1;
                                $patient->save();
                                $history = new MailHistory();
                                $history->patient_id = $patient->id;
                                $history->sent_by = Auth::user()->userid;
                                $history->modified_by = $patient->created_by;
                                $history->save();
                                session()->flash('email_sent', true);
                            } catch (Exception $e) {
                                session()->flash('email_unsent', true);
                            }
                        }
                    } else {
                        session()->flash('email_unsent', true);
                    }
                }
            }
        }
    }

    private function sendMail($recipientEmail, $pdfFilePath, $cc_mails, $name_file)
    {
        try {
            $email_doh = 'maipp@ro7.doh.gov.ph';
            $email_password = 'betvdmvyribwcyba';
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $email_doh;                             //SMTP username
            $mail->Password   = $email_password;                        //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->SMTPDebug = 0;
            //Recipients
            $mail->setFrom($email_doh, 'DOH-CVCHD MAIFIP');
            $mail->addAddress($recipientEmail);     //Add a recipient
            $mail->addReplyTo($email_doh);
            if ($cc_mails !== null && $cc_mails !== "") {
                foreach ($cc_mails as $ccEmail) {
                    if ($ccEmail !== "") {
                        $mail->addCC($ccEmail);
                    }
                }
            }
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Guarante Letters for the following patients';
            $mail->addEmbeddedImage('public\images\maipp_banner.png', 'unique_cid_for_image', 'image.jpg');
            $mail->Body =
                '<html><body>
                <span style="text-align:right;">Please acknowledge receipt of this email. Thank you.<span>
                    <div align="center">
                        <div align="center">
                            <img src="cid:unique_cid_for_image" width="100%"> 
                        </div>
                    </div>
                </body></html>
                ';
            $mail->addAttachment($pdfFilePath, $name_file . ".pdf");
            $mail->send();
            unlink($pdfFilePath);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    private function calculateAge($dob)
    {
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
}

