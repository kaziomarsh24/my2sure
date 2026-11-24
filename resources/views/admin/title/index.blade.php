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
                <table class="table table-bordered table-striped table-condensed cf">
                  <thead class="cf">
                    <tr>
                      <th>#</th>
                      <th class="numeric">Title</th>
                      <th class="numeric">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($obj  as $key=>$obj) 
                    <tr>
                      <td data-title="Code">{{($key + 1)}}</td>
                      <td data-title="Company">{{$obj->result_section}}</td>
                      <td class="numeric" data-title="High"> <a href='{{route("admin.titleedit",["id" => $obj->id])}}' class="pull-left btn btn-sm btn-warning">Edit</a> 
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