@extends('common.master')
@section('content')

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 grid-margin">
                    <h4 class="card-title">Search</h4>
                    <form class="form-sample" action="{{route('deviceSale')}}">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="text" name="from_dt" required id="from_dt"
                                            value="{{isset($from_dt)?$from_dt:''}}" placeholder="DD-MM-YYYY"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="text" name="to_dt" required id="to_dt"
                                            value="{{isset($to_dt)?$to_dt:''}}" placeholder="DD-MM-YYYY"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="submit" class="btn btn-primary mb-2" value="Search">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!-- <h4 class="card-title">Liquor Type</h4> -->
            <!-- <button class="btn btn-info d-none d-md-block">Import</button> -->
            <div class="card-body d-flex align-items-center justify-content-between">
                <h4 class="mt-1 mb-1">Device Sale</h4>
                <!-- <h4 class="mt-1 mb-1">Hi, Welcomeback!</h4> -->
                <!-- <button class="btn btn-info d-none d-md-block">Import</button> -->
                <a href="{{route('deviceSaleadd')}}" class="btn btn-info d-none d-md-block">Add</a>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th> #</th>
                                    <th>Date</th>
                                    <th>Transaction No.</th>
                                    <th>Invoice No.</th>
                                    <!-- <th>Item</th> -->
                                    <!-- <th>Quantity</th> -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($device_sale as $type)
                                <tr id="tr_{{$type->sl_no}}">
                                    <td>{{$i++}}</td>
                                    <td>{{date('d-m-Y',strtotime($type->trans_dt))}}</td>
                                    <td>{{$type->trans_no}}</td>
                                    <td>{{$type->bill_no}}</td>
                                    <!-- <td>{{$type->mc_name}}</td> -->
                                    <!-- <td>{{abs($type->mc_qty)}}</td> -->
                                    <td>
                                        <a href="{{route('deviceSaleedit',['trans_dt'=>$type->trans_dt,'trans_no'=>$type->trans_no])}}"
                                            title="View"><i class="mdi mdi-eye" style="font-size: 25px;"></i></a>
                                        <a href="javascript:void(0)"
                                            onclick="Delete('{{$type->trans_dt}}',{{$type->trans_no}},{{$type->sl_no}});"
                                            title="Edit"><i class="mdi mdi-delete "
                                                style="font-size: 25px;color:#e32727;"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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

<script>
$(document).ready(function() {
    $("#from_dt").datepicker({
        format: 'dd-mm-yyyy',
        orientation: 'bottom',
        autoclose: true,
        endDate: new Date()
    });
    $("#to_dt").datepicker({
        format: 'dd-mm-yyyy',
        orientation: 'bottom',
        autoclose: true,
        endDate: new Date()
    });
    // console.log("ready!");

});

function Delete(trans_dt, trans_no, sl_no) {
    // alert(id);
    if (window.confirm('Are you sure you want to delete this record?')) {
        $.ajax({
            url: "{{route('deviceSaledelete')}}",
            method: "POST",
            data: {
                trans_dt: trans_dt,
                trans_no: trans_no
            },
            success: function(data) {
                // alert(data);
                var obj = JSON.parse(data);
                $('#tr_' + sl_no).remove();
            }
        });
    }

}
</script>
@endsection