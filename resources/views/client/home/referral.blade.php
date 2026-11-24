@extends('client.layout')
@section('title')
    Referrals & Bank Account Details
@endsection
@section('meta_description', 'Manage your My2Sure referrals and bank account details. Earn rewards by referring friends to Africa\'s leading lottery forecasting platform.')
@section('content')
    <!-- contact-section start -->
    <!-- inner-page-banner start -->
    <section class="inner-page-banner has_bg_image" data-background="{{asset('assets/images/inner-page-bg.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-page-banner-area">
                        <h1 class="page-title">Referral Users And Bank Account Details</h1>
                        <nav aria-label="breadcrumb" class="page-header-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('client.index')}}">Home</a></li>
                                <li class="breadcrumb-item active">Referral Users And Bank Account Details</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        @include('client.slider');
    </section>
    <section class="contact-section">
        <div class="container pb-5">
            <div class="row mx-0">
                <div class="col-lg-12 px-0">
                    <button class=" btn btn-primary mx-5 my-2" onclick="copyLink(`{{ url('/')."/register/".$from_ref_code}}`)">Copy Referral Link</button>
                    <div class="contact-area row mx-0 mt-5">

                        <div class="col-lg-6">
                            <div class="mx-3 my-2 p-2 ">
                                @if($errors->any())
                                    <div class="text-center">
                                        <h4 class="text-success">{{$errors->first()}}</h4>
                                    </div>
                                @endif
                                @if(empty($account))
                                    <h3 class="title mb-3">ADD Bank Account Details</h3>
                                    <p class="mb-2">Please provide us correct information. We are not responsible for any mistake.</p>
                                    <form class="contact-form" action="{{route('client.add_bank_account')}}" method="POST">
                                        {{ csrf_field() }}
                                        <input name="status" value="1" type="hidden">
                                        <div class="form-grp">
                                            <input type="text" name="account_name" placeholder="Account Name" required>
                                        </div>
                                        <div class="form-grp">
                                            <input type="text" name="account_number" placeholder="Account number" required>
                                        </div>
                                        <div class="form-grp">
                                            <input type="text" name="bank_name"  placeholder="Bank Name" required>
                                        </div>
                                        <div class="form-grp">
                                            <input class="submit-btn" type="submit" value="Submit">
                                        </div>
                                    </form>
                                @else
                                    <h3 class="title mb-3">Update Bank Account Details</h3>
                                    <p class="mb-2">Please provide us correct information. We are not responsible for any mistake.</p>
                                    <form class="contact-form" action="{{route('client.add_bank_account')}}" method="POST">
                                        {{ csrf_field() }}
                                        <input name="status" value="0" type="hidden">

                                        <div class="form-grp">
                                            <input type="text" name="account_name" value="{{$account->account_name}}" placeholder="Account Name" required>
                                        </div>
                                        <div class="form-grp">
                                            <input type="text" name="account_number" value="{{$account->account_number}}"  placeholder="Account number" required>
                                        </div>
                                        <div class="form-grp">
                                            <input type="text" name="bank_name" value="{{$account->bank_name}}"  placeholder="Bank Name" required>
                                        </div>
                                        <div class="form-grp">
                                            <input class="submit-btn" type="submit" value="Update">
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mx-3 my-2 p-2 refferalTable">
                                <h3 class="title mb-3">Your Referral Users {{count($users)}}</h3>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Register Date </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($users as $user)

                                        <tr>
                                            <td><span class="d-block"> {{$user->name}}</span></td>
                                            <td><span class="d-block"> {{$user->email}}</span></td>
                                            <td><span class="d-block"> {{date('F d, Y',strtotime($user->created_at))}}</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" ><span class="d-block"> No Referral User</span></td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('client.partials.footer_buttons')
    <!-- contact-section end -->


@endsection

@push('scripts')
<script>
    function copyLink(link){

        navigator.clipboard.writeText(link);

        // Alert the copied text
        alert("Referral link copied successfully");
    }
</script>
@endpush
