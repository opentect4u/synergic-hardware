@extends('common.master')
@section('content')

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Device {{ isset($customer)?'Edit':'Add'}}</h4>
                    @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">Updated successfully.</div>
                    @endif
                    <!-- <p class="card-description">
                        Basic form elements
                    </p> -->
                    <form class="forms-sample" method="post"
                        action="{{ isset($customer)?route('deviceSaleeditconfirm'):route('deviceSaleadd')}}">
                        @csrf
                        <input type="text" hidden name="id" id="id" value="{{isset($customer)?$customer->sl_no:''}}">

                        <div class="form-group">
                            <label for="exampleInputName1"> Sale Date </label>
                            <input type="text" class="form-control" name="sale_dt" required id="sale_dt"
                                placeholder="DD-MM-YYYY"
                                value="{{isset($customer)?date('d-m-Y',strtotime($customer->arrival_dt)):''}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Invoice No.</label>
                            <input type="text" class="form-control" name="bill_no" required id="bill_no"
                                value="{{isset($customer)?$customer->bill_no:''}}" {{isset($customer)?'readonly':''}}
                                placeholder="Invoice No.">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Sale Center</label>
                            <Select class="form-control" name="srv_ctr" id="srv_ctr" required>
                                <option value=""> -- Select Center -- </option>
                                @foreach($serviceCenter as $serviceCenters)
                                <option value="{{$serviceCenters->sl_no}}"
                                    <?php if(isset($customer) && $customer->serv_ctr==$serviceCenters->sl_no){echo "selected";}?>>
                                    {{$serviceCenters->center_name}}</option>
                                @endforeach
                            </Select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Customer</label>
                            <Select class="form-control" name="cust_cd" id="cust_cd" required>
                                <option value=""> -- Select Customer -- </option>
                                @foreach($mdcustomers as $mdcustomer)
                                <option value="{{$mdcustomer->cust_cd}}"
                                    <?php if(isset($customer) && $mdcustomer->cust_cd==$customer->cust_cd){echo "selected";}?>>
                                    {{$mdcustomer->cust_name}}</option>
                                @endforeach
                            </Select>
                        </div>



                        <div class="form-group">
                            <label for="exampleInputName1">Remarks</label>
                            <textarea class="form-control" name="remarks" id="remarks" cols="30"
                                rows="5">{{isset($customer)?$customer->remarks:''}}</textarea>
                        </div>


                        <div class="w-100" id="tableDiv">
                            @if(isset($customer))
                            @foreach($allcustomer as $allcustomers)
                            <hr>
                            <div class="form-group row" id="row_1">

                                <div class="col-6 grid-margin">
                                    <label>Item</label>
                                    <Select class="form-control" name="mc_type[]" id="mc_type_1" required>
                                        <option value=""> -- Select Item -- </option>
                                        @foreach($machines as $machine)
                                        <option value="{{$machine->mc_id}}"
                                            <?php if($machine->mc_id==$allcustomers->mc_type){echo "selected";}?>>
                                            {{$machine->mc_type}}</option>
                                        @endforeach
                                    </Select>
                                </div>
                                <div class="col-6 grid-margin">
                                    <label for="">Version</label>
                                    <Select class="form-control" name="mc_ver[]" id="mc_ver_1" required>
                                        <option value=""> -- Select Version -- </option>
                                        @foreach($versions as $version)
                                        <option value="{{$version->sl_no}}"
                                            <?php if($version->sl_no==$allcustomers->mc_version){echo "selected";}?>>
                                            {{$version->version_name}}</option>
                                        @endforeach
                                    </Select>
                                </div>
                                <div class="col-6 grid-margin">
                                    <label for="">Quantity</label>
                                    <input type="number" class="form-control" name="mc_qty[]" id="mc_qty_1" required
                                        value="{{ABS($allcustomers->mc_qty)}}" placeholder="Quantity">
                                </div>
                                <div class="col-6 grid-margin">
                                    <label for="">Warranty Period (E.x.: In Months)</label>
                                    <input type="number" class="form-control" name="warr_prd[]" id="warr_prd_1" required
                                        value="{{$allcustomers->warranty_period}}"
                                        placeholder="(In Months)">
                                </div>
                                <div class="col-6 grid-margin">
                                    <label for="">Sl.No.From</label>
                                    <input type="number" class="form-control" name="sl_frm[]" id="sl_frm_1"
                                        value="{{isset($customer)?$allcustomers->sl_no_from:0}}"
                                        {{isset($customer)?'readonly':0}} placeholder="">
                                </div>
                                <div class="col-6 grid-margin">
                                    <label for="">Sl.No.To</label>
                                    <input type="number" class="form-control" name="sl_to[]" id="sl_to_1"
                                        value="{{isset($customer)?$allcustomers->sl_no_to:0}}"
                                        {{isset($customer)?'readonly':0}} placeholder="">
                                </div>
                                <div class="col-12">
                                    <label for="">Sl.No. (E.x.- 111,222,333)</label>
                                    <textarea class="form-control" name="c_sl[]" id="c_sl_1"><?php
                                        $amc_details=DB::table('td_device_amc')->where('trans_dt',$allcustomers->trans_dt)
                                            ->where('trans_no',$allcustomers->trans_no)
                                            ->where('mc_type',$allcustomers->mc_type)
                                            ->get();
                                        if (isset($customer)) {
                                            $i=1;
                                            foreach ($amc_details as $key => $value) {
                                                echo $value->sl_no;
                                                if($i!=count($amc_details)){
                                                    echo ",";
                                                }
                                                $i++;
                                            }
                                        }else{
                                            echo "";
                                        }
                                        ?></textarea>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <hr>
                            <div class="form-group row" id="row_1">

                                <div class="col-6 grid-margin">
                                    <label>Item</label>
                                    <Select class="form-control" name="mc_type[]" id="mc_type_1" required>
                                        <option value=""> -- Select Item -- </option>
                                        @foreach($machines as $machine)
                                        <option value="{{$machine->mc_id}}"
                                            <?php if(isset($customer) && $machine->mc_id==$customer->mc_type){echo "selected";}?>>
                                            {{$machine->mc_type}}</option>
                                        @endforeach
                                    </Select>
                                </div>
                                <div class="col-6 grid-margin">
                                    <label for="">Version</label>
                                    <Select class="form-control" name="mc_ver[]" id="mc_ver_1" required>
                                        <option value=""> -- Select Version -- </option>
                                        @foreach($versions as $version)
                                        <option value="{{$version->sl_no}}"
                                            <?php if(isset($customer) && $version->sl_no==$customer->mc_version){echo "selected";}?>>
                                            {{$version->version_name}}</option>
                                        @endforeach
                                    </Select>
                                </div>
                                <div class="col-6 grid-margin">
                                    <label for="">Quantity</label>
                                    <input type="number" class="form-control" name="mc_qty[]" id="mc_qty_1" required
                                        value="{{isset($customer)?ABS($customer->mc_qty):''}}" placeholder="Quantity">
                                </div>
                                <div class="col-6 grid-margin">
                                    <label for="">Warranty Period (E.x.: In Months)</label>
                                    <input type="number" class="form-control" name="warr_prd[]" id="warr_prd_1" required
                                        value="{{isset($customer)?$customer->warranty_period:''}}"
                                        placeholder="(In Months)">
                                </div>
                                <div class="col-6 grid-margin">
                                    <label for="">Sl.No.From</label>
                                    <input type="number" class="form-control" name="sl_frm[]" id="sl_frm_1"
                                        value="{{isset($customer)?$customer->sl_no_from:0}}"
                                        {{isset($customer)?'readonly':0}} placeholder="">
                                </div>
                                <div class="col-6 grid-margin">
                                    <label for="">Sl.No.To</label>
                                    <input type="number" class="form-control" name="sl_to[]" id="sl_to_1"
                                        value="{{isset($customer)?$customer->sl_no_to:0}}"
                                        {{isset($customer)?'readonly':0}} placeholder="">
                                </div>
                                <div class="col-12">
                                    <label for="">Sl.No. (E.x.- 111,222,333)</label>
                                    <textarea class="form-control" name="c_sl[]" id="c_sl_1"><?php
                                    $amc_details=[];
                                        if (isset($customer)) {
                                            $i=1;
                                            foreach ($amc_details as $key => $value) {
                                                echo $value->sl_no;
                                                if($i!=count($amc_details)){
                                                    echo ",";
                                                }
                                                $i++;
                                            }
                                        }else{
                                            echo "";
                                        }
                                        ?></textarea>
                                </div>
                            </div>
                            @endif
                        </div>

                        @if(!isset($customer))
                        <div class="container-fluid w-100">
                            <a href="javascript:void(0)" class="btn btn-success float-right" id="dynamic_add"><i
                                    class="mdi mdi-plus"></i></a>
                        </div>
                        @endif
                        <!-- <button type="submit" class="btn btn-primary mr-2">Submit</button> -->
                        @if(isset($customer))
                        @else
                        <input type="submit" class="btn btn-primary mr-2 mt-5 "
                            value="{{ isset($customer)?'Edit':'Add'}}">
                        @endif
                        <!-- <button class="btn btn-light">Cancel</button> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->

