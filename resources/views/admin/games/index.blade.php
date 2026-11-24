 @extends('admin.layout')
 @section('title','Games')
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
           <form action="" method="get" class="col-md-12">
                @csrf
                <div class=" ">
                    <div class="row clearfix"> 
                       
                        <div class="col-lg-3 col-md-12">
                            <label> Name</label>
                            <div class="multiselect_div">
                                <input type="text" class="input-sm form-control date" name="name" value="">
                            </div>
                        </div>
                       
                        <div class="col-lg-1 col-md-12">
                            <label>Search</label>
                            <div class="input-group">
                                <input type="submit" class="btn btn-sm btn-primary" value="Search">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row mt">
            
          <div class="col-lg-12">
            <div class="content-panel">
              <h4> {{ $pageTitle   }}</h4>
              <a href="{{route('admin.games.create') }} " class="btn btn-md btn-info pull-right">Add New</a>
              <section id="no-more-tables">
                <table class="table table-bordered table-striped table-condensed cf">
                  <thead class="cf">
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th class="numeric">Details</th>
                      <th class="numeric">Status</th>
                      <th class="numeric">End Date</th>
                      <th class="numeric">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($objGames  as $key=>$obj) 
                    <tr>
                      <td data-title="Code">{{($key + 1)}}</td>
                      <td data-title="Company">{{$obj->name}}</td>
                      <td data-title="Company">{{$obj->details}}</td>
                      <td data-title="Company">{{$obj->status}}</td>
                      <td class="numeric" data-title="Price"> {{ $obj->end_date }} </td>
                      <td class="numeric" data-title="High"> <a href='{{route("admin.games.edit",["game" => $obj->id])}}' class="btn btn-sm btn-warning">Edit</a> 
                      <form action="{{ route('admin.games.destroy',['game'=>$obj->id]) }}" method="post">
                          <input class="btn btn-sm btn-danger" type="submit" value="Delete" />
                          <input type="hidden" name="_method" value="delete" />
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      </form>
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