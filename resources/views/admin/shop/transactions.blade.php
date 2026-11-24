@extends('admin.layout')
@section('title','Products')
@push('styles')
    <link href="css/style-responsive.css" rel="stylesheet">
    <link href="css/table-responsive.css" rel="stylesheet">
@endpush
@section('content')

    <section id="main-content">
        <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> {{ $pageTitle   }}</h3>
            <!-- /row -->
{{--            <div class="row d-none mt">--}}
{{--                <form action="" method="get" class="col-md-12">--}}
{{--                    @csrf--}}
{{--                    <div class=" ">--}}
{{--                        <div class="row clearfix">--}}

{{--                            <div class="col-lg-3 col-md-12">--}}
{{--                                <label> Name</label>--}}
{{--                                <div class="multiselect_div">--}}
{{--                                    <input type="text" class="input-sm form-control date" name="name" value="">--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-lg-1 col-md-12">--}}
{{--                                <label>Search</label>--}}
{{--                                <div class="input-group">--}}
{{--                                    <input type="submit" class="btn btn-sm btn-primary" value="Search">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
            <div class="row mt">

                <div class="col-lg-12">
                    <div class="content-panel">
                        <h4> {{ $pageTitle   }}</h4>

                        <section id="no-more-tables">
                            <table class="table table-bordered table-striped table-condensed cf">
                                <thead class="cf">
                                <tr>
                                    <th>#</th>
                                    <th>User Info</th>
                                    <th>Order ID</th>
                                    <th>Total Amount</th>
                                    <th>Payment ID</th>
                                    <th>Transaction Date</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions  as $tranx)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <p class="d-block h4 font-weight-bold">{{$tranx->user->name}}</p>
                                            <p class="d-block ">{{$tranx->user->email}}</p>
                                        </td>
                                        <td>{{$tranx->order_id}} </td>
                                        <td>{{$tranx->payment_amount}}</td>
                                        <td>{{$tranx->tranx_id}}</td>
                                        <td>{{$tranx->transaction_time}}</td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </section>
                    </div>
                    <!-- /content-panel -->
                </div>
                <!-- /col-lg-12 -->
            </div>
            <!-- /row -->
        </section>
        <!-- /wrapper -->
    </section>

@endsection
