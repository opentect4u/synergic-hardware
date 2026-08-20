@extends('common.master')
@section('content')

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <!-- <h4 class="card-title">Liquor Type</h4> -->
            <!-- <button class="btn btn-info d-none d-md-block">Import</button> -->
            <div class="card-body d-flex align-items-center justify-content-between">
                <h4 class="mt-1 mb-1">Device Types</h4>
                <!-- <h4 class="mt-1 mb-1">Hi, Welcomeback!</h4> -->
                <!-- <button class="btn btn-info d-none d-md-block">Import</button> -->
                <a href="{{route('deviceTypeadd')}}" class="btn btn-info d-none d-md-block">Add</a>
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
                                @foreach($device_type as $type)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td><?php if($type->dev_type=='L'){
                                                    echo $devType = "Billing Machine";
                                                }elseif($type=='P'){
                                                    echo $devType = "Printer";
                                                }elseif($type=='B'){
                                                    echo $devType = "Banking & Others";
                                                }else{
                                                    echo $devType = "Others";
                                                }?></td>
                                    <td>{{$type->mc_type}}</td>
                                    <td>
                                        <a href="{{route('deviceTypeedit',['id'=>$type->mc_id])}}" title="Edit"><i class="mdi mdi-table-edit"></i></a>
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