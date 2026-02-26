@extends('layouts.master')

@section('title', 'Home')

@section('content')

{{$request->is('login')}}
{{Auth::id()}}

{!! QrCode::size(200)->generate(Auth::user()->detail) !!}
{{ Auth::user()->type->description }}
@endsection

@section('js')
<script>
    console.log("Dashboard loaded");
</script>
@endsection
