@if(Auth::user()->user_type == 0)
{{ $slot }} 
@endif