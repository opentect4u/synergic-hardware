@extends('common.master')
@section('content')
<style>
.amc-report-table {
    width: 100%;
    table-layout: fixed;
}

.amc-report-table th,
.amc-report-table td {
    max-width: 40ch;
    white-space: normal;
    overflow-wrap: anywhere;
    word-break: break-word;
}
</style>
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <h4 class="mt-1 mb-1">Warranty Status (Purchase) - Current Month</h4>
                        <a href="javascript:void(0);" id="print" class="btn btn-info d-none d-md-block">Print</a>
                    </div>

                    <div class="row" id="divToPrint">
                        <div class="col-12">
                            <div class="table-responsive">
                                @if($alldatas->isNotEmpty())
                                <table class="table amc-report-table">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Make</th>
                                            <th>Service Centre</th>
                                            <th>Machine Name</th>
                                            <th>Invoice No.</th>
                                            <th>Arrival Date</th>
                                            <th>Warranty Period</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($alldatas as $index => $type)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $type->make_name ?? '-' }}</td>
                                            <td>{{ $type->center_name ?? '-' }}</td>
                                            <td>{{ $type->mc_name ?? '-' }}</td>
                                            <td>{{ $type->bill_no ?? '-' }}</td>
                                            <td>{{ !empty($type->arrival_dt) ? date('d-m-Y', strtotime($type->arrival_dt)) : '-' }}</td>
                                            <td>{{ !empty($type->amc_from) && !empty($type->amc_to) ? date('d-m-Y', strtotime($type->amc_from)) . ' - ' . date('d-m-Y', strtotime($type->amc_to)) : '-' }}</td>
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
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    $('#print').click(function() {
        var divToPrint = document.getElementById('divToPrint');
        var windowObject = window.open('', 'Print-Window');
        windowObject.document.open();
        windowObject.document.writeln('<!DOCTYPE html><html><head><title></title><style>@media print { table { border-collapse: collapse; } th, td { border: 1px solid black; padding: 10px; } }</style></head><body onload="window.print()">');
        windowObject.document.writeln(divToPrint.innerHTML);
        windowObject.document.writeln('</body></html>');
        windowObject.document.close();
        setTimeout(function() { windowObject.close(); }, 10);
    });
});
</script>
@endsection
