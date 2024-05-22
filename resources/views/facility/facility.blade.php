@extends('layouts.app')

@section('content')
<div class="container-fluid col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <form method="GET" action="">
                <div class="input-group float-right w-50" style="min-width: 600px;">
                    <input type="text" class="form-control" name="keyword" placeholder="Facility" value="{{ $keyword }}">
                    <div class="input-group-append">
                        <button class="btn btn-sm btn-info" type="submit"><img src="\maif\public\images\icons8_search_16.png">Search</button>
                        <button class="btn btn-sm btn-warning text-white" type="submit" name="viewAll" value="viewAll"><img src="\maif\public\images\icons8_eye_16.png">View All</button>
                    </div>
                </div>
            </form>
            <h4 class="card-title">Facility</h4>
            <p class="card-description">
                MAIF-IPP
            </p>
            @if(isset($results) && $results->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Official Email</th>
                        <th style="min-width:200px;">Additional Email(s)</th>
                        <th>Vat</th>
                        <th>Ewt</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $facility)
                        <tr>
                            <td class="td">
                                <a href="{{ route('facility.edit', ['main_id' => $facility->id]) }}" 
                                    data-target="#update_facility" 
                                    type="button" 
                                    onclick="updateFacility(this)" 
                                    data-backdrop="static" 
                                    data-toggle="modal" 
                                    class="btn btn-primary btn-sm"
                                    data-main-id="{{ $facility->id }}"
                                    data-name="{{$facility->name}}">Update</a>
                            </td>
                            <td class="td">{{ $facility->name }}</td>
                            <td class="td">{{ $facility->address }}</td>
                            <td class="td">{{ $facility->AddFacilityInfo->official_mail ?? '' }}</td>
                            <td class="td">{{ $facility->AddFacilityInfo->cc ?? '' }}</td>
                            <td class="td">{{ $facility->AddFacilityInfo->vat ?? '' }}</td>
                            <td class="td">{{ $facility->AddFacilityInfo->Ewt ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
            @else
                <div class="alert alert-danger" role="alert" style="width: 100%;">
                <i class="typcn typcn-times menu-icon"></i>
                    <strong>No facility found!</strong>
                </div>
            @endif
            <div class="pl-5 pr-5 mt-5">
                {!! $results->appends(request()->query())->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="update_facility" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-success modal-title" id="exampleModalLabel"></h5>
            </div>
            <div class="modal_body">
            <input type="hidden" id="main_id" name="main_id" value="">
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script>
    
        @if(session('facility_save'))
             <?php session()->forget('facility_save'); ?>
             Lobibox.notify('success', {
                msg: 'Successfully saved Facility!'
             });
        @endif

    function updateFacility(clickedElement) {
        var main_id = $(clickedElement).data('main-id');
        var name = $(clickedElement).data('name');  
        $('.modal-title').html('<i style="font-size:30px" class="typcn typcn-home menu-icon"></i> '+name);
        $('.modal_body').html(loading);

        var url = "{{ route('facility.edit', ':main_id') }}"; // Use a placeholder for main_id

        url = url.replace(':main_id', main_id);

        setTimeout(function() {
            $.ajax({
                url: url,
                type: 'GET',
                success: function(result) {
                    $('.modal_body').html(result);
                }
            });
        }, 500);
    }

    function addTransaction() {
        event.preventDefault();
        $.get("{{ route('transaction.get') }}",function(result) {
            $("#transaction-container").append(result);
        });
    }
    </script>
    
@endsection