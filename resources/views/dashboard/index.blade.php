@extends('layouts.app')

@section('content')
@include('dashboard.partials._header')
@include('dashboard.partials._widget-categories')
@include('dashboard.partials._lead-activity-widgets')
@include('dashboard.partials._outcome-widgets')
@include('dashboard.partials._modals')
@endsection

@push('scripts')
@include('dashboard.partials._scripts')