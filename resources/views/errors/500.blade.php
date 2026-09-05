@extends('errors.layout')

@section('code')
    <span style="background:linear-gradient(135deg,#6c757d,#343a40);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">500</span>
    500
@endsection

@section('title', 'Erreur serveur')

@section('message')
    Une erreur interne s'est produite. Notre équipe a été notifiée.<br>
    Veuillez réessayer dans quelques instants.
@endsection
