@include('maif.editable_style')
<style>
  .loading-container {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1000;
        display: none; 
    }
    .loading-spinner {
        width: 100%; 
        height: 100%; 
    }

    #patient_table_length,
    #patient_table_filter {
        display: none;
    }
    #patient-code-container {
        position: relative;
    }
    #loading-image {
        position: absolute;
        margin-right: 50px;
        top: -8%;
        left: 50%; /* Adjust the position as needed */
        transform: translateY(-50%, -50%);
        width: 60px;
        height: 60px;
    }
    #province_id + .select2-container {
        width: 220px !important;
    }
    #muncity_id + .select2-container {
        width: 220px !important;
    }
    #barangay_id + .select2-container {
        width: 220px !important;
    }
    .select2-container--default .select2-results__option:hover {
        background-color: green !important; 
        color: white !important; 
    }

</style>
@extends('layouts.app')
@section('content')

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="float-right">
                <div class="input-group">
                    <form method="GET" action="{{ route('home') }}">
                        <div class="input-group">
                            <input type="hidden" class="form-control" name="key">
                            <input type="text" class="form-control" name="" id="search_patient" placeholder="Search..." value="" aria-label="Recipient's username">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-info" type="submit"><img src="\maif\public\images\icons8_search_16.png">Search</button> 
                                <button class="btn btn-sm btn-warning text-white" type="submit" name="viewAll" value="viewAll"><img src="\maif\public\images\icons8_eye_16.png">View All</button>
                                <button type="button" href="#create_patient" data-backdrop="static" data-toggle="modal" class="btn btn-success btn-md"><img src="\maif\public\images\icons8_create_16.png">Create</button>
                            </div>  
                        </div>
                    </form>
                    <form method="POST" action="{{ route('sent.mails') }}" class="send_mailform">
                        @csrf
                        <div style="display: flex; justify-content: flex-end;">
                            <button class="btn-sm send_mails" name="send_mails[]" style="display:none;background-color: green; color: white; height:48px; width:100px">Send Mails</button>
                            <input type="hidden" class="form-control idss" name="idss" id="idss" >
                        </div>
                    </form>
                </div>
            </div>
           
            <h4 class="card-title">Manage Patients</h4>
            <span class="card-description">
                MAIF-IPP
            </span>
            
            @if(count($patients) > 0)
            <div class="table-responsive">
                <table class="table table-striped" id="patient_table">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th style="text-align:center">
                            <div style="display: flex; gap: 1px;">
                                <button class="btn-info select_all" style="width: 25px; display: flex; justify-content: center; align-items: center;">
                                    <i class="typcn typcn-input-checked"></i>
                                </button>
                                <button class="btn-danger unselect_all" style="width: 25px; display: flex; justify-content: center; align-items: center;">
                                    <i class="typcn typcn-times menu-icon"></i>
                                </button>
                            </div>
                        </th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th style="min-width:120px">Actual Amount</th>
                        <th style="min-width:100px">Guaranteed </th>
                        <th style="min-width:120px; text-align:center;">Date </th>
                        <th style="min-width:90px; text-align:center;">Firstname </th>
                        <th style="min-width:100px; text-align:center;">Middlename </th>
                        <th style="min-width:100px; text-align:center;">Lastname </th>
                        <th style="min-width:120px; text-align:center;">Facility </th>
                        <th style="min-width:120px; text-align:center;">Proponent </th>
                        <th>Code </th>
                        <th style="min-width:100px;">Region </th>
                        <th style="min-width:100px; text-align:center;">Province </th>
                        <th style="min-width:100px; text-align:center;">Municipality </th>
                        <th style="min-width:100px; text-align:center;">Barangay </th>
                        <th style="min-width:100px">Created On </th>
                        <th style="min-width:190px">Created By </th>
                    </tr>
                </thead>
                <tbody id="list_body">
                    @foreach($patients as $index=> $patient)
                        <tr>
                            <td>
                                <button type="button" href="#patient_history" data-backdrop="static" style="width:90px;height:27px;background-color:#006BC4; color:white;" data-toggle="modal" class="" onclick="populateHistory({{$patient->id}})"><small>Edit History</small></button>
                                <button type="button" href="#get_mail" data-backdrop="static" data-toggle="modal" class="" style="width:90px;height:27px;background-color:#005C6F; color:white;" onclick="populate({{$patient->id}})"><small>Mail History</small></button>
                            </td>
                            <td class="td">
                                <a href="{{ route('patient.pdf', ['patientid' => $patient->id]) }}" style="background-color:teal;color:white; width:50px;" target="_blank" type="button" class="btn btn-xs">Print</a>
                                <a href="{{ route('patient.sendpdf', ['patientid' => $patient->id]) }}" type="button" style="width:50px;" class="btn btn-success btn-xs" id="send_btn">Send</a>
                            </td>
                            <td style="text-align:center;" class="group-email" data-patient-id="{{ $patient->id }}" >
                                <input class="sent_mails[] " id="mail_ids[]" name="mail_ids[]" type="hidden">
                                <input type="checkbox" style="width: 60px; height: 20px;" name="mailCheckbox[]" id="mailCheckboxId_{{ $index }}" 
                                    class="group-mailCheckBox" onclick="itemChecked($(this))">
                            </td>
                            <td style="text-align:center">
                                @if($patient->remarks == 1)
                                    <i class="typcn typcn-tick menu-icon">
                                @endif
                            </td>
                            <td>{{$patient->pat_rem}}</td>
                            <td class="editable-amount" data-actual-amount="{{!Empty($patient->actual_amount)?number_format($patient->actual_amount, 2, '.', ','): 0 }}" data-patient-id="{{ $patient->id }}" data-guaranteed-amount="{{str_replace(',', '', $patient->guaranteed_amount)}}">
                                <a href="#" class="number_editable"  title="Actual Amount" id="{{ $patient->id }}">{{!Empty($patient->actual_amount)?number_format($patient->actual_amount, 2, '.', ','): 0 }}</a>
                            </td>
                            <td class="td">{{ number_format((float) str_replace(',', '', $patient->guaranteed_amount), 2, '.', ',') }}</td>
                            <td>{{date('F j, Y', strtotime($patient->date_guarantee_letter))}}</td>
                            <td class="td">
                                <a href="#create_patient"   onclick="editPatient('{{ $patient->id }}')" data-backdrop="static" data-toggle="modal">
                                    {{ $patient->fname }}
                                </a>
                            </td>   
                            <td class="td">{{ $patient->mname }}</td>
                            <td class="td">{{ $patient->lname }}</td>
                            <td class="td">{{ $patient->facility->name }}</td>
                            <td class="td">{{ $patient->proponentData ? $patient->proponentData->proponent : 'N/A' }}</td>
                            <td class="td">{{ $patient->patient_code}}</td>
                            {{-- <td>
                                @if(isset($patient->facility->description))
                                    {{ $patient->facility->description }}
                                @else
                                    {{ $patient->other_facility }}
                                @endif
                            </td> --}}
                            <td class="td">{{ $patient->region }}</td>
                            <td class="td">
                                @if(isset($patient->province->description))
                                    {{ $patient->province->description }}
                                @else
                                    {{ $patient->other_province }}
                                @endif
                            </td>
                            <td class="td">
                                @if(isset($patient->muncity->description))
                                    {{ $patient->muncity->description }}
                                @else
                                    {{ $patient->other_muncity }}
                                @endif
                            </td>
                            <td class="td">
                                @if(isset($patient->barangay->description))
                                    {{ $patient->barangay->description }}
                                @else
                                    {{ $patient->other_barangay }}
                                @endif
                            </td>
                            <td>{{date('F j, Y', strtotime($patient->created_at))}}</td>
                            <td class="td">{{ $patient->encoded_by->lname .', '. $patient->encoded_by->fname }}</td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
            @else
                <div class="alert alert-danger" role="alert" style="width: 100%;">
                <i class="typcn typcn-times menu-icon"></i>
                    <strong>No patient found!</strong>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="create_patient" tabindex="-1" role="dialog" aria-hidden="true" style="opacity:1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-success" id="title"><i style = "font-size:30px"class="typcn typcn-user-add-outline menu-icon"></i> Create Patient</h4><hr />
                @csrf
            </div>
            <div class="modal_body">
                <form id="contractForm" method="POST" action="{{ route('patient.create.save') }}">
                    <input type="hidden" name="created_by" value="{{ $user->userid }}">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname">First Name</label>
                                    <input type="text" class="form-control" style="width:220px;" id="fname" name="fname" oninput="this.value = this.value.toUpperCase()" placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname">Last Name</label>
                                    <input type="text" class="form-control" style="width:220px;" id="lname" name="lname" placeholder="Last Name" oninput="this.value = this.value.toUpperCase()" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname">Middle Name</label>
                                    <input type="text" class="form-control" style="width:220px;" id="mname" name="mname" oninput="this.value = this.value.toUpperCase()" placeholder="Middle Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname">Date of Birth</label>
                                    <input type="date" class="form-control" style="width:220px;" id="dob" name="dob" placeholder="Date of Birth">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname">Region</label>
                                    <select class="js-example-basic-single select2" style="width:220px;" id="region" onchange="othersRegion($(this));" name="region">
                                        <option value="">Please select region</option>
                                        <option value="Region 7">Region 7</option>
                                        <option value="NCR">NCR</option>
                                        <option value="CAR">CAR</option>
                                        <option value="Region 1">Region 1</option>
                                        <option value="Region 2">Region 2</option>
                                        <option value="Region 3">Region 3</option>
                                        <option value="Region 4">Region 4</option>
                                        <option value="Region 5">Region 5</option>
                                        <option value="Region 6">Region 6</option>
                                        <option value="Region 8">Region 8</option>
                                        <option value="Region 9">Region 9</option>
                                        <option value="Region 10">Region 10</option>
                                        <option value="Region 11">Region 11</option>
                                        <option value="Region 12">Region 12</option>
                                        <option value="Region 13">Region 13</option>
                                        <option value="BARMM">BARMM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname">Province</label>
                                    <div id="province_body">
                                        <select class="js-example-basic-single select2" style="width:220px;" id="province_id" name="province_id" onchange="onchangeProvince($(this))">
                                            <option value="">Please select province</option>
                                            @foreach($provinces as $prov)
                                                <option value="{{ $prov->id }}">{{ $prov->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname">Municipality</label>
                                    <div id="muncity_body">
                                        <select class="js-example-basic-single select2" style="width:220px;" id="muncity_id" name="muncity_id" onchange="onchangeMuncity($(this))">
                                            <option value="">Please select Municipality</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname">Barangay</label>
                                    <div id="barangay_body">
                                        <select class="js-example-basic-single select2" style="width:220px;" id="barangay_id" name="barangay_id">
                                            <option value="">Please select Barangay</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname">Date of Guarantee Letter</label>
                                    <input type="date" class="form-control" style="width:220px;" id="date_guarantee_letter" name="date_guarantee_letter" placeholder="Date of Guarantee Letter" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname">Facility</label>
                                    <select class="js-example-basic-single facility_id1" style="width:220px;" id="facility_id" name="facility_id" onchange="onchangeForProponent($(this))" required>
                                        <option value="">Please select Facility</option>
                                        @foreach($facilities as $facility)
                                            <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname">Proponent</label>
                                    <select class="js-example-basic-single proponent_id1" style="width:220px;" id="proponent_id" name="proponent_id" onchange="onchangeForPatientCode($(this))" required>
                                        <option value="">Please select Proponent</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" id="patient-code-container">
                                    <input type="text" class="form-control loading-input" style="width:220px;" id="patient_code" name="patient_code" placeholder="Patient Code" readonly>
                                    <img id="loading-image" src="{{ asset('images/loading.gif') }}" alt="Loading" style="display: none;">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <strong>Transaction</strong>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname">Guaranteed Amount</label>
                                    <input type="text" class="form-control" id="guaranteed_amount" style="width:220px;" oninput="check()" onkeyup= "validateAmount(this)" name="guaranteed_amount" placeholder="Guaranteed Amount" required>
                                </div>
                            </div>
                            <div class="col-md-6"  id="actl_amnt" style="display:none">
                                <div class="form-group">
                                    <label for="fname">Actual Amount</label>
                                    <input type="number" step="any" class="form-control" id="actual_amount" name="actual_amount">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname">Remaining Balance</label>
                                    <input type="text" class="form-control" id="remaining_balance" style="width:220px;" name="remaining_balance" placeholder="Remaining Balance" readonly>
                                </div>
                                <div id="suggestions"></div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fname">Remarks</label>
                                    <textarea type="text" class="form-control" id="pat_rem" style="width:470px;" name="pat_rem" placeholder="Remarks"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="create_pat_btn" class="btn btn-primary">Create Patient</button>
                        <a type="button" class="btn btn-danger" style="display:none; color:white">Remove</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--end-->
<div class="modal fade" id="get_mail" tabindex="-1" role="dialog" aria-hidden="true" style="opacity:1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-success" id="title"><i class="typcn typcn-location menu-icon"></i>Mail History</h4><hr />
                @csrf
            </div>
            <div class="mail_body">
                
            </div>
            <div class="modal-footer">
                <button style = "background-color:lightgray"  class="btn btn-default" data-dismiss="modal"><i class="typcn typcn-times menu-icon"></i> Close</button>
            </div>
        </div>
    </div>
</div>
<!--end-->
<div class="modal fade" id="patient_history" tabindex="-1" role="dialog" aria-hidden="true" style="opacity:2">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="vertical-align:middle">
                <br>
                <h4 class="text-success" id="title"><i class="typcn typcn-location menu-icon"></i>Patient History</h4><hr/>
                @csrf
            </div>
            <div class="p_body">
            </div>
            <div class="modal-footer">
                <button style = "background-color:lightgray"  class="btn btn-default" data-dismiss="modal"><i class="typcn typcn-times menu-icon"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<div class="loading-container">
    <img src="public\images\loading.gif" alt="Loading..." class="loading-spinner">
</div>
@endsection
@section('js')
<script src="{{ asset('admin/js/select2.js?v=').date('His') }}"></script>
<script src="{{ asset('admin/vendors/x-editable/bootstrap-editable.min.js?v=1') }}"></script>
<script src="{{ asset('admin/vendors/daterangepicker-master/moment.min.js?v=1') }}"></script>
<script src="{{ asset('admin/vendors/daterangepicker-master/daterangepicker.js?v=1') }}"></script>
<script src="{{ asset('admin/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>

@include('maif.editable_js')

<script>
    $(function() {
        $('#filter_dates').daterangepicker();
    });

    var proponents,all_patients;

    $.get("{{ url('patient') }}", function(result) {
        proponents = result.proponents;
        all_patients = result.all_pat;
    });

    $('#list_body').on('click', function(){
        $('.filter').hide();
    });

    $('.btn-secondary').on('click', function(e) {
        $('#contractForm')[0].reset();
        $('#facility_id').val('').trigger('change');
        $('#proponent_id').val('').trigger('change');

    });

    $('.send_mailform').on('click', function(e) {
        $('.loading-container').show();
    });

    $('#send_btn').on('click', function(e) {
        $('.loading-container').show();
    });

    function error(){
        Lobibox.alert('error',{
            size: 'mini',
            msg: "There is an impostor! Find it"
        });
    }

    function amountError(){
        Lobibox.alert('error',{
            size: 'mini',
            msg: "There is no actual amount! Fill it"
        });
    }

    var all_ids = [];
    var id_list = [];
    
    function itemChecked(element){
        var parentTd = $(element).closest('td');   
        var patientId = parentTd.attr('data-patient-id');
        console.log('id', patientId);
        if(id_list.includes(patientId)){
            console.log("Patient ID already exists in the array.");
            id_list = id_list.filter(id => id !== patientId);
            console.log("Id_list:", id_list);
        } else {
            console.log("Patient ID does not exist in the array.");
            id_list.push(patientId);
            console.log("Added Patient ID to the array:", id_list);
        }

        if(id_list.length != 0){
            $('.send_mails').val(id_list).show();
        }else{
            $('.send_mails').val('').hide();
        }
    }

    $(document).ready(function () {
        console.log(jQuery.fn.jquery);
        function initializeDataTable() {
            var table = $('#patient_table').DataTable({
                paging: true,
                // deferRender: true,
                pageLength: 50,
                drawCallback: function() {
                    initializeEditable();
                    initializeMailboxes();
                }
            });

            $('#search_patient').on('keyup', function() {
                table.search(this.value).draw();
            });
        }

        function initializeEditable() {
            $.fn.editable.defaults.mode = 'popup';

            $(".number_editable").editable({
                type : 'number',
                name: 'actual_amount',
                title: $(this).data("title"),
                emptytext: 'empty',
                success: function(response, newValue) {
                    var cell = $(this).closest('.editable-amount');
                    var patientId = cell.data('patient-id');
                    var guaranteed_amount = cell.data('guaranteed-amount');
                    var actual_amount = cell.data('actual-amount');
                    var url = "{{ url('update/amount').'/' }}" + patientId + '/' + newValue;
                    var json = {
                        "_token" : "<?php echo csrf_token(); ?>",
                        "value" : newValue
                    };

                    if(newValue == ''){
                        Lobibox.alert('error',{
                            size: 'mini',
                            msg: "Actual amount accepts number only!"
                        }); 
                        newValue = 0;
                        location.reload();
                        return;  
                    }
                    var c_amount = newValue.replace(/,/g,'');

                    if(c_amount > guaranteed_amount){
                        $(this).html(newValue);
                        Lobibox.alert('error',{
                            size: 'mini',
                            msg: "Inputted actual amount if greater than guaranteed amount!"
                        }); 
                        location.reload();
                        return;           
                    }

                    $.post(url, json, function(result){
                        Lobibox.notify('success', {
                            title: "",
                            msg: "Successfully update actual amount!",
                            size: 'mini',
                            rounded: true
                        });
                        location.reload();
                    });
                }
            });
        }

        function initializeMailboxes() {
           
            $('.select_all').on('click', function() {
                $('#patient_table').DataTable().$('input.group-mailCheckBox').each(function() {
                    $(this).prop('checked', true).trigger('change');
                });
            });

            $('.unselect_all').on('click', function() {
                $('#patient_table').DataTable().$('input.group-mailCheckBox').each(function() {
                    $(this).prop('checked', false).trigger('change');
                });
            });

        }

        // Initialize on document ready
        initializeDataTable();

        // Reinitialize on DataTable draw
        $('#patient_table').on('draw.dt', function() {
            initializeEditable();
            initializeMailboxes();
        });
    });

    function validateAmount(element) {
        if (event.keyCode === 32) {
            event.preventDefault();
        }
        var cleanedValue = element.value.replace(/[^\d.]/g, '');
        var numericValue = parseFloat(cleanedValue);

        if ((!isNaN(numericValue) || cleanedValue === '' || cleanedValue === '.') &&
            !(cleanedValue.length === 1 && cleanedValue[0] === '0')) {
                element.value = cleanedValue.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }else{
            element.value = '';
        }
    }

    var edit_c = 0;

    function editPatient(id) {
        edit_c = 1;
        var editRoute = `{{ route('patient.update', ['id' => ':id']) }}`;
        editRoute = editRoute.replace(':id', id);
        $('#contractForm').attr('action', editRoute);
        $('#create_pat_btn').text('Update Patient');
        console.log('proponents', proponents);
        proponents.forEach(function(optionData) {
            $('.proponent_id1').append($('<option>', {
                value: optionData.id,
                text: optionData.proponent
            }));
        });
        var patient = all_patients.filter(item => item.id == id)[0];
        $('#title').html('<i style="font-size:30px" class="typcn typcn-user-outline menu-icon"></i> Update Patient');
        console.log('chaki', patient);
        if(patient){
            if(patient.group_id == null || patient.group_id == null){
                var removeRoute = `{{ route('patient.remove', ['id' => ':id']) }}`;
                removeRoute = removeRoute.replace(':id', id);
                $('.btn.btn-danger').attr('href', removeRoute).css('display', 'inline-block').text('Remove');
            }

            $('#fname').val(patient.fname);
            $('#lname').val(patient.lname);
            $('#mname').val(patient.mname);
            $('#dob').val(patient.dob);
            $('#region').select2().val(patient.region).trigger('change');
            if(patient.region == "Region 7"){
                $('#province_id').select2().val(patient.province_id).trigger('change');
                $('#muncity_id').select2().val(patient.muncity_id).trigger('change');
                $('#barangay_id').select2().val(patient.barangay_id).trigger('change');
            }else{
                console.log('herehere',patient.other_muncity );
                $('#other_province').val(patient.other_province);
                $('#other_muncity').val(patient.other_muncity);
                $('#other_barangay').val(patient.other_barangay);
            }
            $('#date_guarantee_letter').val(patient.date_guarantee_letter);
            $('#guaranteed_amount').val(patient.guaranteed_amount);
            $('#actl_amnt').show();
            $('#actual_amount').val(patient.actual_amount);
            $('.proponent_id1').val(patient.proponent_id).trigger('change');
            $('.facility_id1').val(patient.facility_id).trigger('change');
            $('#patient_code').val(patient.patient_code);
            $('#remaining_balance').val(patient.remaining_balance);
            $('#pat_rem').val(patient.pat_rem);
        }
        edit_c = 0;
        
    }

    function othersRegion(data) {
        if(data.val() != "Region 7"){
            {{-- var patientProvinceDescription = "{{ $patients->other_province }}"--}}
            // $("#facility_body").html("<input type='text' class='form-control' name='other_facility' required>");
            $("#province_body").html("<input type='text' class='form-control' value='' id='other_province' name='other_province'>");
            
            $("#muncity_body").html("<input type='text' class='form-control' id='other_muncity' name='other_muncity'>");
            $("#barangay_body").html("<input type='text' class='form-control' id='other_barangay' name='other_barangay'>");
        }else {

            $("#province_body").html("<select class=\"js-example-basic-single w-100 select2\" id=\"province_id\"  name=\"province_id\" onchange=\"onchangeProvince($(this))\">\n" +
                "\n" + "</select>");

            $('#province_id').append($('<option>', {
                value: "",
                text: "Please select a municipality"
            }));

            jQuery.each(JSON.parse('<?php echo $provinces; ?>'), function(i,val){
                $('#province_id').append($('<option>', {
                    value: val.id,
                    text : val.description
                }));
            });

            // $("#facility_body").html("<select class=\"form-control select2\" id=\"facility_id\" name=\"facility_id\" required>\n" +
            //     "                                        <option value=\"\">Please select municipality</option>\n" +
            //     "                                    </select>");

            $("#muncity_body").html("<select class=\"form-control select2\" id=\"muncity_id\" name=\"muncity_id\" onchange=\"onchangeMuncity($(this))\">\n" +
                "                                        <option value=\"\">Please select municipality</option>\n" +
                "                                    </select>");

            $("#barangay_body").html("<select class=\"form-control select2\" id=\"barangay_id\" name=\"barangay_id\">\n" +
                "                                        <option value=\"\">please select barangay</option>\n" +
                "                                    </select>");

            // $(".select2").select2({ width: '100%' });
            $("#muncity_id").select2({ width: '220px' });
            $("#barangay_id").select2({ width: '220px' });
            $("#province_id").select2({ width: '220px' });

        }

   } 

    function onchangeProvince(data) {
        $('#muncity_id').empty();
        $('#barangay_id').empty();
        var municipalities = @json($municipalities);
        var muncity = municipalities.filter(item => item.province_id == data.val());
        $('#muncity_id').append($('<option>', {
            value: "",
            text: "Please select a municipality"
        }));
        $('#barangay_id').append($('<option>', {
            value: "",
            text: "Please select a barangay"
        }));
        muncity.forEach(function(optionData) {
            $('#muncity_id').append($('<option>', {
                value: optionData.id,
                text: optionData.description
            }));
        });
    }

    function onchangeMuncity(data) {
        if(data.val()) {
            $('#barangay_id').html('');
            var barangays = @json($barangays);
            var barangay = barangays.filter(item => item.muncity_id == data.val());
            $('#barangay_id').append($('<option>', {
                value: "",
                text: "Please select a barangay"
            }));
            barangay.forEach(function(optionData) {
                $('#barangay_id').append($('<option>', {
                    value: optionData.id,
                    text: optionData.description
                }));
            });
        }
    }
    var facility_id = 0;

    function onchangeForProponent(data){
        if(edit_c == 0){
            if(data.val()){
            facility_id = data.val();
            $.get("{{ url('facility/proponent').'/' }}"+data.val(), function(result) {
                    $('#proponent_id').html('');
                    $('#proponent_id').append($('<option>', {
                        value: "",
                        text: "Select Proponent"
                    }));
                    $.each(result, function(index, optionData) {
                        $('#proponent_id').append($('<option>', {
                            value: result[index].id,
                            text: result[index].proponent
                        }));
                    });
                    $('#proponent_id').prop('disabled', false); 
                });
            }
        }
    }

    function onchangeForPatientCode(data) {
        var facility_id = $('#facility_id').val();
        if(edit_c == 0){
            if(data.val()) {
                $.get("{{ url('patient/code').'/' }}"+data.val()+"/"+facility_id, function(result) {
                    $("#patient_code").val(result.patient_code);
                    const formattedBalance = new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    }).format(result.balance);

                    $('#remaining_balance').val(formattedBalance);
                    var suggestions =[];
                    var res = result.proponent_info;
                    
                    $.each(res, function(index, optionData) {
                        suggestions.push(res[index].fundsource.saa +' - '+res[index].remaining_balance);
                    });
                    var suggestionsDiv = $('#suggestions');
                    suggestionsDiv.empty();

                    suggestions.forEach(function(suggestion) {
                        suggestionsDiv.append('<div>' + suggestion + '</div>');
                    });
                    suggestionsDiv.show();
                });
            }
        }
    }

    function parseNumberWithCommas(value) {
        if(typeof value === 'string'){
            return parseFloat(value.replace(/,/g, '')) || 0;
        } else{
            return parseFloat(value) || 0;
        }
    }

    function check(){
        var rem = parseNumberWithCommas($('#remaining_balance').val());
        var g_amount = parseNumberWithCommas($('#guaranteed_amount').val());
        if(g_amount>rem){
            Lobibox.alert('error', {
                size: 'mini',
                msg: 'Inputted amount is greater than the remaning balance!'
            })
            $('#guaranteed_amount').val('');
        }
    }

    function formatDate(item){
        var date = new Date(item);
        var formattedDate = date.toLocaleString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });
        return formattedDate;
    }
    
    function populateHistory(id){
        $('#gl_history').empty();
        $('.p_body').html(loading);
        var url = "{{ url('/patient/history').'/' }}"+id;
        $.ajax({
            url: url,
            type: 'GET',
            success: function(result) {
                $('.p_body').html(result);
            }
        });
    }

    function populate(id){
        $('#mail_history').empty();
        var url = "{{ url('/mail/history').'/' }}"+id;
        $.ajax({
            url: url,
            type: 'GET',
            success: function(result) {
                $('.mail_body').html(result);
            }
        });
    }

    </script>
@endsection