<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" crossorigin="anonymous"> -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> -->



<script>
$(document).ready(function() {
    $("#sale_dt").datepicker({
        format: 'dd-mm-yyyy',
        orientation: 'bottom',
        autoclose: true,
        endDate: new Date()
    });
    // console.log("ready!");

});


var count = 20;
var x = $('#tableDiv > div').length;
// alert(x);
$('#dynamic_add').click(function() {
    // alert('hii')
    // var total = parseInt($('#tot_memb').val());
    if (x < count) {
        if ($('#mc_type_' + x).val() != '') {
            x++;

            $('#tableDiv').append('<hr id="hr_' + x + '"><div class="form-group row" id="row_' + x + '">' +
                '<div class="container-fluid w-100"><button type="button" id="remove_' + x +
                '" class="btn btn-danger btn-rounded btn-icon float-right" onclick="_delete(' + x +
                ')"><i class="mdi mdi-delete"></i></button></div>' +
                '<div class="col-6 grid-margin"><label>Item</label><Select class="form-control" name="mc_type[]" id="mc_type_' +
                x + '" required><option value=""> -- Select Item -- </option>' +
                '<?php foreach($machines as $machine){
                    echo "<option value=".$machine->mc_id.">".$machine->mc_type."</option>";
                }?>' +
                '</Select></div>' +
                '<div class="col-6 grid-margin"><label for="">Version</label><Select class="form-control" name="mc_ver[]" id="mc_ver_' +
                x + '" required><option value=""> -- Select Version -- </option>' +
                '<?php foreach($versions as $version){
                    echo "<option value=".$version->sl_no.">".$version->version_name."</option>";
                }?>' +
                '</Select></div>' +
                '<div class="col-6 grid-margin"><label for="">Quantity</label><input type="number" class="form-control" name="mc_qty[]" id="mc_qty_' +
                x + '" required " placeholder="Quantity"></div>' +
                '<div class="col-6 grid-margin"><label for="">Warranty Period</label><input type="number" class="form-control" name="warr_prd[]" id="warr_prd_' +
                x + '" required " placeholder="(In Months)"></div>' +
                '<div class="col-6 grid-margin"><label for="">Sl.No.From</label><input type="number" class="form-control" name="sl_frm[]" id="sl_frm_' +
                x + '" value="0" placeholder=""></div>' +
                '<div class="col-6 grid-margin"><label for="">Sl.No.To</label><input type="number" class="form-control" name="sl_to[]" id="sl_to_' +
                x + '" value="0" placeholder=""></div>' +
                '<div class="col-12"><label for="">Sl.No.</label><textarea class="form-control" name="c_sl[]" id="c_sl_' +
                x + '"></textarea></div>' +
                '</div>');
            // <tr id="row_' + x + '">' +
            //     '<td class="text-left">' + x + '</td>' +
            //     '<td><input type="number" class="form-control" name="c_sl[]" id="c_sl_' + x +
            //     '" placeholder=""></td>' +
            //     '<td><button type="button" id="remove_' + x +
            //     '" class="btn btn-danger btn-rounded btn-icon" onclick="_delete(' + x +
            //     ')"><i class="mdi mdi-delete"></i></button></td>' +
            //     '</tr>');
            // var y = x-1;

            // $('#tot_shg').val(y);
            // $('#tot_memb').val(total);

            // pack_size_
            // brand_name_

        } else {
            alert('Please Select an item.');
            // alert('Please Fill All Details');
            return false;
        }

        // $('#brand_name_' + x).on('change', function() {
        //     // alert('hii');
        //     var val = $('#brand_name_' + x).val();
        //     // alert(val)
        //     brandName(val, x);
        // })

        $('#pack_size_' + x).on('change', function() {
            // alert('hii');
            var val = $('#pack_size_' + x).val();
            // alert(val)
            brandName(val, x);
        })

        // $('#quantity_'+x).on('change', function() {
        //     Quantity(x);
        // })

    }
});


function _delete(id) {
    var r = confirm("Do you want to delete this?");
    if (r == true) {
        $('#row_' + id).remove();
        $('#hr_' + id).remove();
        // $('#rowHr_' + id).remove();
        x--;
    } else {
        return false;
    }
}
</script>
@endsection