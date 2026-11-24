 @extends('admin.layout')
 @section('title','Edit Games')
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
              <h4> {{ $pageTitle   }} | {{$objData->game->details}}</h4>
              <hr/>
              <form action="{{route('admin.lottery.update' , ['lottery' => $objData->id])}}" method="POST">
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
                <label>Starting No</label>
                <input type="text" value="{{$objData->starting_no}}" class="form-control" name="starting_no" required>

              </div>
              <div class="form-group col-md-6">
                <label>Permutation</label>
                <input type="text" value="{{$objData->permutation}}" class="form-control" name="permutation" required>
              </div>


              <div class="form-group col-md-6 hide">
                <label>One Time</label>
                <input type="text" value="{{$objData->one_time}}" class="form-control" name="one_time" required>
              </div>
              <div class="form-group col-md-6">
                <label>Sets</label>
                 <input type="text" value="{{$objData->sets}}" class="form-control" name="sets" required>
              </div>
              <div class="form-group col-md-6">
                <label>Game</label>
                  <select name="game_id" class="form-control">
                      <option value="{{$objData->game_id}}">{{$objData->game->name}}</option>
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
