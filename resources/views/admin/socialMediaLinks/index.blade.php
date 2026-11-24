@extends('admin.layout')
@section('title','Plans')
@push('styles')

    <link href="css/style-responsive.css" rel="stylesheet">
    <link href="css/table-responsive.css" rel="stylesheet">
@endpush
@section('content')
    <section id="main-content">
        <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> {{ $pageTitle   }}</h3>
            <!-- /row -->

            <div class="row mt">

                <div class="col-lg-12">
                    <div class="content-panel">
                        <h4> {{ $pageTitle   }}</h4>
                        <section id="no-more-tables">

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
