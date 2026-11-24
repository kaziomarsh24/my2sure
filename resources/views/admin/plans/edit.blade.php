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
              <form action="{{route('admin.plans.update' , ['plan' => $objData->id])}}" method="POST"  enctype="multipart/form-data">
                 {{ csrf_field() }}
              {{ method_field('PATCH') }}
              <div class="form-group col-md-6">
                <label>Name</label>
                <input type="text" value="{{$objData->name}}" class="form-control" name="name" required>
              </div>
              <div class="form-group col-md-6">
                <label>Status</label>
                <select name="status" class="form-control">
                  <option value="1">Active</option>
                  <option value="0">In-Active</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label>Sets</label>
                <input type="numbers" value="{{$objData->sets}}" class="form-control" name="sets" required>
              </div>
              <div class="form-group col-md-6">
                <label>Numbers</label>
                <input type="text" value="{{$objData->numbers}}" class="form-control" name="numbers" required>
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
