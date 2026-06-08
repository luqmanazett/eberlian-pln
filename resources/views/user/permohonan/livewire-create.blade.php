@extends('components.pln-layout')

@section('title', 'Form Permohonan - E-Berlian')
@section('header-title', 'Permohonan')

@section('content')
    <livewire:form-permohonan :jenis="$jenis" />
@endsection
