
@extends('admin.layout')
@section('title', 'Winners')
@section('content')
    <section id="main-content">
        <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> Winners</h3>
            <div class="row mt">
                <div class="col-lg-12">
                    <div class="content-panel">
                        <h4>Winners</h4>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Game</th>
                                <th>Lottery</th>
                                <th>Numbers</th>
                                <th>Play Date</th>
                                <th>Marked At</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($winners as $key => $winner)
                                @php
                                    $play = isset($plays) ? $plays->get($winner->user_id . '_' . $winner->lottery_id) : null;
                                @endphp
                                <tr>
                                    <td>{{ ($winners->currentPage() - 1) * $winners->perPage() + $key + 1 }}</td>
                                    <td>
                                        <strong>{{ $winner->user->name ?? 'N/A' }}</strong><br>
                                        <small>{{ $winner->user->email ?? '' }}</small>
                                    </td>
                                    <td>
                                        <span style="display:block; font-weight: bold">{{ $winner->lottery->game->name ?? 'N/A' }}</span>
                                        <span style="display:block">{{ $play->game_name ?? 'N/A' }}</span>
                                    </td>
                                    <td>{{ $winner->lottery->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($play)
                                            <textarea rows="2" cols="10">{{ $play->numbers }}</textarea>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $play ? $play->created_at->format('d M Y') : 'N/A' }}</td>
                                    <td>{{ $winner->marked_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.winners.destroy', $winner->id) }}"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Remove this winner entry?')">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3 d-flex justify-content-center">
                            {{ $winners->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
