 @extends('admin.layout')
 @section('title','Edit Product')
 @push('styles')

  <link href="css/style-responsive.css" rel="stylesheet">
  <link href="css/table-responsive.css" rel="stylesheet">
@endpush
 @section('content')
 <section id="main-content">
      <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> {{ $pageTitle   }}</h3>

        <div class="row mt">

          <div class="col-lg-12">
            <div class="content-panel  col-md-12">
              <h4> {{ $pageTitle   }}</h4>
              <hr/>
              <form action="{{route('admin.shop.update' , ['shop' => $objData->id])}}" method="POST"  enctype="multipart/form-data">
                 {{ csrf_field() }}
              {{ method_field('PATCH') }}
              <div class="form-group col-md-6">
                <label>Name</label>
                <input type="text" value="{{$objData->name}}" class="form-control" name="name" required>
              </div>

              <div class="form-group col-md-6">
                <label>Price</label>
                <input type="number" value="{{$objData->price}}" class="form-control" name="price" required>
              </div>
              <div class="form-group col-md-6">
                <label>Description</label>
                <input type="text" value="{{$objData->description}}" class="form-control" name="description" required>
              </div>

              <div class="form-group col-md-6">
                <label>Product Logo</label>
                <input type="file"   class="form-control" name="logo" >
              </div>

                  <div class="col-lg-3 mt-2" style="margin-top: 15px;">
                      <div class="form-group">
                          <label>
                              <input type="checkbox" {{  $variants->count() > 0  ? "checked" : "" }} id="variants_check">
                              &nbsp;Product has variants?
                          </label>

                      </div>
                  </div>
                  <div class="col-lg-12" id="variants_div" style="display: none">
                      <h3>Product Variants</h3>

                      <div class="row">

                          <div class="col-lg-3 mb-3">
                              <label class="form-label">Label</label>
                              <input type="text" name="label[]"  class="form-control">
                          </div>



                          <div class="col-lg-3 mb-3">
                              <label class="form-label">Stock</label>
                              <input type="number"  name="stock[]"  class="form-control">
                          </div>

                          <div class="col-lg-3 mb-3">
                              <label class="form-label"></label>
                              <div class="d-flex align-items-center justify-content-between">

                                  <a id="add-input-row" class=" btn btn-sm btn-dark  btn text-decoration-none"><i class="fa fa-plus-square"></i></a>
                                  <!-- <a id="remove-input-row" class="btn-dark btn-sm btn" class="text-decoration-none"><i class="bi bi-trash-fill"></i></a> -->
                              </div>
                          </div>
                      </div>
                      <div id="append-input-row"></div>
                      @foreach($variants as $variant)
                          <div class='next-referral row align-items-center'>
                              <div class='col-lg-3 mb-3'>
                                  <label class='form-label'>Label</label>
                                  <input type='text' name='label[]' value="{{$variant->label}}" required class='form-control'>
                              </div>

                              <div class='col-lg-3 mb-3'>
                                  <label class='form-label'>Stock</label>
                                  <input name='stock[]' type='number' value="{{$variant->stock}}" required class='form-control'>
                              </div>
                              <div class='col-lg-3 mb-3'>
                                  <label class='form-label'></label>
                                  <div class='d-flex align-items-center justify-content-between'>
                                      <a id='append-delete-row' class='btn-dark  btn-sm btn text-decoration-none'><i class='fa fa-trash'></i></a>
                                  </div>
                              </div>
                          </div>
                      @endforeach
                  </div>

              <div class="form-group col-md-6">
                <img src="{{asset('uploads/'.$objData->logo)}}">
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
 @push('scripts')
     <script type="text/javascript">

         $("#variants_check").change(function (e){

             e.preventDefault();
             if($("#variants_check").prop('checked') == true){

                 $("#variants_div").show();

             }else {

                 $("#variants_div").hide();
             }
         });


         $(document).ready(function() {
             $("#category_inputs").addClass("nav-active");

             $("#remove-input-row").hide();
             $("#add-input-row").click(function(e) {
                 $("#remove-input-row").fadeIn("1500");

                 $("#append-input-row").append("<div class='next-referral row align-items-center mt-2'><div class='col-lg-3 mb-3'><label class='form-label'>Label</label><input type='text' name='label[]' required class='form-control'></div><div class='col-lg-3 mb-3'><label class='form-label'>Stock</label><input name='stock[]' type='number' required class='form-control'></div><div class='col-lg-3 mb-3'><label class='form-label'></label><div class='d-flex align-items-center justify-content-between'><a id='append-delete-row' class='btn-dark  btn-sm btn text-decoration-none'><i class='fa fa-trash'></i></a></div></div></div>");
             });
             $("body").on("click", "#append-delete-row", function(e) {
                 $(".next-referral").last().remove();
             });
         });

     </script>
 @endpush
