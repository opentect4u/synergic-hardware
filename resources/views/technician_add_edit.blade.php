@extends('common.master')
@section('content')

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Technician {{ isset($customer)?'Edit':'Add'}}</h4>
                    @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">Technician details updated successfully.</div>
                    @endif
                    <!-- <p class="card-description">
                        Basic form elements
                    </p> -->
                    <form class="forms-sample" method="post"
                        action="{{ isset($customer)?route('technicianeditconfirm'):route('technicianadd')}}">
                        @csrf
                        <!-- <input type="text" hidden name="id" id="id" value="{{isset($customer)?$customer->emp_code:''}}"> -->
                        
                        <div class="form-group">
                            <label for="exampleInputName1">Employee No.</label>
                            <input type="text" class="form-control" required name="emp_code" id="emp_code"
                                value="{{isset($customer)?$customer->emp_code:''}}" {{isset($customer)?'readonly':''}} placeholder="Employee No.">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Description</label>
                            <input type="text" class="form-control" required name="tech_name" id="tech_name"
                                value="{{isset($customer)?$customer->tech_name:''}}" placeholder="Description">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Description</label>
                            <input type="text" class="form-control" required name="tech_ph" id="tech_ph"
                                value="{{isset($customer)?$customer->tech_ph:''}}" placeholder="Description">
                        </div>

                        <!-- <button type="submit" class="btn btn-primary mr-2">Submit</button> -->
                        <input type="submit" class="btn btn-primary mr-2" value="{{ isset($customer)?'Edit':'Add'}}">
                        <!-- <button class="btn btn-light">Cancel</button> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')


@endsection