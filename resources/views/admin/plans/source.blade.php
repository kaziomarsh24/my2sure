@extends('admin.layout')
@section('title','Source Plan')
@push('styles')

    <link href="css/style-responsive.css" rel="stylesheet">
    <link href="css/table-responsive.css" rel="stylesheet">
@endpush
@section('content')
    <section id="main-content">
        <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> Source - Plan</h3>

            <div class="row mt">

                <div class="col-lg-12">
                    <div class="content-panel  col-md-12">

                        <hr/>
                        <p>Here, create a new plan for the all plans page.</p>
                        <form action="{{route('admin.source_plan_add'  )}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group col-md-6">
                                <label>Numbers ( Comma Seprated, )</label>
                                <input type="text" class="form-control" name="numbers"
                                       required pattern="\d{1,2},\d{1,2}">
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
        </section>
        <!-- /wrapper -->
    </section>

@endsection
