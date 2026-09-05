@extends('errors.layout')

@section('code')
    <span style="background:linear-gradient(135deg,#fd7e14,#dc3545);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">403</span>
    403
@endsection

@section('title', 'Accès refusé')

@section('message')
    Vous n'avez pas les droits nécessaires pour accéder à cette page.<br>
    Veuillez vous connecter avec le bon compte ou contacter l'administrateur.
@endsection
