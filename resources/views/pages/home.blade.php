@extends('layouts.app')

@section('content')
    @include('sections.home.hero')
    @include('sections.home.intro')
    @include('sections.home.core')
    @include('sections.home.products')
    @include('sections.home.industries')
    @include('sections.home.process')
    @include('sections.home.work')
    @include('sections.home.export')
    @include('sections.home.why')
    @include('sections.home.clients')
    <x-closing-cta :c="$t['home']['cta']" image="cta-bg.webp" />
@endsection
