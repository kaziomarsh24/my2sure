 @extends('admin.layout')
 @section('title','Edit Plans')
 @push('styles')

  <link href="css/style-responsive.css" rel="stylesheet">
  <link href="css/table-responsive.css" rel="stylesheet">
@endpush
 @section('content')
 <section id="main-content">
      <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> {{ $pageTitle   }} - Plans</h3>
       
        <div class="row mt">
            
          <div class="col-lg-12">
            <div class="content-panel  col-md-12">
              <h4> {{ $pageTitle   }}</h4>
              <hr/>
              <form action="{{route('admin.giveawayupdate')}}" method="POST"  enctype="multipart/form-data">
                 {{ csrf_field() }}
              <input type="hidden" value="{{$objData->id}}" name="id">
              <div class="form-group col-md-6">
                <label>Day</label>
                <input type="text" value="{{$objData->day}}" class="form-control" readonly>
              </div>
              <div class="form-group col-md-6">
                <label>Values  (Comma Seperated)</label>
                <input type="text" value="{{$objData->value}}" class="form-control" name="value" required>
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