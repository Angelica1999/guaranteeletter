<form>
    <div class="table-container" style="margin:5px; padding:10px">
        <table class="table table-bordered">
            <thead>
                <tr style="background-color:gray; color:white">
                    <th scope="col">Patient</th>
                    <th scope="col">Birthdate</th>
                    <th scope="col">Address</th>
                    <th scope="col">Date</th>
                    <th scope="col">Facility</th>
                    <th scope="col">Proponent</th>
                    <th scope="col">Code</th>
                    <th scope="col">Guaranteed</th>
                    <th scope="col">Actual</th>
                    <th scope="col">Remarks</th>
                    <th scope="col">Modified By</th>
                    <th scope="col">On</th>
                </tr>
            </thead>
            <tbody id="gl_history">
                @foreach($logs as $l)
                <tr>
                    <td>{{$l->lname}}, {{$l->fname}} {{$l->mname}}</td>
                    <td>{{!Empty($l->dob)?date('F j, Y', strtotime($l->dob)):''}}</td>
                    <td>
                        @if($l->region == 'Region 7')
                            <?php
                                echo (!empty($l->barangay) ? $l->barangay->description . ', ' : '') .
                                                (!empty($l->muncity) ? $l->muncity->description . ', ' : '') .
                                                (!empty($l->province) ? $l->province->description . ', ' : '') .
                                                (!empty($l->region) ? $l->region : '') ;
                            ?>
                        @else
                            <?php
                                echo (!empty($l->other_barangay) ? $l->other_barangay . ', ' : '') .
                                                (!empty($l->other_muncity) ? $l->other_muncity . ', ' : '') .
                                                (!empty($l->other_province) ? $l->other_province . ', ' : '') .
                                                (!empty($l->region) ? $l->region : '') ;
                            ?>
                        @endif
                    </td>
                    <td>{{!Empty($l->date_guarantee_letter)?date('F j, Y', strtotime($l->date_guarantee_letter)):''}}</td>
                    <td>{{$l->facility->name}}</td>
                    <td>{{$l->proponent->proponent}}</td>
                    <td>{{$l->proponent_code}}</td>
                    <td>{{number_format(str_replace(',','', $l->guaranteed_amount), 2, ',','.')}}</td>
                    <td>{{!Empty($l->actual_amount)?number_format(str_replace(',','', $l->actual_amount), 2, ',','.'): ' '}}</td>
                    <td>{{$l->pat_rem}}</td>
                    <td>{{$l->modified->lname}}, {{$l->modified->fname}} {{$l->modified->mname}}</td>
                    <td>{{date('F j, Y', strtotime($l->created_at))}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</form>