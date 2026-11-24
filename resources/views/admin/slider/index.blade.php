 @extends('admin.layout')
 @section('title','Slider')
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
              <a href="{{route('admin.slider.create') }} " class="btn btn-md btn-info pull-right">Add New</a>
              <section id="no-more-tables">
                <table class="table table-bordered table-striped table-condensed cf">
                  <thead class="cf">
                    <tr>
                      <th>#</th>
                      <th>ID</th>
                      <th>Image</th>
                      <th>Link</th>
                      <th class="numeric">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($objsliders  as $key=>$obj)
                    <tr>
                      <td data-title="Code">{{($key + 1)}}</td>
                      <td data-title="Company">{{$obj->id}}</td>
                      <td><img width="200" height="200" src="{{asset('uploads/'.$obj->image)}}"></td>
                      <td><a href="{{$obj->link}}" target="_blank">View link</a> </td>
                      <td class="numeric" data-title="High"> <a href='{{route("admin.slideredit",["id" => $obj->id])}}' class="btn btn-sm btn-warning">Edit</a>
                      <a class="btn btn-danger" href ="{{ route('admin.sliderdestroy',['id'=>$obj->id]) }}" method="post">Delete</a>
                      </td>
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
