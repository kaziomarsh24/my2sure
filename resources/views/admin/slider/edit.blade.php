@extends('admin.layout')
@section('title','Edit Games')
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
                        <form action="{{route('admin.sliderupdate' , ['id' => $objData->id])}}" method="POST"  enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group col-md-6">
                                <label>Game Logo</label>
                                <input type="file"   class="form-control" name="image" >
                            </div>
                            <div class="form-group col-md-6">
                                <label>Link</label>
                                <input type="text" value="{{$objData->link}}"  class="form-control" name="link" required>
                            </div>
                            <div class="form-group col-md-6">
                                <img width="200" height="200" src="{{asset('uploads/'.$objData->image)}}">
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
