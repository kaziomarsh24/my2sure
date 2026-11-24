 @extends('admin.layout')
 @section('title','Add Lottery')
 @push('styles')

  <link href="css/style-responsive.css" rel="stylesheet">
  <link href="css/table-responsive.css" rel="stylesheet">
@endpush
 @section('content')
 <section id="main-content">
      <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> {{ $pageTitle   }} - Lottery</h3>
       
        <div class="row mt">
            
          <div class="col-lg-12">
            <div class="content-panel  col-md-12">
              <h4> {{ $pageTitle   }}</h4>
              <hr/>
              <form action="{{route('admin.lottery.store'  )}}" method="POST">
                 {{ csrf_field() }}
              <div class="form-group col-md-6">
                <label>Name</label>
                <input type="text"   class="form-control" name="name" required>
              </div>
              <div class="form-group col-md-6">
                <label>Status</label>
                <select name="status" class="form-control">
                  <option value="1">Active</option>
                  <option value="0">In-Active</option>
                </select>
              </div>

              <div class="form-group col-md-6">
                <label>Starting No</label>
                <input type="text"  class="form-control" name="starting_no" required>
                 
              </div>
              <div class="form-group col-md-6">
                <label>Permutation</label>
                <input type="text"  class="form-control" name="permutation" required>
              </div>
              

              <div class="form-group col-md-6 hide">
                <label>One Time</label>
                <input type="text"  value="1" class="form-control" name="one_time" required>
              </div>
              <div class="form-group col-md-6">
                <label>Sets</label>
                 <input type="text"  class="form-control" name="sets" required>
              </div>
              <div class="form-group col-md-6">
                <label>Game</label>
                  <select name="game_id" class="form-control" required>
                      <option value>Choose</option> 
                    @foreach($objGames As $obj)
                      <option value="{{$obj->id}}">{{$obj->name}}</option> 
                    @endforeach
                </select>
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