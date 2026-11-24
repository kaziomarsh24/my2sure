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
                                    <th>Product Info</th>
                                    <th>Quantity</th>
                                    <th>Total Amount</th>
                                    <th>Payment ID</th>
                                    <th>Delivery Address</th>
                                    <th>Order Date</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <p class="h4 font-weight-bold">{{ $order->user->name ?? 'N/A' }}</p>
                                            <p>{{ $order->user->email ?? 'N/A' }}</p>
                                        </td>
                                        <td>
                                            <p class="d-block h4 font-weight-bold">
                                                {{ $order->product->name ?? 'N/A' }}
                                                <span>{{ $order->variant != null ? '('.$order->variant->label.')' : '' }}</span>
                                            </p>
                                            <p class="d-block">${{ $order->product->price ?? '0' }}</p>
                                        </td>
                                        <td>{{ $order->quantity }}</td>
                                        <td>{{ $order->total_amount }}</td>
                                        <td>{{ $order->payment_id }}</td>
                                        <td>{{ $order->address }}</td>
                                        <td>{{ $order->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="mt-3 d-flex justify-content-center">
                                {{ $orders->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
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
