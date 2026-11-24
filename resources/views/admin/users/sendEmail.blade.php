@extends('admin.layout')
@section('title','Send Email')
@push('styles')

    <link href="css/style-responsive.css" rel="stylesheet">
    <link href="css/table-responsive.css" rel="stylesheet">
@endpush
@section('content')
    <section id="main-content">
        <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> {{ $pageTitle}}</h3>

            <div class="row mt">

                <div class="col-lg-12">
                    <div class="content-panel  col-md-12">
                        <h4> {{$pageTitle}}</h4>
                        <hr/>
                        <form action="{{route('admin.SendBulkEmail')}}" method="POST"  enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}

                            <div class="form-group col-md-6">
                                <label>Enter Subject</label>
                                <input type="text" class="form-control" name="subject" required>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Enter Email Text</label>
                                <textarea type="text" class="form-control" rows="5" required name="email_text" ></textarea>

                            </div>

                            <div class="form-group col-md-12 pull-right ">
                                <input type="submit" value="SUBMIT" class="btn btn-lg btn-success pull-right" >
                            </div>
                        </form>
                    </div>
                    <!-- /content-panel -->
                </div>
                <!-- /col-lg-12 -->

            </div>
            <!-- /row -->

            <!-- /row -->
        </section>
        <!-- /wrapper -->
    </section>

@endsection
