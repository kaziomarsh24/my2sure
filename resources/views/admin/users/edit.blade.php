 @extends('admin.layout')
 @section('title','Edit User')
 @push('styles')

  <link href="css/style-responsive.css" rel="stylesheet">
  <link href="css/table-responsive.css" rel="stylesheet">
@endpush
 @section('content')
 <section id="main-content">
      <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> {{ $pageTitle   }} - User</h3>
       
        <div class="row mt">
            
          <div class="col-lg-12">
            <div class="content-panel  col-md-12">
              <h4> {{ $pageTitle   }}</h4>
              <hr/>
              <form action="{{route('admin.users.update' , ['user' => $objData->id])}}" method="POST"  enctype="multipart/form-data">
                 {{ csrf_field() }}
              {{ method_field('PATCH') }} 
              <div class="form-group col-md-6">
                <label>Name</label>
                <input type="text" value="{{$objData->name}}" class="form-control" name="name" required>
              </div>
              <div class="form-group col-md-6">
                <label>Status</label>
                <select name="isActive" class="form-control">
                  <option value="{{$objData->isActive}}">{{$objData->isActive}}</option>
                  <option value="1">Active</option>
                  <option value="0">In-Active</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label>Member Ship Expiry Date</label>
                <input type="date" value="{{date('Y-m-d',strtotime($objData->expiry_date))}}" class="form-control" name="expiry_date" required>

               

               
              </div>
              <div class="form-group col-md-6">
                <label>password</label>
                <input type="password" value="" class="form-control" name="password" >
              </div>
              <div class="form-group col-md-6">
                <label>Email</label>
                <input type="email" value="{{$objData->email}}" class="form-control" name="email" >
              </div>
              <div class="form-group col-md-6">
                <label>Type</label>
                <select name="type" class="form-control">
                  <option value="{{$objData->type}}">{{$objData->type}}</option>
                  <option value="user">User</option>
                  <option value="admin">Admin</option>
                </select>
              </div>

                 
                 <div class="form-group col-md-12">
                    <label>Trial Period </label>
                     @if($objData->trial_used == 1)
                        <h3>Trial Period Used At {{$objData->trial_used_date}} </h3>
                        <select class="form-control" name="extend_trial">
                      <option value="{{$objData->trial_used}}">{{($objData->trial_used == 0) ? 'No' : 'Yes'}} ( Current Value)</option>
                       <option value="0">No</option>
                       <option value="1">Yes</option>
                     </select>
                      @elseif($objData->expiry_date > date('Y-m-d'))
                      <h4>This Person is already on paid subscription</h4>
                      @else
                      <select class="form-control" name="extend_trial">
                      <option value="{{$objData->trial_used}}">{{($objData->trial_used == 0) ? 'No' : 'Yes'}} ( Current Value)</option>
                       <option value="0">No</option>
                       <option value="1">Yes</option>
                     </select>
                      @endif
                    
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

        @if(count($objData->forecaster) > 0)
          <div class="row mt">
            <div class="col-lg-12">
              <div class="  col-md-12">
                <h3>Recently Used Forecaster </h3>
                @foreach($objData->forecaster As $obj)
                 <div class="col-md-3 content-panel text-center" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
                 @if($obj->lottery != null)
                    @if($obj->lottery->game != null)
                   <h3>{{$obj->lottery->game->name}}</h3>
                   @endif
                   <h4>{{$obj->lottery->name}}</h4>
                   
               @endif
                   @foreach(explode("/",$obj->numbers) as $nmb)
                   <p><b>Generated Numbers </b>: {{$nmb}} </p>
                   @endforeach
                    <p>at {{date('Y-m-d',strtotime($obj->created_at))}}</p>
                 </div>
                @endforeach
              </div>
            </div>
          </div>
          @endif
        <!-- /row -->
      </section>
      <!-- /wrapper -->
    </section>

@endsection