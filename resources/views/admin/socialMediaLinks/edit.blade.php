@extends('admin.layout')
@section('title','Edit Links')
@push('styles')

    <link href="css/style-responsive.css" rel="stylesheet">
    <link href="css/table-responsive.css" rel="stylesheet">
@endpush
@section('content')
    <section id="main-content">
        <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> {{ $pageTitle   }} - Links</h3>

            <div class="row mt">

                <div class="col-lg-12">
                    <div class="content-panel  col-md-12">
                        <h4> {{ $pageTitle   }}</h4>
                        <hr/>
                        <form action="{{route('admin.socialMediaLinksupdate')}}" method="POST"  enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$objData->id}}" name="id">
                            <div class="form-group col-md-6">
                                <label>Youtube</label>
                                <input type="text" value="{{$objData->youtube}}" class="form-control" name="youtube" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Instagram</label>
                                <input type="text" value="{{$objData->instagram}}" class="form-control" name="instagram" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>LinkedIn</label>
                                <input type="text" value="{{$objData->linkedin}}" class="form-control" name="linkedin" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Twitter</label>
                                <input type="text" value="{{$objData->twitter}}" class="form-control" name="twitter" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Google+</label>
                                <input type="text" value="{{$objData->google}}" class="form-control" name="google" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Facebook</label>
                                <input type="text" value="{{$objData->facebook}}" class="form-control" name="facebook" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>TikTok</label>
                                <input type="text" value="{{$objData->tiktok}}" class="form-control" name="tiktok" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>YouTub Video ID</label>
                                <input type="text" value="{{$objData->youtube_video}}" class="form-control" name="youtube_video" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Notification</label>
                                <textarea type="text" rows="4" class="form-control" name="notification" required>{{$objData->notification}}</textarea>
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
