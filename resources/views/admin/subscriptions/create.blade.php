@extends('admin.layout')
@section('title', 'Add Subscription')
@section('content')
    <section id="main-content">
        <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> Add Subscription</h3>
            <div class="row mt">
                <div class="col-lg-12">
                    <div class="content-panel col-md-8">
                        <h4>Add Manual Subscription</h4>
                        <hr>

                        <form action="{{ route('admin.subscriptions.store') }}" method="POST">
                            @csrf

                            <div class="form-group" style="position: relative;">
                                <label>Search User by Email <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    id="email_search"
                                    class="form-control"
                                    placeholder="Type email to search..."
                                    autocomplete="off"
                                >
                                <input type="hidden" name="user_id" id="user_id">

                                {{-- Dropdown results --}}
                                <div id="email_results" style="
                                display: none;
                                position: absolute;
                                top: 100%;
                                left: 0;
                                right: 0;
                                background: #fff;
                                border: 1px solid #ddd;
                                border-top: none;
                                border-radius: 0 0 6px 6px;
                                max-height: 220px;
                                overflow-y: auto;
                                z-index: 999;
                                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                            "></div>

                                {{-- Selected user display --}}
                                <div id="selected_user" style="display:none; margin-top: 8px;">
                                <span class="label label-success" style="font-size: 13px; padding: 6px 10px; border-radius: 4px; background: #27ae60; color: #fff;">
                                    <i class="fa fa-check"></i>
                                    <span id="selected_user_text"></span>
                                    <button type="button" id="clear_user" style="background:none; border:none; color:#fff; margin-left:8px; cursor:pointer; font-size:14px;">&times;</button>
                                </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Subscription Type <span class="text-danger">*</span></label>
                                <select name="type" class="form-control" required>
                                    <option value="">Select Type</option>
                                    <option value="vip">VIP Room</option>
                                    <option value="two_sure">2Sure Competition</option>
                                    <option value="all_games">All Games</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Start Date <span class="text-danger">*</span></label>
                                <input type="date" name="starts_at" class="form-control"
                                       value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="form-group">
                                <label>Expiry Date <span class="text-danger">*</span></label>
                                <input type="date" name="expires_at" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success" id="submitBtn">Add Subscription</button>
                                <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <style>
        .email-result-item {
            padding: 10px 14px;
            cursor: pointer;
            font-size: 14px;
            border-bottom: 1px solid #f5f5f5;
            transition: background 0.15s;
        }
        .email-result-item:hover {
            background: #f0f7ff;
        }
        .email-result-item .user-name {
            font-weight: 600;
            color: #333;
        }
        .email-result-item .user-email {
            color: #888;
            font-size: 12px;
        }
        .email-result-loading {
            padding: 12px 14px;
            color: #aaa;
            font-size: 13px;
            text-align: center;
        }
        .email-result-empty {
            padding: 12px 14px;
            color: #aaa;
            font-size: 13px;
            text-align: center;
        }
    </style>

    @push('scripts')
        <script>
            let searchTimer = null;
            let selectedUserId = null;

            $(document).ready(function() {

                $('#email_search').on('input', function() {
                    let query = $(this).val().trim();

                    clearTimeout(searchTimer);

                    if (query.length < 2) {
                        $('#email_results').hide();
                        return;
                    }

                    $('#email_results').show().html('<div class="email-result-loading"><i class="fa fa-spinner fa-spin"></i> Searching...</div>');

                    searchTimer = setTimeout(function() {
                        $.ajax({
                            url: '{{ route("admin.users.search") }}',
                            type: 'GET',
                            data: { q: query },
                            success: function(data) {
                                if (data.length === 0) {
                                    $('#email_results').html('<div class="email-result-empty">No users found</div>');
                                    return;
                                }

                                let html = '';
                                data.forEach(function(user) {
                                    html += `
                                <div class="email-result-item"
                                    data-id="${user.id}"
                                    data-name="${user.name}"
                                    data-email="${user.email}">
                                    <div class="user-name">${user.name}</div>
                                    <div class="user-email">${user.email}</div>
                                </div>
                            `;
                                });
                                $('#email_results').html(html);
                            },
                            error: function() {
                                $('#email_results').html('<div class="email-result-empty">Search failed. Try again.</div>');
                            }
                        });
                    }, 300);
                });

                // Select a user from results
                $(document).on('click', '.email-result-item', function() {
                    let id    = $(this).data('id');
                    let name  = $(this).data('name');
                    let email = $(this).data('email');

                    selectedUserId = id;
                    $('#user_id').val(id);
                    $('#email_search').val('').hide();
                    $('#email_results').hide();
                    $('#selected_user_text').text(name + ' — ' + email);
                    $('#selected_user').show();
                });

                // Clear selected user
                $('#clear_user').click(function() {
                    selectedUserId = null;
                    $('#user_id').val('');
                    $('#selected_user').hide();
                    $('#email_search').val('').show().focus();
                });

                // Close dropdown on outside click
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('#email_search, #email_results').length) {
                        $('#email_results').hide();
                    }
                });

                // Validate user selected before submit
                $('form').on('submit', function(e) {
                    if (!$('#user_id').val()) {
                        e.preventDefault();
                        alert('Please search and select a user first.');
                        $('#email_search').focus();
                    }
                });

            });
        </script>
    @endpush

@endsection
