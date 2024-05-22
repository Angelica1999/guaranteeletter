<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('admin/vendors/typicons.font/font/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject --> 
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('admin/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Lobibox/lobibox.css') }}"/>
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('admin/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <!-- End plugin css for this page -->  
    <link rel="shortcut icon" href="{{ asset('images/doh-logo.png') }}" />
    <!-- Scripts -->
    <!-- datatables -->
    <link rel="stylesheet" href="{{ asset('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <!-- datarangepicker -->
    <link rel="stylesheet" href="{{ asset('admin/vendors/daterangepicker-master/daterangepicker.css') }}">

    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    @yield('css')
</head>
<body>
    <div id="app">
        <div class="container-scroller">
            @include('layouts.partials._navbar')
            <div class="container-fluid page-body-wrapper">
                {{-- @include('layouts.partials._settings-panel') --}}
                @include('layouts.partials._sidebar')
                <div class="main-panel">   
                    <div class="content-wrapper">
                        <div class="text-center p-2" style="background-color: #067536;width:100%;margin-bottom:30px;">
                            <img src="{{ asset('images/banner_maif_2024.png') }}" alt="banner"/>  
                        </div>   
                        <div class="row">
                            @yield('content')
                        </div>
                    </div>
                    @include('layouts.partials._footer')
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin/vendors/js/vendor.bundle.base.js') }}"></script>

    <script src="{{ asset('admin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin/js/template.js') }}"></script>
    <script src="{{ asset('admin/js/settings.js') }}"></script>
    <script src="{{ asset('admin/js/todolist.js') }}"></script>
    <script src="{{ asset('admin/vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('Lobibox/lobibox.js?v=').date('His') }}"></script>
    
    <script>
        var path_gif = "{{ asset('images/loading.gif') }}";
        var loading = '<center><img src="'+path_gif+'" alt=""></center>';
        
      
        @if(session('facility_save'))
             <?php session()->forget('facility_save'); ?>
             Lobibox.notify('success', {
                msg: 'Successfully saved Facility!'
             });
        @endif
        @if(session('patient_update'))
            <?php session()->forget('patient_update'); ?>
            Lobibox.notify('success', {
                msg: 'Successfully updated patient!'
            });
        @endif
        @if(session('patient_save'))
            <?php session()->forget('patient_save'); ?>
            Lobibox.notify('success', {
                msg: 'Successfully saved patient!'
            });
        @endif
        @if(session('fundsource_save'))
            <?php session()->forget('fundsource_save'); ?>
            Lobibox.notify('success', {
                msg: 'Successfully saved Fund Source!'
            });
        @endif
        @if(session('fundsource_update'))
            <?php session()->forget('fundsource_update'); ?>
            Lobibox.notify('success', {
                msg: 'Successfully update Fund Source!'
            });
        @endif
        @if(session('dv_create'))
           <?php session()->forget('dv_create'); ?>
           Lobibox.notify('success', {
              msg: 'Disbursement was Created!'
           });
        @endif
        @if(session('dv_update'))
           <?php session()->forget('dv_create'); ?>
           Lobibox.notify('success', {
              msg: 'Disbursement was updated!'
           });
        @endif
        @if(session('fund_transfer'))
           <?php session()->forget('fund_transfer'); ?>
           Lobibox.notify('success', {
              msg: 'Funds successfuly transferred!'
           });
        @endif
        @if(session('actual_amount'))
           <?php session()->forget('actual_amount'); ?>
           Lobibox.notify('success', {
              msg: 'Actual Amount successfuly updated!'
           });
        @endif
        @if(session('save_group'))
           <?php session()->forget('save_group'); ?>
           Lobibox.notify('success', {
              msg: 'Group successfuly saved!'
           });
        @endif
        @if(session('create_dv2'))
           <?php session()->forget('save_group'); ?>
           Lobibox.notify('success', {
              msg: 'Disbursement Voucher V2 successfuly created!'
           });
        @endif
        @if(session('email_sent'))
            <?php session()->forget('email_sent'); ?>
            Lobibox.notify('success', {
              msg: 'Sucessfully sent an email!'
           });
        @endif
        @if(session('email_unsent'))
        <?php session()->forget('email_unsent'); ?>
            window.close();
            Lobibox.notify('error', {
              msg: 'Cannot send an email, please provide correct email!'
           });
        @endif
        @if(session('save_patientgroup'))
           <?php session()->forget('save_patientgroup'); ?>
           Lobibox.notify('success', {
              msg: 'Successfully added a patient in a group!'
           });
        @endif
        @if(session('update_group'))
           <?php session()->forget('update_group'); ?>
           Lobibox.notify('success', {
              msg: 'Please update disbursement voucher!'
           });
        @endif
        @if(session('remove_patientgroup'))
           <?php session()->forget('remove_patientgroup'); ?>
           Lobibox.notify('success', {
              msg: 'Successfully removed a message!'
           });
        @endif
        @if(session('breakdowns_created'))
           <?php session()->forget('breakdowns_created'); ?>
           Lobibox.notify('success', {
              msg: 'Successfully created a breakdowns!'
           });
        @endif
        @if(session('obligate'))
           <?php session()->forget('obligate'); ?>
           Lobibox.notify('success', {
              msg: 'Dv was successfully obligated!'
           });
        @endif
        @if(session('saa_exist'))
           <?php session()->forget('saa_exist'); ?>
           Lobibox.notify('error', {
              msg: 'Saa exists already!'
           });
        @endif
        @if(session()->has('patient_exist'))
            <?php $patientCount = session('patient_exist'); ?>
            <?php session()->forget('patient_exist'); ?>
            Lobibox.notify('success', {
               msg: 'Successfully added a patient! This patient has been added {{ $patientCount}} time(s).'
            });
         @endif
         @if(session('pay_dv'))
           <?php session()->forget('pay_dv'); ?>
           Lobibox.notify('success', {
              msg: 'Successfully paid the disbursement!'
           });
        @endif
        @if(session('releaseAdded'))
           <?php session()->forget('releaseAdded'); ?>
         //   <div class="alert alert-success">
         //       <i class="fa fa-check"></i> Successfully released!
         //    </div>
           Lobibox.notify('success', {
              msg: ' Successfully released! '
           });
        @endif
        @if(session('add_dvno'))
           <?php session()->forget('add_dvno'); ?>
           Lobibox.notify('success', {
              msg: 'Successfully add dv no!'
           });
        @endif
        @if(session('update_dv2'))
           <?php session()->forget('update_dv2'); ?>
           Lobibox.notify('success', {
              msg: 'Successfully update dv2!'
           });
        @endif
        @if(session('add_deductions'))
           <?php session()->forget('add_deductions'); ?>
           Lobibox.notify('success', {
              msg: 'Successfully added a usage in administrative cost!'
           });
        @endif
        @if(session('upload_files'))
           <?php session()->forget('upload_files'); ?>
           Lobibox.notify('success', {
              msg: 'File uploaded successfully!'
           });
        @endif
        @if(session('dv2_remove'))
           <?php session()->forget('dv2_remove'); ?>
           Lobibox.notify('error', {
              msg: 'Disbursement voucher version 2 successfully removed!'
           });
        @endif
        @if(session('dv_remove'))
           <?php session()->forget('dv_remove'); ?>
           Lobibox.notify('error', {
              msg: 'Successfully removed Disbursement Voucher!'
           });
        @endif
        @if(session('remove_patient'))
           <?php session()->forget('dv_remove'); ?>
           Lobibox.notify('error', {
              msg: 'Successfully removed the patient!'
           });
        @endif
    </script>
    @yield('js')
</body>
</html>
