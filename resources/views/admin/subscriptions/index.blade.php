@extends('admin.layout')
@section('title', 'Subscriptions')
@section('content')
    <section id="main-content">
        <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> Subscriptions</h3>
            <div class="row mt">
                <div class="col-lg-12">
                    <div class="content-panel">
                        <h4>Subscriptions</h4>
                        <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-md btn-info pull-right">Add Manual Subscription</a>

                        @if(session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @endif

                        {{-- Filters --}}
                        <form method="GET" class="mt-3 mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="type" class="form-control">
                                        <option value="">All Types</option>
                                        <option value="vip"       {{ request('type') == 'vip'       ? 'selected' : '' }}>VIP Room</option>
                                        <option value="two_sure"  {{ request('type') == 'two_sure'  ? 'selected' : '' }}>2Sure Competition</option>
                                        <option value="all_games" {{ request('type') == 'all_games' ? 'selected' : '' }}>All Games</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="active"  {{ request('status') == 'active'  ? 'selected' : '' }}>Active</option>
                                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-default">Reset</a>
                                </div>
                            </div>
                        </form>

                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Starts</th>
                                <th>Expires</th>
                                <th>Payment ID</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subscriptions as $key => $sub)
                                <tr>
                                    <td>{{ ($subscriptions->currentPage() - 1) * $subscriptions->perPage() + $key + 1 }}</td>
                                    <td>
                                        <strong>{{ $sub->user->name ?? 'N/A' }}</strong><br>
                                        <small>{{ $sub->user->email ?? '' }}</small>
                                    </td>
                                    <td>
                                        @if($sub->type == 'vip')
                                            <span class="badge badge-warning">VIP Room</span>
                                        @elseif($sub->type == 'two_sure')
                                            <span class="badge badge-primary">2Sure</span>
                                        @else
                                            <span class="badge badge-success">All Games</span>
                                        @endif
                                    </td>
                                    <td>{{ $sub->currency }} {{ $sub->amount }}</td>
                                    <td>
                                        @if($sub->status == 'active' && $sub->expires_at >= date('Y-m-d'))
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Expired</span>
                                        @endif
                                    </td>
                                    <td>{{ $sub->starts_at }}</td>
                                    <td>{{ $sub->expires_at }}</td>
                                    <td><small>{{ $sub->payment_id }}</small></td>
                                    <td>
                                        @if($sub->status == 'active')
                                            <a href="{{ route('admin.subscriptions.expire', $sub->id) }}"
                                               class="btn btn-sm btn-warning"
                                               onclick="return confirm('Expire this subscription?')">Expire</a>
                                        @endif
                                        <a href="{{ route('admin.subscriptions.destroy', $sub->id) }}"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Delete this subscription?')">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3 d-flex justify-content-center">
                            {{ $subscriptions->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
