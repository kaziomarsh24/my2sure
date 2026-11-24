@extends('admin.layout')
@section('title','Edit Games')
@push('styles')

    <link href="css/style-responsive.css" rel="stylesheet">
    <link href="css/table-responsive.css" rel="stylesheet">
@endpush
@section('content')
    <section id="main-content">
        <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> {{ $pageTitle   }} - </h3>

            <div class="row mt">

                <div class="col-lg-12">
                    <div class="content-panel  col-md-12">
                        <h4> {{ $pageTitle   }}</h4>
                        <hr/>
                        <form action="{{route('admin.general.update' , ['general' => 1])}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="form-group col-md-4">
                                <label>{{ $arrSetting['site_title'] }}</label>
                                <input type="text" value="{{$objData->firstWhere('name', 'site_title')->detail}}" class="form-control" name="site_title" required>
                            </div>
                            <div class="form-group col-md-6 " style="display: none">
                                <label>{{ $arrSetting['free_mode'] }}</label>
                                <select  class="form-control" name="free_mode" required>
                                    <option value="0" {{ $objData->firstWhere('name', 'free_mode')->detail == 0 ? 'selected' : "" }}>Free</option>
                                    <option value="1" {{ $objData->firstWhere('name', 'free_mode')->detail == 1 ? 'selected' : "" }}>Paid</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{ $arrSetting['two_sure_free_mode'] }}</label>
                                <select  class="form-control" name="two_sure_free_mode" required>
                                    <option value="0" {{ $objData->firstWhere('name', 'two_sure_free_mode')->detail == 0 ? 'selected' : "" }}>Free</option>
                                    <option value="1" {{ $objData->firstWhere('name', 'two_sure_free_mode')->detail == 1 ? 'selected' : "" }}>Paid</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{ $arrSetting['all_games_free_mode'] }}</label>
                                <select  class="form-control" name="all_games_free_mode" required>
                                    <option value="0" {{ $objData->firstWhere('name', 'all_games_free_mode')->detail == 0 ? 'selected' : "" }}>Free</option>
                                    <option value="1" {{ $objData->firstWhere('name', 'all_games_free_mode')->detail == 1 ? 'selected' : "" }}>Paid</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label>{{ $arrSetting['site_details'] }}</label>
                                <input type="text" value="{{$objData->firstWhere('name', 'site_details')->detail}}" class="form-control" name="site_details" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{ $arrSetting['email'] }}</label>
                                <input type="text" value="{{$objData->firstWhere('name', 'email')->detail}}" class="form-control" name="email" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ $arrSetting['phone'] }}</label>
                                <input type="text" value="{{$objData->firstWhere('name', 'phone')->detail}}" class="form-control" name="phone" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ $arrSetting['logo'] }}</label>
                                <input type="file"  class="form-control" name="logo"  >
                            </div>
                            <div class="form-group col-md-6">
                                <img src="{{asset('assets/images/'.$objData->firstWhere('name', 'logo')->detail)}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label>{{ $arrSetting['sub_name'] }}</label>
                                <input type="text" value="{{$objData->firstWhere('name', 'sub_name')->detail}}" class="form-control" name="sub_name" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label>{{ $arrSetting['sub_details'] }}</label>
                                <input type="text" value="{{$objData->firstWhere('name', 'sub_details')->detail}}" class="form-control" name="sub_details" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label>{{ $arrSetting['sub_price'] }}</label>
                                <input type="text" value="{{$objData->firstWhere('name', 'sub_price')->detail}}" class="form-control" name="sub_price" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label>{{ $arrSetting['sub_renew'] }}</label>
                                <input type="date" value="{{date('Y-m-d',strtotime($objData->firstWhere('name', 'sub_renew')->detail))}}" class="form-control" name="sub_renew" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label>VIP Button Label</label>
                                <input type="text" value="{{$objData->firstWhere('name', 'vip_button_label')->detail ?? ''}}" class="form-control" name="vip_button_label" placeholder="e.g. JOIN VIP NOW">
                            </div>
                            <div class="form-group col-md-6">
                                <label>VIP Button Link (URL)</label>
                                <input type="text" value="{{$objData->firstWhere('name', 'vip_button_link')->detail ?? ''}}" class="form-control" name="vip_button_link" placeholder="https://...">
                            </div>
                            {{-- SHOP BUTTON --}}
                            <div class="form-group col-md-6">
                                <label>Shop Button Label</label>
                                <input type="text" value="{{$objData->firstWhere('name', 'shop_button_label')->detail ?? 'Shop'}}" class="form-control" name="shop_button_label">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Shop Button Link (URL)</label>
                                <input type="text" value="{{$objData->firstWhere('name', 'shop_button_link')->detail ?? ''}}" class="form-control" name="shop_button_link" placeholder="https://...">
                            </div>

                            {{-- MUSIC BUTTON --}}
                            <div class="form-group col-md-6">
                                <label>Music Button Label</label>
                                <input type="text" value="{{$objData->firstWhere('name', 'music_button_label')->detail ?? 'Music'}}" class="form-control" name="music_button_label">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Music Button Link (URL)</label>
                                <input type="text" value="{{$objData->firstWhere('name', 'music_button_link')->detail ?? ''}}" class="form-control" name="music_button_link" placeholder="https://...">
                            </div>

                            {{-- WINNING RESULTS BUTTON --}}
                            <div class="form-group col-md-6">
                                <label>Winning Results Button Label</label>
                                <input type="text" value="{{$objData->firstWhere('name', 'results_button_label')->detail ?? 'Winning Results'}}" class="form-control" name="results_button_label">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Winning Results Button Link (URL)</label>
                                <input type="text" value="{{$objData->firstWhere('name', 'results_button_link')->detail ?? ''}}" class="form-control" name="results_button_link" placeholder="https://...">
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{ $arrSetting['meta_keywords'] }}</label>
                                <input type="text" value="{{$objData->firstWhere('name', 'meta_keywords')->detail}}" class="form-control" name="meta_keywords" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label>{{ $arrSetting['meta_details'] }}</label>
                                <input type="text" value="{{$objData->firstWhere('name', 'meta_details')->detail}}" class="form-control" name="meta_details" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>2Sure Time Restriction (6am - 7pm)</label>
                                <select class="form-control" name="giveaway_time_restriction">
                                    <option value="1" {{ $objData->firstWhere('name', 'giveaway_time_restriction')->detail == 1 ? 'selected' : '' }}>ON (Restricted to 6am-7pm)</option>
                                    <option value="0" {{ $objData->firstWhere('name', 'giveaway_time_restriction')->detail == 0 ? 'selected' : '' }}>OFF (Allow All Times)</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label>About Us Content</label>
                                <textarea class="form-control" name="about_us_content" id="about_us_content" rows="10">
                                    {!! $objData->firstWhere('name', 'about_us_content')->detail ?? '' !!}
                                </textarea>
                            </div>

                            <hr>
                            <h5 class="col-md-12 mb-3"><strong>Subscription Settings</strong></h5>

                            {{-- VIP Room --}}
                            <div class="form-group col-md-4">
                                <label>VIP Room Access</label>
                                <select class="form-control" name="vip_mode">
                                    <option value="0" {{ ($objData->firstWhere('name','vip_mode')->detail ?? '0') == '0' ? 'selected' : '' }}>Free (No Gate)</option>
                                    <option value="1" {{ ($objData->firstWhere('name','vip_mode')->detail ?? '0') == '1' ? 'selected' : '' }}>Paid (Subscription Required)</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>VIP Subscription Price</label>
                                <input type="number" class="form-control" name="vip_sub_price"
                                       value="{{ $objData->firstWhere('name','vip_sub_price')->detail ?? '10' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>VIP Subscription Duration (days)</label>
                                <input type="number" class="form-control" name="vip_sub_duration"
                                       value="{{ $objData->firstWhere('name','vip_sub_duration')->detail ?? '30' }}">
                            </div>

                            {{-- 2Sure --}}
                            <div class="form-group col-md-4">
                                <label>2Sure Competition Access</label>
                                <select class="form-control" name="two_sure_mode">
                                    <option value="0" {{ ($objData->firstWhere('name','two_sure_mode')->detail ?? '0') == '0' ? 'selected' : '' }}>Free (No Gate)</option>
                                    <option value="1" {{ ($objData->firstWhere('name','two_sure_mode')->detail ?? '0') == '1' ? 'selected' : '' }}>Paid (Subscription Required)</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>2Sure Subscription Price</label>
                                <input type="number" class="form-control" name="two_sure_sub_price"
                                       value="{{ $objData->firstWhere('name','two_sure_sub_price')->detail ?? '5' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>2Sure Subscription Duration (days)</label>
                                <input type="number" class="form-control" name="two_sure_sub_duration"
                                       value="{{ $objData->firstWhere('name','two_sure_sub_duration')->detail ?? '30' }}">
                            </div>

                            {{-- All Games --}}
                            <div class="form-group col-md-4">
                                <label>All Games Access</label>
                                <select class="form-control" name="all_games_mode">
                                    <option value="0" {{ ($objData->firstWhere('name','all_games_mode')->detail ?? '0') == '0' ? 'selected' : '' }}>Free (No Gate)</option>
                                    <option value="1" {{ ($objData->firstWhere('name','all_games_mode')->detail ?? '0') == '1' ? 'selected' : '' }}>Paid (Subscription Required)</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>All Games Subscription Price</label>
                                <input type="number" class="form-control" name="all_games_sub_price"
                                       value="{{ $objData->firstWhere('name','all_games_sub_price')->detail ?? '5' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>All Games Subscription Duration (days)</label>
                                <input type="number" class="form-control" name="all_games_sub_duration"
                                       value="{{ $objData->firstWhere('name','all_games_sub_duration')->detail ?? '30' }}">
                            </div>

                            <hr>
                            <h5 class="col-md-12 mb-3"><strong>Reward Settings</strong></h5>
                            <div class="form-group col-md-4">
                                <label>Reward Amount (USD)</label>
                                <input type="number" class="form-control" name="reward_amount"
                                       value="{{ $objData->firstWhere('name','reward_amount')->detail ?? '10' }}">
                            </div>

                            <hr>
                            <h5 class="col-md-12 mb-3"><strong>VIP Landing Page</strong></h5>
                            <p class="col-md-12" style="color:#888;margin-bottom:15px;">
                                These control the new VIP landing page (description, intro video and the four subscription tiers).
                            </p>

                            <div class="form-group col-md-12">
                                <label>VIP YouTube Video URL</label>
                                <input type="text" class="form-control" name="vip_video_url"
                                       value="{{ $objData->firstWhere('name','vip_video_url')?->detail ?? '' }}"
                                       placeholder="https://www.youtube.com/watch?v=...">
                                <small style="color:#999;">Paste a normal YouTube link. Leave blank to hide the video.</small>
                            </div>

                            <div class="form-group col-md-3">
                                <label>VIP Price - 1 Day</label>
                                <input type="number" step="0.01" min="0" class="form-control" name="vip_price_day"
                                       value="{{ $objData->firstWhere('name','vip_price_day')?->detail ?? '1' }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label>VIP Price - 1 Week</label>
                                <input type="number" step="0.01" min="0" class="form-control" name="vip_price_week"
                                       value="{{ $objData->firstWhere('name','vip_price_week')?->detail ?? '5' }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label>VIP Price - 1 Month</label>
                                <input type="number" step="0.01" min="0" class="form-control" name="vip_price_month"
                                       value="{{ $objData->firstWhere('name','vip_price_month')?->detail ?? '15' }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label>VIP Price - 1 Year</label>
                                <input type="number" step="0.01" min="0" class="form-control" name="vip_price_year"
                                       value="{{ $objData->firstWhere('name','vip_price_year')?->detail ?? '100' }}">
                            </div>

                            <div class="form-group col-md-12">
                                <label>VIP Description (shown on landing page)</label>
                                <textarea class="form-control" name="vip_description" id="vip_description" rows="8">{!! $objData->firstWhere('name','vip_description')?->detail ?? '' !!}</textarea>
                            </div>

                            <div class="form-group col-md-12 pull-right ">
                                <input type="submit" value="SUBMIT" class="btn btn-lg btn-success pull-right" >
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </section>
        </section>

@endsection
@push('scripts')
    <script src="https://cdn.tiny.cloud/1/vdueyo3bcyr6me5uw9ndyjay7snynbqqv8rxo90diozr3j04/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#about_us_content, #vip_description',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            height: 400,
        });
    </script>
@endpush