@extends('common.master')
@section('content')

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Customers {{ isset($customer)?'Edit':'Add'}}</h4>
                    @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">Customers updated successfully.</div>
                    @endif
                    <!-- <p class="card-description">
                        Basic form elements
                    </p> -->
                    <form class="forms-sample" method="post" action="{{ isset($customer)?route('customereditconfirm'):route('customeradd')}}"> 
                        @csrf
                        <input type="text" hidden name="id" id="id" value="{{isset($customer)?$customer->cust_cd:''}}">
                        <div class="form-group">
                            <label for="exampleInputName1">Name </label>
                            <input type="text" class="form-control" required name="name"  id="name" value="{{isset($customer)?$customer->cust_name:''}}" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Phone No.</label>
                            <input type="text" class="form-control" required name="phone_no"  id="phone_no" value="{{isset($customer)?$customer->cust_ph_no:''}}" placeholder="Phone No.">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Email</label>
                            <input type="email" class="form-control" name="email"  id="email" value="{{isset($customer)?$customer->cust_email:''}}" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Address</label>
                            <textarea class="form-control" name="address" id="address" required placeholder="Address" cols="30" rows="5">{{isset($customer)?$customer->cust_addr:''}}</textarea>
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