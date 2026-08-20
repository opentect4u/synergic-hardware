@extends('common.master')
@section('content')

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <!-- <h4 class="card-title">Liquor Type</h4> -->
            <!-- <button class="btn btn-info d-none d-md-block">Import</button> -->
            <div class="card-body d-flex align-items-center justify-content-between">
                <h4 class="mt-1 mb-1">Technician</h4>
                <!-- <h4 class="mt-1 mb-1">Hi, Welcomeback!</h4> -->
                <!-- <button class="btn btn-info d-none d-md-block">Import</button> -->
                <a href="{{route('technicianadd')}}" class="btn btn-info d-none d-md-block">Add</a>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th> #</th>
                                    <th>Employee No.</th>
                                    <th>Name</th>
                                    <th>Contact No.</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($technician as $type)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$type->emp_code}}</td>
                                    <td>{{$type->tech_name}}</td>
                                    <td>{{$type->tech_ph}}</td>
                                    <td>
                                        <a href="{{route('technicianedit',['id'=>$type->emp_code])}}" title="Edit"><i class="mdi mdi-table-edit"></i></a>
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