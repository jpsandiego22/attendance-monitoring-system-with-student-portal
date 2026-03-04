@if(in_array(Auth::user()->user_type, [0, 1]))
    {{ $slot }}
@endif