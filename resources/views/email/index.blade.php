@component('mail::message')
# {{$objData['subject']}}

{!! $objData['message'] !!}.

<!-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent -->

Thanks,<br>
{{ config('app.name') }}
Support Team
@endcomponent
