@extends('layouts.app')

@section('content')

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <form method="GET" action="">
                <div class="input-group float-right w-50" style="min-width: 600px;">
                    <input type="text" class="form-control" name="keyword" placeholder="Disbursement Voucher" value="" aria-label="Recipient's username">
                        <div class="input-group-append">
                        <button class="btn btn-sm btn-info" type="submit">Search</button>
                        <button class="btn btn-sm btn-warning text-white" type="submit" name="viewAll" value="viewAll">View All</button>
                        <button type="button" href="#create_patient" onclick="createPatient()" data-backdrop="static" data-toggle="modal" class="btn btn-success btn-md">Create</button>
                        {{-- <div class="btn-group">
                            <button type="button" class="btn btn-success btn-md dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Create
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="#create_patient" onclick="createPatient()" data-backdrop="static" data-toggle="modal">Disbursement Voucher</a>
                              <a class="dropdown-item" href="#">Disbursement Voucher</a>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </form>
            <h4 class="card-title">Disbursement Voucher</h4>
            <p class="card-description">
                MAIF-IPP
            </p>
            <div class="table-responsive">
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            Option
                        </th>
                        <th>
                            Firstname
                        </th>
                        <th>
                            Middlename
                        </th>
                        <th>
                            Lastname
                        </th>
                        <th>
                            DOB
                        </th>
                        {{-- <th>
                            Facility
                        </th> --}}
                        <th>
                            Region
                        </th>
                        <th>
                            Province
                        </th>
                        <th>
                            Municipality
                        </th>
                        <th>
                            Barangay
                        </th>
                        {{-- <th>
                            Amount
                        </th> --}}
                        <th>
                            Guaranteed Amount
                        </th>
                        <th>
                            Actual Amount
                        </th>
                        <th>
                            Created By
                        </th>
                    </tr>
                </thead>
                <tbody>
                  
                        <tr>
                            <td>
                            Option
                            </td> 
                                <td>
                                Firstname
                                </td>   
                            <td>
                            Middlename
                            </td>
                            <td>
                            Lastname
                            </td>
                            <td>
                            DOB
                               
                            </td>
                            <td>
                            Region
                                
                            </td>
                            <td>
                            Province
                            </td>
                            <td>
                            Municipality
                            </td>
                            <td>
                            Barangay	
                            </td>
                     
                            <td>
                            Guaranteed Amount
                            </td>
                            <td>
                            Actual Amount
                            </td>
                            <td>
                            Created By
                            </td>
                        </tr>
              
                </tbody>
                </table>
            </div>
            <div class="pl-5 pr-5 mt-5">
               
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="create_patient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal_body">
                
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')



@endsection