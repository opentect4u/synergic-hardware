@extends('common.master')
@section('content')

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Service Centre {{ isset($customer)?'Edit':'Add'}}</h4>
                    @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">Service Centre updated successfully.</div>
                    @endif
                    <!-- <p class="card-description">
                        Basic form elements
                    </p> -->
                    <form class="forms-sample" method="post"
                        action="{{ isset($customer)?route('serviceCentreeditconfirm'):route('serviceCentreadd')}}">
                        @csrf
                        <input type="text" hidden name="id" id="id" value="{{isset($customer)?$customer->sl_no:''}}">

                        <div class="form-group">
                            <label for="exampleInputName1">Name</label>
                            <input type="text" class="form-control" required name="center_name" id="center_name"
                                value="{{isset($customer)?$customer->center_name:''}}" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Phone No.</label>
                            <input type="text" class="form-control" required name="cnct_no" id="cnct_no"
                                value="{{isset($customer)?$customer->cnct_no:''}}" placeholder="Phone No.">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Email</label>
                            <input type="email" class="form-control" required name="email" id="email"
                                value="{{isset($customer)?$customer->email:''}}" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">In Charge</label>
                            <input type="text" class="form-control" required name="in_charge" id="in_charge"
                                value="{{isset($customer)?$customer->in_charge:''}}" placeholder="In Charge">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Address</label>
                            <textarea class="form-control" name="address" id="address" cols="30" rows="10"
                                placeholder="Address">{{isset($customer)?$customer->address:''}}</textarea>
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