@extends('common.master')
@section('content')

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <!-- <h4 class="card-title">Liquor Type</h4> -->
            <!-- <button class="btn btn-info d-none d-md-block">Import</button> -->
            <div class="card-body d-flex align-items-center justify-content-between">
                <h4 class="mt-1 mb-1"> Devices</h4>
                <!-- <h4 class="mt-1 mb-1">Hi, Welcomeback!</h4> -->
                <!-- <button class="btn btn-info d-none d-md-block">Import</button> -->
                <a href="{{route('devicesadd')}}" class="btn btn-info d-none d-md-block">Add</a>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th> #</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>No.</th>
                                    <th>Service Center</th>
                                    <!-- <th>Device Name</th> -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($devices as $type)

                                <tr id="tr_{{$type->sl_no}}">
                                    <td>{{$i++}}</td>
                                    <td>{{date('d/m/Y',strtotime($type->arrival_dt))}}</td>
                                    <td><?php if($type->trans_type=='I'){
                                                   echo $typeDesc = "Purchase";
                                                //    $path     = "editDevIn.php";     
                                                }elseif($type->trans_type=='T'){
                                                   echo $typeDesc = "Transfer"; 
                                                //    $path     = "../transfer/editDevTrf.php";
                                                }else{
                                                    echo $typeDesc = "Damage";
                                                    // $path     = "../damage/editDeviceDamage.php";
                                                }?></td>
                                    <td>{{$type->bill_no}}</td>
                                    <td>{{$type->center_name}}</td>
                                    <!-- <td>{{$type->mc_name}}</td> -->
                                    <td>
                                        <a href="{{route('devicesedit',['trans_dt'=>$type->trans_dt,'trans_no'=>$type->trans_no])}}" title="Edit"><i
                                                class="mdi mdi-table-edit" style="font-size: 25px;"></i></a>
                                        &nbsp;
                                        <a href="javascript:void(0)" onclick="Delete('{{$type->trans_dt}}',{{$type->trans_no}},{{$type->sl_no}});" title="Delete"><i class="mdi mdi-delete"
                                                style="font-size: 25px; color:#e53535;"></i></a>
                                                <!-- "trans_dt": "2022-05-19","trans_no": 1, -->
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

<script>
$(document).ready(function() {
    // $('#dta').DataTable();
    $('#del').click(function() {
        if (window.confirm('Are you sure you want to delete this record?')) {
        }

    });
});

function Delete(trans_dt,trans_no,tr_no) {
    // alert(tr_no)
    if (window.confirm('Are you sure you want to delete this record?')) {
        // alert('delete');
        $.ajax({
            url: "{{route('devicesdelete')}}",
            method: "POST",
            data: {
                trans_dt: trans_dt,
                trans_no: trans_no
            },
            success: function(data) {
                // alert(data);
                var obj = JSON.parse(data);
                $('#tr_'+tr_no).remove();
                alert('Successfully Deleted');
            }
        });
    }
}
</script>
@endsection