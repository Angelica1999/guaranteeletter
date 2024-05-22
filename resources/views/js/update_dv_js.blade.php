@section('js')
<script>

  function updateDv() {
    $('.modal_body').html(loading);
    $('.modal-title').html("Update Disbursement Voucher");
    $('#dv_form').attr('action', "{{ route('dv.create.save') }}");
    var dvId = event.target.getAttribute('data-dvId');
    var url = "{{ route('dv.create') }}";

    setTimeout( function () {
    $.ajax({
        url: url,
        type: 'GET',
        success: function (result) {
            var first_res = result;

            removeNullOptions();

            $.get("{{ url('/getDv').'/' }}" + dvId, function (result) {
            $('.modal_body').html(first_res);

            var printButton = $('<a>', {
                href: "{{ route('dv.pdf', '') }}/" + dvId,
                target: '_blank',
                type: 'button',
                class: 'btn btn-success btn-sm',
                text: 'Generate PDF'
            });

            $('#dv_footer').append(printButton);
                $('#dv').val(dvId);
                $('#dv_no').val(result.dv.dv_no);
                console.log('kkkk', $('#dv').val());
                if(result.dv.obligated == 1){
                    $('.btn-primary').hide();
                }else{
                    $('.btn-primary').text('Update');
                }
                $('#accumulated').prop('disabled', false).show();
                $('#accumulated').val(result.dv.accumulated);
                $('#totalDebit').text(formatNumberWithCommas(parseNumberWithCommas
                    (result.dv.total_amount)-parseNumberWithCommas(result.dv.accumulated), 2, '.',','));
                var facility = result.dv.facility_id;
                update = 0;
                $('#facilityDropdown').val(facility).trigger('change');
                $('#for_facility_id').val(facility);
                onchangeSaa($('#saa1'), result.proponent[0].id, result.proponent[0].pro_group);
                console.log('chakii',result.facility.name);        
                counter = 0;
                var vat=1;
                if(result.dv.deduction1>3){
                    vat = 1.12;
                }
                if(result.fund_source[0].saa !== null || result.fund_source[0].saa !== undefined){
                    $('#saa1_infoId').val(result.proponent[0].id);
                    setTimeout(function() {
                        $('#saa1 option').each(function () {
                            var value =  $(this).val();
                            var group = $(this).attr('dataprogroup');
                            var proponent = $(this).attr('dataproponent');
                            var facility = $(this).attr('datafacility');
                            if(value == result.fund_source[0].id && proponent == result.proponent[0].id 
                                && group == result.proponent[0].pro_group &&  facility == result.facilities[0].id){
                                $(this).prop('selected',true);
                                $('#saa1').trigger('change');
                            }
                        });
                    }, 1500);

                    $('#inputValue1').val(result.dv.amount1).prop('disabled', false).show();
                    $('#vat').val(result.dv.deduction1);
                    $('#ewt').val(result.dv.deduction2);
                    $('#vatValue1').val((parseFloat(result.dv.amount1.replace(/,/g,''))/vat * result.dv.deduction1/100).toFixed(2));
                    $('#ewttValue1').val((parseFloat(result.dv.amount1.replace(/,/g,''))/vat * result.dv.deduction2/100).toFixed(2));
                    $('#save_amount1').val(parseFloat(result.dv.amount1.replace(/,/g,'')));
                    $('#save_saa1').val(result.fund_source[0].id);
                    $('#save_fac1').val(result.dv.facility_id);
                    var oki = parseFloat(result.dv.amount1) * result.dv.deduction1;
                    saaCounter = 1;
                } if(result.fund_source[1] !== null && result.fund_source[1] !== undefined){
                    toggleSAADropdowns($('#saa1'), result.proponent[0].id, result.proponent[0].pro_group);
                    console.log('result', result.fund_source);
                    if(result.dv.amount2 !== null){
                        $('#saa2_infoId').val(result.proponent[1].id);
                        console.log('saa2', result.fund_source[1].id)
                        $('#RemoveSAAButton').prop('disabled', false).show();
                        $('#saa2').prop('disabled', false).show();
                        setTimeout(function() {
                            $('#saa2 option').each(function () {
                                var value =  $(this).val();
                                var group = $(this).attr('dataprogroup');
                                var proponent = $(this).attr('dataproponent');
                                var facility = $(this).attr('datafacility');
                                if(value == result.fund_source[1].id && proponent == result.proponent[1].id 
                                    && group == result.proponent[1].pro_group &&  facility == result.facilities[1].id){
                                    $(this).prop('selected',true);
                                    $('#saa2').trigger('change');
                                }
                            });
                        }, 1500);
                        
                        $('#inputValue2').val(result.dv.amount2).prop('disabled', false).show();
                        // $('#saa2').val(result.fund_source[1].id);
                        $('#vatValue2').val((parseFloat(result.dv.amount2.replace(/,/g,''))/vat * result.dv.deduction1/100).toFixed(2)).show();
                        $('#ewtValue2').val((parseFloat(result.dv.amount2.replace(/,/g,''))/vat * result.dv.deduction2/100).toFixed(2)).show();
                        $('#save_amount2').val(parseFloat(result.dv.amount2.replace(/,/g,'')));
                        $('#save_saa2').val(result.fund_source[0].id);
                        saaCounter = 2;
                    }else{
                        $('#RemoveSAAButton1').prop('disabled', false).show();
                        $('#saa2').prop('disabled', false).show();
                        $('#saa2_infoId').val(result.proponent[2].id);
                        setTimeout(function() {
                            $('#saa2 option').each(function () {
                                var value =  $(this).val();
                                var group = $(this).attr('dataprogroup');
                                var proponent = $(this).attr('dataproponent');
                                var facility = $(this).attr('datafacility');
                                if(value == result.fund_source[2].id && proponent == result.proponent[2].id 
                                    && group == result.proponent[2].pro_group &&  facility == result.facilities[2].id){
                                    $(this).prop('selected',true);
                                    $('#saa2').trigger('change');
                                }
                            });
                        }, 1500);
                        $('#inputValue3').val(result.dv.amount3).prop('disabled', false).show();
                        $('#vatValue3').val((parseFloat(result.dv.amount3.replace(/,/g,''))/vat * result.dv.deduction1/100).toFixed(2)).show();
                        $('#ewtValue3').val((parseFloat(result.dv.amount3.replace(/,/g,''))/vat * result.dv.deduction2/100).toFixed(2)).show();
                        $('#save_amount3').val(parseFloat(result.dv.amount3.replace(/,/g,'')));
                        $('#save_saa3').val(result.fund_source[0].id);
                    }
                    
                } if(result.fund_source[2] !== null && result.fund_source[2] !== undefined){
                    $('#saa3_infoId').val(result.proponent[2].id);
                    toggleSAADropdowns($('#saa1'), result.proponent[0].id, result.proponent[0].pro_group);
                    $('#saa3').prop('disabled', false).show();
                    $('#inputValue3').val(result.dv.amount3).prop('disabled', false).show();
                    setTimeout(function() {
                            $('#saa3 option').each(function () {
                                var value =  $(this).val();
                                var group = $(this).attr('dataprogroup');
                                var proponent = $(this).attr('dataproponent');
                                var facility = $(this).attr('datafacility');
                                if(value == result.fund_source[2].id && proponent == result.proponent[2].id 
                                    && group == result.proponent[2].pro_group &&  facility == result.facilities[2].id){
                                    $(this).prop('selected',true);
                                    $('#saa3').trigger('change');
                                }https://icones.js.org/collection/ph
                            });
                        }, 1500);
                    $('#vatValue3').val((parseFloat(result.dv.amount3.replace(/,/g,''))/vat * result.dv.deduction1/100).toFixed(2)).show();
                    $('#ewtValue3').val((parseFloat(result.dv.amount3.replace(/,/g,''))/vat * result.dv.deduction2/100).toFixed(2)).show();
                    $('#save_amount3').val(parseFloat(result.dv.amount3.replace(/,/g,'')));
                    $('#save_saa3').val(result.fund_source[0].id);
                    $('#RemoveSAAButton1').prop('disabled', false).show();
                }
                console.log('saa2saa2', document.getElementById('saa2').value);

                $('#control_no').val(result.dv.control_no);
                $('#forVat_left').val((parseFloat(result.dv.total_amount.replace(/,/g,''))/vat).toFixed(2));
                $('#forEwt_left').val((parseFloat(result.dv.total_amount.replace(/,/g,''))/vat).toFixed(2));
                $('.total').text(result.dv.total_amount);
                $('#totalInput').val(result.dv.total_amount);
                $('.totalDeduction').text(result.dv.total_deduction_amount);
                console.log('deduction',result.dv.total_deduction_amount );
                $('#totalDeduction').val(result.dv.total_deduction_amount);
                $('.overallTotal').text(result.dv.overall_total_amount);
                $('#overallTotal').val(result.dv.overall_total_amount);
                $('#inputDeduction1').val((parseFloat($('#vatValue3').val() ||0) + parseFloat($('#vatValue2').val() || 0) + parseFloat($('#vatValue1').val()||0)).toFixed(2));
                $('#inputDeduction2').val((parseFloat($('#ewtValue3').val() ||0) + parseFloat($('#ewtValue2').val()||0) + parseFloat($('#ewttValue1').val()||0)).toFixed(2));
                var parts = result.dv.date.split("T")[0].split("-");
                var formattedDate = parts[0] + "-" + parts[1] + "-" + parts[2];
                $('#dateField').val(formattedDate);
                
                var from = new Date(result.dv.month_year_from);
                var from_date = `${from.getFullYear()}-${(from.getMonth() + 1).toString().padStart(2, '0')}`;
                $('#billingMonth1').val(from_date);
                if(result.dv.month_year_to !== null){
                    var to = new Date(result.dv.month_year_to);
                    var to_date = `${to.getFullYear()}-${(to.getMonth() + 1).toString().padStart(2, '0')}`;
                    $('#billingMonth2').val(to_date);
                }
                
                var id = result.fund_source[0].id;
                var val = result.dv.facility_id;

                $('#DeductForCridet').text(result.dv.total_deduction_amount);
                $('#OverTotalCredit').text(result.dv.overall_total_amount);
                
            var dropdown = document.getElementById('saa2');
            removeNullOptions();
            dropdown.addEventListener('change', function(){
            removeNullOptions();

            });
            setTimeout(function() {
                      fundAmount();
                    }, 1500);
            }); 
        }
    });
    }, 0);

  }

</script>
@endsection