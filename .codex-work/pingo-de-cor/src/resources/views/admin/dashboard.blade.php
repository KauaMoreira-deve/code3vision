@extends('layout.admin')

@section('title', 'Dashboard')
@section('page-title', 'Visão geral')

@section('content')
    <section class="page-heading">
        <div>
            <span class="eyebrow">Pingo Decor</span>
            <h1>Dashboard administrativo</h1>
            <p>Gerencie os dados e conteúdos do site em um só lugar.</p>
        </div>
    </section>

    <section class="metric-grid" aria-label="Resumo das seções">
        @foreach ($resources as $slug => $resource)
            <a class="metric-card" href="{{ route('admin.resources.index', ['resource' => $slug]) }}">
                <span class="metric-label">{{ $resource['label'] }}</span>
                <strong>{{ $totals[$slug] }}</strong>
                <span class="metric-action">Gerenciar <span aria-hidden="true">→</span></span>
            </a>
        @endforeach
    </section>

    <section class="welcome-card">
        <div class="welcome-art" aria-hidden="true"><span></span><span></span><span></span></div>
        <div>
            <span class="eyebrow">Tudo organizado</span>
            <h2>Seu conteúdo, do seu jeito.</h2>
            <p>Use as seções ao lado para criar, editar ou excluir registros. As alterações são salvas diretamente no banco de dados.</p>
        </div>
    </section>
@endsection
