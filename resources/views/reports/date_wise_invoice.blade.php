@extends('common.master')
@section('content')

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Search</h4>
                    <form class="form-sample" action="{{route('reports.datewiseinvoice')}}">
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
                                        <input type="text" name="from_date" required id="from_date"
                                            value="{{isset($from_date)?$from_date:date('d-m-Y')}}" placeholder="DD-MM-YYYY" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="text" name="to_date" required id="to_date"
                                            value="{{isset($to_date)?$to_date:date('d-m-Y')}}" placeholder="DD-MM-YYYY" class="form-control">
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
    @if($from_date!='' && $to_date!='')
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <h4 class="mt-1 mb-1">
                            Invoice Raised Between : {{$from_date}} To {{$to_date}}
                        </h4>
                        <a href="javascript:void(0);" id="print" class="btn btn-info d-none d-md-block">Print</a>

                    </div>

                    <div class="row" id="divToPrint">
                        <div class="col-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> Sl. No.</th>
                                        <th>Invoice No.</th>
                                        <th>Sale Date</th>
                                        <th>Customer Name</th>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1;?>
                                    @foreach($alldatas as $type)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$type->bill_no}}</td>
                                        <td>{{date('d-m-Y',strtotime($type->arrival_dt))}}</td>
                                        <td>{{$type->cust_name}}</td>
                                        <td>{{$type->version_name}}</td>
                                        <td>{{ABS($type->mc_qty)}}</td>
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
    @endif
</div>


@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
<script>
$(document).ready(function() {
    $("#from_date").datepicker({
        format: 'dd-mm-yyyy',
        orientation: 'bottom',
        autoclose: true,
        // endDate: new Date()
    });
    $("#to_date").datepicker({
        format: 'dd-mm-yyyy',
        orientation: 'bottom',
        autoclose: true,
        // endDate: new Date()
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