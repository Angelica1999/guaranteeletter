<!DOCTYPE html>
<html>
    <head>
        <title>Guarantee Letter</title>
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
        <link rel="stylesheet" href="{{ public_path('bootstrap.min.css') }}">
        <style>
            .header-container {
                clear: both;
            }

             .img-wrap {
                display: inline-block;
                float: left;
                vertical-align: top;
                /* margin-right: 10px; */
            } 

            .header {
                font-size: 11px;
                text-align: center;
                margin: 10px;
            }

            .left-align {
                text-align: right;
            }

            p {
                font-size: 11px;
            }
            td {
                font-size: 11px; 
                padding: 8px; 
                border: 1px solid #ccc; 
            }
 
            .static-data {
                display: inline-block;
                min-width: 55%; 
                text-align: right; 
            }
            #certifacate{
                font-size: 13px;
                margin-top:15px;
            }
            .date{
                /* float: right; */
                text-align: right;
            }
        </style>
    </head>
    <body>
        <div class="row align-items-start ml-1"> 
            <div class="col-1 d-flex align-items-center">
                <div class="img-wrap">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/doh-logo.png'))) }}" alt="Logo" width="50" height="50">
                </div>
            </div>
            <div class="col-11 text-center" style="font-size: 10px">
                <div class="ml-2">
                    <p>Republic of the Philippines<br>
                        Department of Health<br>
                        <span class="col text-center" style="font-size: 12px"><strong>MAIFIP - Medical Assistance to Indigent and Financially - Incapacitated Patients</strong></span>
                    </p>
                </div>
            </div>
        </div>

        <div class="form-group ml-1">
        <p class="date">{{ $patient['date_guarantee_letter'] ? \Carbon\Carbon::parse($patient->date_guarantee_letter)->format('jS F Y') : " " }}</p>
            <p class="col text-center" id="certificate"><strong>CERTIFICATION</strong></p> <!-- Corrected typo in ID -->
        </div>

        <div class="form-group ml-1">
            @if($patient->barangay == null)
                @if($patient->region == null)
                    <p>This is to certify that patient <strong>{{ $patient->fname . ' ' . $patient->mname . ' ' . $patient->lname}}</strong>, {{ $age }}, was extended by this office, a total of {{ number_format(str_replace(',','',$patient->guaranteed_amount), 2, '.', ',') }} medical assistance stated below based on the existing guidelines of Administrative Order No. 2023 - 0016, dated August 11, 2023:</p>
                @else
                    <p>This is to certify that patient <strong>{{ $patient->fname . ' ' . $patient->mname . ' ' . $patient->lname}}</strong>, {{ $age }}, of {{$patient->other_barangay . ', '. $patient->other_muncity . ', '. $patient->other_province}}, was extended by this office, a total of {{ number_format(str_replace(',','',$patient->guaranteed_amount), 2, '.', ',') }} medical assistance stated below based on the existing guidelines of Administrative Order No. 2023 - 0016, dated August 11, 2023:</p>
                @endif
            @else
                <p>This is to certify that patient <strong>{{ $patient->fname . ' ' . $patient->mname . ' ' . $patient->lname}}</strong>, {{ $age }}, of {{$patient->barangay->description . ', '. $patient->muncity->description . ', '. $patient->province->description}}, was extended by this office, a total of {{ number_format(str_replace(',','',$patient->guaranteed_amount), 2, '.', ',') }} medical assistance stated below based on the existing guidelines of Administrative Order No. 2023 - 0016, dated August 11, 2023:</p>
            @endif
        </div>

        <table class="table table-white ml-1">
            <thead>
                <tr>
                    <th scope="col" style="font-size: 12px">Type of Assistance</th>
                    <th scope="col" style="font-size: 12px">Guaranteed Amount</th>
                    <th scope="col" style="font-size: 12px">Date/Time</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Hospital Bills / laboratory /Procedures/ Medicine()</td>
                    <td class="text-center">{{ number_format(str_replace(',','',$patient->guaranteed_amount), 2, '.', ',') }}</td>
                    <td>{{$patient->created_at}}</td>
                </tr>
            </tbody>
        </table>

        <p class="ml-3" ><strong>Total Amount:</strong>
            <span class="static-data"><strong>P {{ number_format(str_replace(',','',$patient->guaranteed_amount), 2, '.', ',') }}</strong></span>
        </p>
        <div class="row align-items-start ml-1"> 
            <p class="ml-1">{{$patient->patient_code}}<br><br>
                Notes:<br>
                <i>50% maximum applicable for PF</i><br>
                Non-Convertible to cash<br><br>
                Encoded by: {{$patient->created_by}}
            </p>
        </div>
        <div class="col text-center">
            <!-- <p>Osmeña Boulevard, Sambag II, Cebu City,6000 Philippines 
                (032) 260-9740 loc.111 0915-395-6599 <a href="https://doh.gov.ph">doh.gov.ph</a></p> -->
        </div>  
        
          <!-- Footer Section -->
          <div class="footer">
        <!-- Your footer content goes here -->
        <!-- <p class="text-center">&copy; 2023 dohro7ofcrdard@gmail.com. All rights reserved.</p> -->
    </div>

        <hr> <!-- Horizontal line representing the footer -->

        <div class="row align-items-start ml-1"> 
            <div class="col-1 d-flex align-items-center">
                <div class="img-wrap">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/doh-logo.png'))) }}" alt="Logo" width="50" height="50">
                </div>
            </div>
            <div class="col-11 text-center" style="font-size: 10px">
                <div class="ml-2">
                    <p>Republic of the Philippines<br>
                        Department of Health<br>
                        <span class="col text-center" style="font-size: 12px"><strong>MAIFIP - Medical Assistance to Indigent and Financially - Incapacitated Patients</strong></span>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="form-group">
        <p class="date">{{ $patient->date_guarantee_letter ? \Carbon\Carbon::parse($patient->date_guarantee_letter)->format('jS F Y') : " " }}</p>
            <p class="col text-center" id="certificate"><strong>CERTIFICATION</strong></p> <!-- Corrected typo in ID -->
        </div>

        <div class="form-group">
            @if($patient->barangay == null)
                @if($patient->region == null)
                    <p>This is to certify that patient <strong>{{ $patient->fname . ' ' . $patient->mname . ' ' . $patient->lname}}</strong>, {{ $age }}, was extended by this office, a total of {{ number_format(str_replace(',','',$patient->guaranteed_amount), 2, '.', ',') }} medical assistance stated below based on the existing guidelines of Administrative Order No. 2023 - 0016, dated August 11, 2023:</p>
                @else
                    <p>This is to certify that patient <strong>{{ $patient->fname . ' ' . $patient->mname . ' ' . $patient->lname}}</strong>, {{ $age }}, of {{$patient->other_barangay . ', '. $patient->other_muncity . ', '. $patient->other_province}}, was extended by this office, a total of {{ number_format(str_replace(',','',$patient->guaranteed_amount), 2, '.', ',') }} medical assistance stated below based on the existing guidelines of Administrative Order No. 2023 - 0016, dated August 11, 2023:</p>
                @endif
            @else
                <p>This is to certify that patient <strong>{{ $patient->fname . ' ' . $patient->mname . ' ' . $patient->lname}}</strong>, {{ $age }}, of {{$patient->barangay->description . ', '. $patient->muncity->description . ', '. $patient->province->description}}, was extended by this office, a total of {{ number_format(str_replace(',','',$patient->guaranteed_amount), 2, '.', ',') }} medical assistance stated below based on the existing guidelines of Administrative Order No. 2023 - 0016, dated August 11, 2023:</p>
            @endif
        </div>

        <table class="table table-white">
            <thead>
                <tr>
                    <th scope="col" style="font-size: 12px">Type of Assistance</th>
                    <th scope="col" style="font-size: 12px">Guaranteed Amount</th>
                    <th scope="col" style="font-size: 12px">Date/Time</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Hospital Bills / laboratory /Procedures/ Medicine()</td>
                    <td class="text-center">{{ number_format(str_replace(',','',$patient->guaranteed_amount), 2, '.', ',') }}</td>
                    <td>{{$patient->created_at}}</td>
                </tr>
            </tbody>
        </table>

        <p class="ml-3"><strong>Total Amount:</strong>
            <span class="static-data"><strong>P {{ number_format(str_replace(',','',$patient->guaranteed_amount), 2, '.', ',') }}</strong></span>
        </p>
        <div class="row align-items-start ml-1"> 
            <p class="ml-1">{{$patient->patient_code}}<br><br>
                Notes:<br>
                <i>50% maximum applicable for PF</i><br>
                Non-Convertible to cash<br><br>
                Encoded by: {{$patient->created_by}}
            </p>
        </div>
        <div class="col text-center">
            <!-- <p>Osmeña Boulevard, Sambag II, Cebu City,6000 Philippines 
                (032) 260-9740 loc.111 0915-395-6599 <a href="https://doh.gov.ph">doh.gov.ph</a></p> -->
        </div>       
       <!-- Footer Section -->
    <div class="footer text-center">
        <!-- Your footer content goes here -->
        <!-- <p>&copy; 2023 dohro7ofcrdard@gmail.com. All rights reserved.</p> -->
    </div>
    </body>
</html>
