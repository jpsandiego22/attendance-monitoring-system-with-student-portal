@extends('layouts.master')

@section('content')


{{Auth::id()}}




{{ Auth::user()->type->description }}
@endsection

@section('js')
<script>
   
</script>
@endsection
