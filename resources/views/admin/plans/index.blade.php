@php
    use App\source_plan; // Replace with the correct namespace and path

    $s_plan = new source_plan();
@endphp

@extends('admin.layout')
@section('title','Plans')
@push('styles')

    <!--   <link href="css/style-responsive.css" rel="stylesheet">
    <link href="css/table-responsive.css" rel="stylesheet"> -->
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

                        <button type="button" class="btn btn-info btn-sm pull-right m-1" style="margin: 10px;position: relative;z-index: 999 " data-toggle="modal" data-target="#myModal">Update Plans</button>

                        <a href="{{route('admin.plans.create') }} " style="display: none" class=" btn btn-md btn-info pull-right">Add New</a>

                        <section id="no-more-tables">
                            <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead class="cf">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th class="numeric">Sets</th>
                                    <th class="numeric">Numbers</th>
                                    <th class="numeric">Status</th>
                                    <th class="numeric">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($obj  as $key=>$objs)
                                    <tr>
                                        <td data-title="Code">{{($key + 1)}}</td>
                                        <td data-title="Company">Plan {{$objs->name}}</td>
                                        <td data-title="Company">{{$objs->sets}}</td>
                                        <td data-title="Company">{{$objs->numbers}}</td>
                                        <td class="numeric" data-title="Price"> {{ $objs->status }} </td>
                                        <td class="numeric" data-title="High"> <a href='{{route("admin.plans.edit",["plan" => $objs->id])}}' class="pull-left btn btn-sm btn-warning">Edit</a>
                                        {{--                                            <form class="pull-left" action="{{ route('admin.plans.destroy',['plan'=>$obj->id]) }}" method="post">--}}
                                        {{--                                                <input class="btn btn-sm btn-danger" type="submit" value="Delete" />--}}
                                        {{--                                                <input type="hidden" name="_method" value="delete" />--}}
                                        {{--                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                        {{--                                            </form>--}}
                                        {{--                                        </td>--}}
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
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Plans</h4>
                </div>
                <form action="{{route('admin.updates')}}" method="POST"  enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <br>
                        <table class="table w-100 table-borderless table-striped">
                            <?php

                            foreach ($source_plans as $index => $values){

                                $letter=$s_plan->getLetters($index);
                                ?>
                            <tr class="">
                                <td>Plan <?=$letter?> Numbers</td>
                                <td><input type="text"  pattern="\d{1,2},\d{1,2}" value="{{$values->number}}"   class="form-control" name="plan<?=$index?>" required></td>
                                <td><a href="{{route('admin.delete_plan', $values['id'])}}" class="btn btn-link text-danger">Delete Plan</a></td>

                            </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <input type="hidden" name="count" value="<?=$source_plans->count()?>">
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-info btn-sm " style="margin: 10px">Update Plans</button>

                    </div>
                </form>
            </div>

        </div>
    </div>
    @push('scripts')
        <script>
            new DataTable('#example', {
                responsive: true
            });



        </script>
    @endpush
@endsection
