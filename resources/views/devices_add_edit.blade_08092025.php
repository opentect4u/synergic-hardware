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
                        action="{{ isset($customer)?route('deviceseditconfirm'):route('devicesadd')}}">
                        @csrf
                        <input type="text" hidden name="id" id="id" value="{{isset($customer)?$customer->sl_no:''}}">
                        <input type="text" hidden name="trans_type_id" id="trans_type_id" value="{{isset($customer)?$customer->trans_type:''}}">
                        <div class="form-group">
                            <label for="exampleInputName1"> Type </label>
                            <select class="form-control" required name="trans_type" id="trans_type" <?php if(isset($customer)){echo "disabled";}?>>
                                <option value="">--Select Device Type--</option>
                                <option value="I"
                                    <?php if(isset($customer) && $customer->trans_type=='I'){echo "selected";}?>>
                                    Purchase</option>
                                <option value="T"
                                    <?php if(isset($customer) && $customer->trans_type=='T'){echo "selected";}?>>
                                    Transfer</option>
                                <option value="D"
                                    <?php if(isset($customer) && $customer->trans_type=='D'){echo "selected";}?>>Damage
                                </option>
                            </select>
                        </div>
                        <div id="PurchaseDiv">
                            <div class="form-group">
                                <label for="exampleInputName1"> Arrival Date </label>
                                <input type="text" class="form-control" name="arrival_dt" id="arrival_dt"
                                    placeholder="DD-MM-YYYY"
                                    value="{{isset($customer)?date('d-m-Y',strtotime($customer->arrival_dt)):''}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Bill No.</label>
                                <input type="text" class="form-control" name="bill_no" id="bill_no"
                                    value="{{isset($customer)?$customer->bill_no:''}}" placeholder="Bill No.">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Make</label>
                                <Select class="form-control" name="make" id="make">
                                    <option value=""> -- Select Make -- </option>
                                    @foreach($mdmakes as $mdmake)
                                    <option value="{{$mdmake->sl_no}}" <?php if(isset($customer) && $customer->make==$customer->make){echo "selected";}?>>{{$mdmake->name}}</option>
                                    @endforeach
                                </Select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Service Center</label>
                                <Select class="form-control" name="srv_ctr" id="srv_ctr">
                                    <option value=""> -- Select Service Center -- </option>
                                    @foreach($serviceCenter as $serviceCenters)
                                    <option value="{{$serviceCenters->sl_no}}"
                                        <?php if(isset($customer) && $customer->serv_ctr==$serviceCenters->sl_no){echo "selected";}?>>
                                        {{$serviceCenters->center_name}}</option>
                                    @endforeach
                                </Select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Remarks</label>
                                <textarea class="form-control" name="remarks" id="remarks" cols="30"
                                    rows="5">{{isset($customer)?$customer->remarks:''}}</textarea>
                            </div>
                        </div>
                        <div id="TransferDiv">
                            <div class="form-group">
                                <label for="exampleInputName1">Transfer No.</label>
                                <input type="text" class="form-control" name="trf_no" id="bill_no"
                                    value="{{isset($customer)?$customer->bill_no:''}}" <?php if(isset($customer)){echo "readonly";}?> placeholder="Bill No.">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Transfer Mode</label>
                                <Select class="form-control required" name="trf_mode" id="trf_mode">
                                    <option value="C" <?php if(isset($customer) && $customer->trf_mode=='C'){echo "selected";}?>>Courier</option>
                                    <option value="T" <?php if(isset($customer) && $customer->trf_mode=='T'){echo "selected";}?>>Transport</option>
                                    <option value="M" <?php if(isset($customer) && $customer->trf_mode=='M'){echo "selected";}?>>Manual</option>
                                </Select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Service Center From</label>
                                <Select class="form-control" name="srv_ctr_from" id="srv_ctr_from" <?php if(isset($customer)){echo "disabled";}?>>
                                    <option value=""> -- Select Service Center -- </option>
                                    @foreach($serviceCenter as $serviceCenters)
                                    <option value="{{$serviceCenters->sl_no}}" <?php if(isset($customer) && $customer->serv_ctr==$serviceCenters->sl_no){echo "selected";}?>>{{$serviceCenters->center_name}}</option>
                                    @endforeach
                                </Select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Service Center To</label>
                                <Select class="form-control" name="srv_ctr_to" id="srv_ctr_to" <?php if(isset($customer)){echo "disabled";}?>>
                                    <option value=""> -- Select Service Center -- </option>
                                    @foreach($serviceCenter as $serviceCenters)
                                    <option value="{{$serviceCenters->sl_no}}" <?php if(isset($customer) && $customer->srv_to==$serviceCenters->sl_no){echo "selected";}?>>{{$serviceCenters->center_name}}</option>
                                    @endforeach
                                </Select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Remarks</label>
                                <textarea class="form-control" name="remarks" id="remarks" cols="30"
                                    rows="5">{{isset($customer)?$customer->remarks:''}}</textarea>
                            </div>
                        </div>
                        <div id="DamageDiv"></div>
                        @if(isset($customer))
                            @if($customer->trans_type=='T')
                            <div class="container-fluid d-flex justify-content-center w-100">
                                <div class="table-responsive w-100">
                                    <table class="table" id="tableDiv">
                                        <thead>
                                            <tr class="bg-dark text-white">
                                                <th>&nbsp;</th>
                                                <th>Device</th>
                                                <th class="text-right">Quantity</th>
                                                <th class="text-right">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            @foreach($allcustomer as $allcustomers)
                                            <tr class="text-right" id="row_1">
                                                <td class="text-left"><?php 
                                                if($allcustomers->trans_type=='I'){
                                                    echo "Purchase";
                                                }elseif ($allcustomers->trans_type=='T') {
                                                    echo "Transfer";
                                                }
                                                ?></td>
                                                <input type="text" hidden name="ids[]" id="ids_" value="{{$allcustomers->sl_no}}">
                                                <td class="text-left dropDownCus">
                                                    <select class="form-control" name="mc_type[]" id="mc_type_1" required>
                                                        <option value=""> -- Select Device -- </option>
                                                        @foreach($machines as $machine)
                                                        <option value="{{$machine->mc_id}}"
                                                            <?php if( $allcustomers->mc_type==$machine->mc_id){echo "selected";}?>>
                                                            {{$machine->mc_type}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="text-left"><input type="number" class="form-control"
                                                        name="mc_qty[]" id="mc_qty_1" placeholder="Quantity" required
                                                        value="{{str_replace('-','',$allcustomers->mc_qty)}}"></td>

                                                <td>&nbsp;</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @else
                            <div class="container-fluid d-flex justify-content-center w-100">
                                <div class="table-responsive w-100">
                                    <table class="table" id="tableDiv">
                                        <thead>
                                            <tr class="bg-dark text-white">
                                                <!-- <th>&nbsp;</th> -->
                                                <th>Device</th>
                                                <th>Quantity</th>
                                                <th>Serial No</th>
                                                <th class="text-right">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            @foreach($allcustomer as $allcustomers)
                                            <tr class="text-right" id="row_1">
                                                <!-- <td class="text-left"></td> -->
                                                <input type="text" hidden name="ids[]" id="ids_" value="{{$allcustomers->sl_no}}">
                                                <td class="text-left dropDownCus">
                                                    <select class="form-control" name="mc_type[]" id="mc_type_1" required>
                                                        <option value=""> -- Select Device -- </option>
                                                        @foreach($machines as $machine)
                                                        <option value="{{$machine->mc_id}}"
                                                            <?php if( $allcustomers->mc_type==$machine->mc_id){echo "selected";}?>>
                                                            {{$machine->mc_type}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="text-left"><input type="number" class="form-control"
                                                        name="mc_qty[]" id="mc_qty_1" placeholder="Quantity" required
                                                        value="{{str_replace('-','',$allcustomers->mc_qty)}}"></td>
                                                <td>
                                                    {{ optional($device_amc->firstWhere('mc_type', $allcustomers->mc_type))->sl_nos ?? 'No Serial Numbers Found' }}

                                                   
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        @else
                        <div class="container-fluid d-flex justify-content-center w-100">
                            <div class="table-responsive w-100">
                                <table class="table" id="tableDiv">
                                    <thead>
                                        <tr class="bg-dark text-white">
                                            <th>#</th>
                                            <th>Device</th>
                                            <th>Quantity</th>
                                            <th>Warranty(IN MONTH)</th>
                                            <th>Sl.No.From</th>
                                            <th>Sl.No.To</th>
                                            <th>Sl.No. (E.x.- 111,222,333)</th>
                                            <th class="text-right">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">
                                        <tr class="text-right" id="row_1">
                                            <td class="text-left">1</td>
                                            <td class="text-left dropDownCus">
                                                <select class="form-control" name="mc_type[]" id="mc_type_1" required>
                                                    <option value=""> -- Select Device -- </option>
                                                    @foreach($machines as $machine)
                                                    <option value="{{$machine->mc_id}}"
                                                        <?php if(isset($customer) && $customer->mc_type==$machine->mc_id){echo "selected";}?>>
                                                        {{$machine->mc_type}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="text-left"><input type="number" class="form-control"
                                                    name="mc_qty[]" id="mc_qty_1" placeholder="Quantity" required
                                                    value="{{isset($customer)?str_replace('-','',$customer->mc_qty):''}}"></td>
                                             <td><input type="number" class="form-control" name="warr_prd[]" id="warr_prd_1"  value=""  placeholder=""> </td>
                                             <td><input type="number" class="form-control" name="sl_frm[]" id="sl_frm_1"  value=""  placeholder=""> </td>
                                             <td><input type="number" class="form-control" name="sl_to[]" id="sl_to_1"  value=""  placeholder=""> </td>
                                             <td><input type="text" class="form-control" name="c_sl[]" id="c_sl_1"  value=""  placeholder=""> </td>       

                                            <td>&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        @if(!isset($customer))
                        <div class="container-fluid w-100">
                            <a href="javascript:void(0)" class="btn btn-success float-right" id="dynamic_add"><i
                                    class="mdi mdi-plus"></i></a>
                        </div>
                        @endif
                        <!-- <button type="submit" class="btn btn-primary mr-2">Submit</button> -->
                         @if(!isset($customer))
                         <input type="submit" class="btn btn-primary mr-2 mt-5" value="Submit">
                         @endif
                        <!-- <input type="submit" class="btn btn-primary mr-2 mt-5 "
                            value="{{ isset($customer)?'Edit':'Add'}}"> -->
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
    $("#arrival_dt").datepicker({
        format: 'dd-mm-yyyy',
        orientation: 'bottom',
        autoclose: true,
        endDate: new Date()
    });
    // console.log("ready!");
    var trans_type = '<?php if(isset($customer)){ echo $customer->trans_type; }?>';
    // alert(trans_type)
    if (trans_type == 'I') {
        $('#PurchaseDiv').show();
        $('#TransferDiv').empty();
        $('#DamageDiv').empty();
    } else if (trans_type == 'T') {
        $('#TransferDiv').show();
        $('#PurchaseDiv').empty();
        $('#DamageDiv').empty();
    } else if (trans_type == 'D') {
        $('#DamageDiv').show();
        $('#PurchaseDiv').empty();
        $('#TransferDiv').empty();
    } else {
        $('#PurchaseDiv').hide();
        $('#TransferDiv').hide();
        $('#DamageDiv').hide();
    }
    $('#trans_type').on('change', function() {
        if ($('#trans_type').val() == 'I') {
            $('#PurchaseDiv').show();
            $('#TransferDiv').hide();
            $('#DamageDiv').hide();
        } else if ($('#trans_type').val() == 'T') {
            $('#TransferDiv').show();
            $('#PurchaseDiv').hide();
            $('#DamageDiv').hide();
        } else if ($('#trans_type').val() == 'D') {
            $('#DamageDiv').show();
            $('#PurchaseDiv').hide();
            $('#TransferDiv').hide();
        }
    })
});


var count = 20;
// var x = $('#table tbody > tr').length;
var x = $('#tableDiv > tbody > tr').length;
// alert(x);
$('#dynamic_add').click(function() {
    // alert('hii')
    // var total = parseInt($('#tot_memb').val());
    if (x < count) {
        if ($('#mc_type_' + x).val() != '' && $('#mc_qty_' + x).val() != '') {
            x++;

            $('#tbody').append('<tr id="row_' + x + '">' +
                '<td class="text-left">' + x + '</td><td class="text-left dropDownCus">' +
                '<select class="form-control" name="mc_type[]" id="mc_type_' + x +
                '" required "><option value=""> -- Select Device -- </option>' +
                '<?php 
            foreach($machines as $liquor){
               echo "<option value=".$liquor->mc_id.">".$liquor->mc_type."</option>"; 
            }
            ?>' +
                '</select></td>' +
                '<td><input type="number" class="form-control" name="mc_qty[]" id="mc_qty_' + x +
                '" placeholder="Quantity"></td>' +
                 '<td><input type="number" class="form-control" name="warr_prd[]" id="warr_prd_' + x +
                '" placeholder=""></td>' +
                '<td><input type="number" class="form-control" name="sl_frm[]" id="sl_frm_' + x +
                '" placeholder=""></td>' +
                '<td><input type="number" class="form-control" name="sl_to[]" id="sl_to_' + x +
                '" placeholder=""></td>' +
                '<td><input type="text" class="form-control" name="c_sl[]" id="c_sl_' + x +
                '" placeholder=""></td>' +
                '<td><button type="button" id="remove_' + x +
                '" class="btn btn-danger btn-rounded btn-icon" onclick="_delete(' + x +
                ')"><i class="mdi mdi-delete"></i></button></td>' +
                // '<td><button type="button" id="remove_' + x +
                // '" class="btn btn-danger btn-rounded btn-icon" onclick="_delete(' + x +
                // ')"><i class="mdi mdi-delete"></i></button></td>' +
                '</tr>');
            // var y = x-1;
           
            $("#mc_type_" + x).select2();

        } else {
            alert('Please Fill the brand name');
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
        // $('#rowHr_' + id).remove();
        x--;
        var count = $('#tableDiv > tbody > tr').length;
        // alert(count);
        var totamount = 0;
        for (let index = 1; index <= count; index++) {
            totamount = Number(totamount) + Number($('#amount_' + index).val());
        }
        // alert(totamount);
        $('#subtotal').empty();
        $('#subtotal').append(totamount);
    } else {
        return false;
    }
}
</script>
@endsection