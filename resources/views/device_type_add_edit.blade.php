@extends('common.master')
@section('content')

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Device Type {{ isset($customer)?'Edit':'Add'}}</h4>
                    @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">Device Type updated successfully.</div>
                    @endif
                    <!-- <p class="card-description">
                        Basic form elements
                    </p> -->
                    <form class="forms-sample" method="post"
                        action="{{ isset($customer)?route('deviceTypeeditconfirm'):route('deviceTypeadd')}}">
                        @csrf
                        <input type="text" hidden name="id" id="id" value="{{isset($customer)?$customer->mc_id:''}}">
                        <div class="form-group">
                            <label for="exampleInputName1">Device Type </label>
                            <select class="form-control" required name="dev_type" id="dev_type">
                                <option value="">--Select Device Type--</option>
                                <option value="B" <?php if(isset($customer) && $customer->dev_type=='B'){echo "selected";}?>>ETIM Banking & Others</option>
                                <option value="L" <?php if(isset($customer) && $customer->dev_type=='L'){echo "selected";}?>>Billing Machine</option>
                                <option value="P" <?php if(isset($customer) && $customer->dev_type=='P'){echo "selected";}?>>Printer</option>
                                <option value="O" <?php if(isset($customer) && $customer->dev_type=='O'){echo "selected";}?>>Others</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Device Name</label>
                            <input type="text" class="form-control" required name="mc_type" id="mc_type"
                                value="{{isset($customer)?$customer->mc_type:''}}" placeholder="Device Name">
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