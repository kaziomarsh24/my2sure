 @extends('admin.layout')
 @section('title','Dashboard')
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
                            <label>Game Name</label>
                            <div class="multiselect_div">
                                <select class="form-control" name="game_id">
                                  <option value>Select Game</option>
                                  @foreach($objGames as $obj)
                                    <option value="{{$obj->id}}">{{$obj->name}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12">
                            <label>Lottery Name</label>
                            <div class="multiselect_div">
                                <input type="text" class="input-sm form-control date" name="lottery" value="">
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-12">
                            <label> Date Range</label>
                            <div class="input-daterange input-group" data-provide="datepicker">
                                <input type="date" class="input-sm form-control date" name="from_date" value="{{ old('from_date', request()->from_date ?? date('d/m/Y')) }}">
                                <span class="input-group-addon range-to">to</span>
                                <input type="date" class="input-sm form-control date" name="to_date" value="{{ old('to_date', request()->to_date ?? date('d/m/Y')) }}">
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
              <section id="no-more-tables">
                <table class="table table-bordered table-striped table-condensed cf">
                  <thead class="cf">
                    <tr>
                      <th>#</th>
                      <th>Game</th>
                      <th class="numeric">Name</th>
                      <th class="numeric">Permutation</th>
                      <th class="numeric">No's</th>
                      <th class="numeric">sets</th>
                      <th class="numeric">plays</th>
                      <th class="numeric">status</th>
                      <th class="numeric">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($objLotteries  as $key=>$obj) 
                    <tr>
                      <td data-title="Code">{{($key + 1)}}</td>
                      <td data-title="Company">{{$obj->game->name}}</td>
                      <td data-title="Company">{{$obj->name}}</td>
                      <td class="numeric" data-title="Price"> {{ $obj->permutation }} </td>
                      <td class="numeric" data-title="Change">
                        @for($i=$obj->starting_no; $i<($obj->starting_no + $obj->permutation ); $i++)
                           {{ $i }},
                        @endfor
                      </td>
                      <td class="numeric" data-title="Change %"> {{ $obj->sets }} </td>
                      <td class="numeric" data-title="Open"> {{ $obj->plays }}  </td>
                      <td class="numeric" data-title="High"> {{ $obj->status }} </td>
                      <td class="numeric" data-title="High"> <a href='{{route("admin.games.edit",["game" => $obj->id])}}' class="btn btn-sm btn-warning">Edit</a>  
                        <form action="{{ route('admin.lottery.destroy',['lottery'=>$obj->id]) }}" method="post">
                          <input class="btn btn-sm btn-danger" type="submit" value="Delete" />
                          <input type="hidden" name="_method" value="delete" />
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      </form>  </td>
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