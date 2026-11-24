@extends('admin.layout')
@section('title','Users')
@push('styles')
    <link href="css/style-responsive.css" rel="stylesheet">
    <link href="css/table-responsive.css" rel="stylesheet">


@endpush


@section('content')
    <section id="main-content">
        <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> {{ $pageTitle }}</h3>
            <div class="row mt">
                <form action="" method="get" class="col-md-12">
                    @csrf
                    <div class=" ">
                        <div class="row clearfix">
                            <div class="col-lg-3 col-md-12">
                                <label>Name</label>
                                <div class="multiselect_div">
                                    <input type="text" class="input-sm form-control" name="name" value="{{ request('name') }}" placeholder="Search by name...">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <label>Email</label>
                                <div class="multiselect_div">
                                    <input type="text" class="input-sm form-control" name="email" value="{{ request('email') }}" placeholder="Search by email...">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-12">
                                <label>Search</label>
                                <div class="input-group">
                                    <input type="submit" class="btn btn-sm btn-primary" value="Search">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-default ml-1">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row mt">
                <div class="col-lg-12">
                    <div class="content-panel">
                        <h4> {{ $pageTitle }}</h4>
                        {{-- Per page selector --}}
                        <form method="GET" id="perPageForm" class="pull-left mb-2">
                            <input type="hidden" name="name" value="{{ request('name') }}">
                            <input type="hidden" name="email" value="{{ request('email') }}">
                            <select name="per_page" class="form-control" style="width: auto; display: inline-block;"
                                    onchange="document.getElementById('perPageForm').submit()">
                                @foreach([10, 25, 50, 100, 250, 500, 1000, 50000, 1000000] as $pp)
                                    <option value="{{ $pp }}" {{ request('per_page', 50) == $pp ? 'selected' : '' }}>
                                        {{ $pp }} per page
                                    </option>
                                @endforeach
                            </select>
                        </form>
                        <section id="no-more-tables">
                            <table class="table table-bordered table-striped table-condensed cf" id="myDataTable">
                                <thead class="cf">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th class="numeric">Email</th>
                                    <th class="numeric">Type</th>
                                    <th class="numeric">Membership Expiry</th>
                                    <th class="numeric">Total Plays</th>
                                    <th class="numeric">No Of Referrals</th>
                                    <th class="numeric">Status</th>
                                    <th class="numeric">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($obj as $key => $user)
                                    <tr>
                                        <td data-title="Code">{{ ($obj->currentPage() - 1) * $obj->perPage() + $key + 1 }}</td>
                                        <td data-title="Name">{{ $user->name }}</td>
                                        <td data-title="Email">{{ $user->email }}</td>
                                        <td data-title="Type">{{ $user->type }}</td>
                                        <td data-title="Membership Expiry">{{ $user->expiry_date }}</td>
                                        <td data-title="Total Plays">{{ count($user->forecaster) }}</td>
                                        <td data-title="No Of Referrals">{{ count($user->referralUsers) }}</td>
                                        <td class="numeric" data-title="Status">{{ $user->isActive }}</td>
                                        <td class="numeric" data-title="Action">
                                            <a href='{{ url('referralpage/'.$user->id) }}' class="btn btn-sm m-1 btn-warning">View Referrals</a>
                                            <a href='{{ route("admin.users.edit", ["user" => $user->id]) }}' class="btn m-1 btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('admin.users.destroy', ['user' => $user->id]) }}" method="post">
                                                <input class="btn btn-sm btn-danger" type="submit" value="Delete" />
                                                <input type="hidden" name="_method" value="delete" />
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3 d-flex justify-content-center">
                                {{ $obj->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </section>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#myDataTable').DataTable({ "paging": false });
            });
        </script>
    @endpush
@endsection
