@extends('components.pln-layout')

@section('title', 'Form Permohonan - SIPEL PLN')
@section('header-title', 'Permohonan')

@section('content')
    <livewire:form-permohonan :jenis="$jenis" />
@endsection
