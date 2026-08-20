@extends('common.master')
@section('content')

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Search</h4>
                    <form class="form-sample" action="{{route('reports.warrantystatusp')}}" method="get">
                        <!-- <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">First Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Last Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="text" name="sl_no" required id="sl_no"
                                            value="{{isset($sl_no)?$sl_no:''}}" placeholder="Sl No." class="form-control">
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
        </div>
    </div>
    @if($sl_no!='')
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <h4 class="mt-1 mb-1">
                            Warranty Status
                        </h4>
                        <a href="javascript:void(0);" id="print" class="btn btn-info d-none d-md-block">Print</a>

                    </div>

                    <div class="row" id="divToPrint">
                        <div class="col-12">
                            <div class="table-responsive">
                                @if(!empty($alldatas) && count($alldatas) > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Make</th>
                <th>Service Centre</th>
                <th>Machine Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alldatas as $type)
                <tr>
                    <td>{{ $type->make_name ?? '-' }}</td>
                    <td>{{ $type->center_name ?? '-' }}</td>
                    <td>{{ $type->mc_name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <table class="table">
        <thead>
            <tr>
                <th>Invoice No.</th>
                <th>Arrival Date</th>
                <th>Warranty Period</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alldatas as $type)
                <tr>
                    <td>{{ $type->bill_no ?? '-' }}</td>
                    <td>{{ !empty($type->arrival_dt) ? date('d-m-Y', strtotime($type->arrival_dt)) : '-' }}</td>
                    <td>
                        {{ !empty($type->amc_from) && !empty($type->amc_to) 
                            ? date('d-m-Y', strtotime($type->amc_from)) . ' - ' . date('d-m-Y', strtotime($type->amc_to)) 
                            : '-' 
                        }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No data found</p>
@endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>


@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />

<!-- <script src="{{asset('public/datepicker/bootstrap-datepicker.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('public/datepicker/bootstrap-datepicker.min.css')}}"> -->
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
</script>


<script>
$(document).ready(function() {

    $('#print').click(function() {

        printDiv();

    });

    function printDiv() {

        var divToPrint = document.getElementById('divToPrint');

        var WindowObject = window.open('', 'Print-Window');
        WindowObject.document.open();
        WindowObject.document.writeln('<!DOCTYPE html>');
        WindowObject.document.writeln('<html><head><title></title><style type="text/css">');


        WindowObject.document.writeln('@media print { .center { text-align: center;}' +
            '                                         .inline { display: inline; }' +
            '                                         .underline { text-decoration: underline; }' +
            '                                         .left { margin-left: 315px;} ' +
            '                                         .right { margin-right: 375px; display: inline; }' +
            '                                          table { border-collapse: collapse; }' +
            '                                          th, td { border: 1px solid black; border-collapse: collapse; padding: 10px;}' +
            '                                           th, td { }' +
            '                                         .border { border: 1px solid black; } ' +
            '                                         .bottom { bottom: 5px; width: 100%; position: fixed ' +
            '                                       ' +
            '                                   } } </style>');
        // WindowObject.document.writeln('<style type="text/css">@media print{p { color: blue; }}');
        WindowObject.document.writeln('</head><body onload="window.print()">');
        WindowObject.document.writeln(divToPrint.innerHTML);
        WindowObject.document.writeln('</body></html>');
        WindowObject.document.close();
        setTimeout(function() {
            WindowObject.close();
        }, 10);

    }

});
</script>
@endsection