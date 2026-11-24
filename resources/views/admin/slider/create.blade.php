@extends('admin.layout')
@section('title','Edit Slider')
@push('styles')

    <link href="css/style-responsive.css" rel="stylesheet">
    <link href="css/table-responsive.css" rel="stylesheet">
@endpush
@section('content')
    <section id="main-content">
        <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> {{ $pageTitle   }} - Game</h3>

            <div class="row mt">

                <div class="col-lg-12">
                    <div class="content-panel  col-md-12">
                        <h4> {{ $pageTitle   }}</h4>
                        <hr/>
                        <form action="{{route('admin.slider.store'  )}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group col-md-6">
                                <label>Image</label>
                                <input type="file"   class="form-control" name="image" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Link</label>
                                <input type="text"   class="form-control" name="link" required>
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
