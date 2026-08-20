@extends('common.master')
@section('content')

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Search</h4>
                    <form class="form-sample" action="{{route('reports.deviceledgerbranch')}}">
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
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="text" name="from_dt" required id="from_dt"
                                            value="{{isset($from_dt)?$from_dt:date('d-m-Y')}}" placeholder="DD-MM-YYYY"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="text" name="to_dt" required id="to_dt"
                                            value="{{isset($to_dt)?$to_dt:date('d-m-Y')}}" placeholder="DD-MM-YYYY"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <select class="form-control" name="device_desc" id="device_desc" required>
                                            <option value=""> -- Select Device Name -- </option>
                                            @foreach($machines as $machine)
                                            <option value="{{$machine->mc_id}}" <?php if(isset($device_desc) && $device_desc==$machine->mc_id){echo "selected";}?>>{{$machine->mc_type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <select class="form-control" name="srv_ctr" id="srv_ctr" required>
                                            <option value=""> -- Select Service Center -- </option>
                                            @foreach($service_centres as $service_centre)
                                            <option value="{{$service_centre->sl_no}}" <?php if(isset($srv_ctr) && $srv_ctr==$service_centre->sl_no){echo "selected";}?>>{{$service_centre->center_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
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
    @if($from_dt!='' && $to_dt!='')
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <h4 class="mt-1 mb-1">
                           
                            Device Stock Ledger Between {{$from_dt}} To {{$to_dt}} 
                           
                        </h4>
                        <p class="mt-1 mb-1">
                           
                        Device : {{$device_name}}
                           </p>
                        <a href="javascript:void(0);" id="print" class="btn btn-info d-none d-md-block">Print</a>

                    </div>

                    <div class="row" id="divToPrint">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Bill No.	</th>
                                            <th>Customer</th>
                                            <th>Remarks</th>
                                            <th>Quantity</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>{{date('d-m-Y',strtotime($opening[0]['date']))}}</td>
                                            <td>{{"Opening Balance"}}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php 
                                            $totalbal=0;
                                            foreach ($opening as $key => $value) {
                                                $totalbal += $value->total_qty;
                                            }
                                            echo $totalbal;
                                            ?></td>
                                            <td>{{ $totalbal}}</td>
                                            </td>

                                        </tr>
                                        @for ($i=0; $i < count($alldatas); $i++)
                                        <tr>
                                            <td>{{ date('d-m-Y',strtotime($alldatas[$i]->arrival_dt))}}</td>
                                            <td><?php if($alldatas[$i]->trans_type=="I"){
                                                         echo "In";
                                                      }elseif($alldatas[$i]->trans_type=="T"){
                                                         echo "Transfer Out";
                                                      }elseif($alldatas[$i]->trans_type=="O"){
                                                         echo "Opening Balance";
                                                      }elseif($alldatas[$i]->trans_type=="S"){
                                                         echo "Sale Out";
                                                      }else{
                                                         echo "Damage Out";   
                                                      } 
                                                ?></td>
                                            <td>{{$alldatas[$i]->bill_no}}</td>
                                            <td>{{$alldatas[$i]->cust_name}}</td>
                                            <td>{{$alldatas[$i]->remarks}}</td>
                                            <td>{{$alldatas[$i]->mc_qty}}</td>
                                            <td><?php 
                                              echo  $totalbal +=$alldatas[$i]->mc_qty;
                                            ?></td>
                                        </tr>
                                        @endfor
                                    </tbody>
                                </table>
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