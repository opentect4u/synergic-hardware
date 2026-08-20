@extends('common.master')
@section('content')

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <!-- <h4 class="card-title">Liquor Type</h4> -->
            <!-- <button class="btn btn-info d-none d-md-block">Import</button> -->
            <div class="card-body d-flex align-items-center justify-content-between">
                <h4 class="mt-1 mb-1"> Version Type</h4>
                <!-- <h4 class="mt-1 mb-1">Hi, Welcomeback!</h4> -->
                <!-- <button class="btn btn-info d-none d-md-block">Import</button> -->
                <a href="{{route('deviceVersionadd')}}" class="btn btn-info d-none d-md-block">Add</a>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th> #</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($device_version as $type)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td><?php if($type->mc_type=='L'){
                                                    echo $devType = "Billing Machine";
                                                }elseif($type->mc_type=='P'){
                                                    echo $devType = "Printer";
                                                }elseif($type->mc_type=='B'){
                                                    echo $devType = "Banking & Others";
                                                }else{
                                                    echo $devType = "Others";
                                                }?></td>
                                    <td>{{$type->version_name}}</td>
                                    <td>
                                        <a href="{{route('deviceVersionedit',['id'=>$type->sl_no])}}" title="Edit"><i class="mdi mdi-table-edit"></i></a>
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


@endsection