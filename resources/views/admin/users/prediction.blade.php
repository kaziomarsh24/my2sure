@extends('admin.layout')
@section('title','Predictions')

@section('content')
    <section id="main-content">
        <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> {{ $pageTitle }}</h3>

            <div class="row mt">
                <div class="col-lg-12">
                    <div class="content-panel">
                        <h4>{{ $pageTitle }}</h4>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        {{-- Top controls --}}
                        <div class="row mb-3">

                            {{-- Per page selector --}}
                            <div class="col-md-2">
                                <form method="GET" id="perPageForm">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <input type="hidden" name="date" value="{{ request('date') }}">
                                    <div class="input-group">
                                        <select name="per_page" class="form-control" onchange="document.getElementById('perPageForm').submit()">
                                             @foreach([10, 25, 50, 100, 250, 500, 1000, 50000, 1000000] as $pp)
                                                <option value="{{ $pp }}" {{ request('per_page', 50) == $pp ? 'selected' : '' }}>
                                                    {{ $pp }} per page
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>

                            {{-- Search + Date filter --}}
                            <div class="col-md-6">
                                <form method="GET" id="searchForm">
                                    <input type="hidden" name="per_page" value="{{ request('per_page', 50) }}">
                                    <div class="input-group">
                                        <input type="text"
                                               name="search"
                                               class="form-control"
                                               placeholder="Search by name or email..."
                                               value="{{ request('search') }}">
                                        <input type="date"
                                               name="date"
                                               class="form-control"
                                               style="max-width: 180px;"
                                               value="{{ request('date') }}"
                                               title="Filter by play date">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                            <a href="{{ route('admin.users.prediction') }}" class="btn btn-default">Reset</a>
                                        </span>
                                    </div>
                                </form>
                            </div>

                            {{-- Mark winners button --}}
                            <div class="col-md-4 text-right mb-5">
                                <button type="button" class="btn btn-warning" id="markWinnersBtn" disabled>
                                    <i class="fa fa-trophy"></i> Mark Selected as Winners
                                </button>
                            </div>
                        </div>

                        {{-- Active filters display --}}
                        @if(request('search') || request('date'))
                            <div class="mb-3">
                                <span class="text-muted">Filtering by: </span>
                                @if(request('search'))
                                    <span class="label label-info" style="padding: 4px 8px; border-radius: 4px; background: #5bc0de; color: #fff;">
                                        Name: {{ request('search') }}
                                    </span>
                                @endif
                                @if(request('date'))
                                    <span class="label label-info" style="padding: 4px 8px; border-radius: 4px; background: #5bc0de; color: #fff; margin-left: 4px;">
                                        Date: {{ date('d M Y', strtotime(request('date'))) }}
                                    </span>
                                @endif
                                <a href="{{ route('admin.users.prediction') }}" class="text-danger ml-2" style="font-size: 12px;">
                                    <i class="fa fa-times"></i> Clear filters
                                </a>
                            </div>
                        @endif

                        {{-- Winners form --}}
                        <form method="POST" action="{{ route('admin.winners.mark') }}" id="winnersForm">
                            @csrf
                            <section id="no-more-tables">
                                <table class="table table-bordered table-striped table-condensed cf" id="predictionsTable">
                                    <thead class="cf">
                                    <tr>
                                        <th style="width: 40px;">
                                            <input type="checkbox" id="selectAll" title="Select All">
                                        </th>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th class="numeric">Email</th>
                                        <th class="numeric">Game</th>
                                        <th class="numeric">Permutation</th>
                                        <th class="numeric">Numbers</th>
                                        <th class="numeric">Play Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($obj as $key => $play)
                                        <tr>
                                            <td>
                                                <input type="checkbox"
                                                       name="entries[]"
                                                       class="entry-checkbox"
                                                       value="{{ $play->id }}"
                                                       data-user="{{ $play->user_id ?? '' }}"
                                                       data-lottery="{{ $play->lottery_id ?? '' }}">
                                            </td>
                                            <td data-title="Code">{{ ($obj->currentPage() - 1) * $obj->perPage() + $key + 1 }}</td>
                                            <td data-title="Name">{{ $play->user->name ?? '' }}</td>
                                            <td data-title="Email">{{ $play->user->email ?? '' }}</td>
                                            <td data-title="Game">
                                                <span style="display:block; font-weight: bold">{{ $play->lottery->game->name ?? '' }}</span>
                                                <span style="display:block">{{ $play->game_name ?? '' }}</span>
                                            </td>
                                            <td data-title="Permutation">{{ $play->lottery->name ?? '' }}</td>
                                            <td data-title="Numbers">
                                                <textarea rows="3" cols="5">{{ $play->numbers ?? '' }}</textarea>
                                            </td>
                                            <td data-title="Play Date">{{ $play->created_at ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <span id="selectedCount" class="text-muted">0 entries selected</span>
                                        &nbsp;|&nbsp;
                                        <span class="text-muted">Total: {{ $obj->total() }} records</span>
                                    </div>
                                    <div>
                                        {{ $obj->appends(request()->query())->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>

                            </section>
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </section>

    @push('scripts')
        <script>
            $(document).ready(function() {

                // DataTable for client-side search on current page results
                var table = $('#predictionsTable').DataTable({
                    responsive: true,
                    paging:     false,
                    info:       false,
                    columnDefs: [
                        { orderable: false, targets: 0 }
                    ]
                });

                // Select all checkbox
                $('#selectAll').change(function() {
                    $('.entry-checkbox').prop('checked', $(this).is(':checked'));
                    updateSelectedCount();
                });

                // Individual checkbox change
                $(document).on('change', '.entry-checkbox', function() {
                    let total   = $('.entry-checkbox').length;
                    let checked = $('.entry-checkbox:checked').length;
                    $('#selectAll').prop('checked', total === checked);
                    updateSelectedCount();
                });

                // Update count and button state
                function updateSelectedCount() {
                    let checked = $('.entry-checkbox:checked').length;
                    $('#selectedCount').text(checked + ' entr' + (checked == 1 ? 'y' : 'ies') + ' selected');
                    $('#markWinnersBtn').prop('disabled', checked === 0);
                }

                // Mark winners button
                $('#markWinnersBtn').click(function() {
                    let checked = $('.entry-checkbox:checked').length;
                    if (checked === 0) {
                        alert('Please select at least one entry.');
                        return;
                    }
                    if (confirm('Mark ' + checked + ' selected entr' + (checked == 1 ? 'y' : 'ies') + ' as winners?')) {
                        $('#winnersForm').submit();
                    }
                });

            });
        </script>
    @endpush

@endsection
