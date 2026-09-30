<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Pingo Decor</title>
    <link rel="stylesheet" href="{{ asset('adminDecor/css/admin.css') }}">
</head>
<body>
    <div class="admin-shell">
        <aside class="sidebar" id="admin-sidebar">
            <a class="brand" href="{{ route('admin.dashboard') }}" aria-label="Dashboard Pingo Decor">
                <span class="brand-mark">P</span>
                <span><strong>Pingo Decor</strong><small>Painel administrativo</small></span>
            </a>

            <nav class="sidebar-nav" aria-label="Navegação administrativa">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-symbol">⌂</span> Visão geral
                </a>
                <p class="nav-heading">Conteúdo</p>
                @foreach (config('admin_resources') as $slug => $item)
                    <a href="{{ route('admin.resources.index', ['resource' => $slug]) }}"
                       class="{{ request()->route('resource') === $slug ? 'active' : '' }}">
                        <span class="nav-symbol">•</span> {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <a class="site-link" href="{{ url('/') }}" target="_blank" rel="noreferrer">
                Ver site <span aria-hidden="true">↗</span>
            </a>
        </aside>

        <div class="admin-page">
            <header class="topbar">
                <button class="menu-toggle" type="button" data-menu-toggle aria-label="Abrir menu">☰</button>
                <div>
                    <small>Administração</small>
                    <strong>@yield('page-title', 'Visão geral')</strong>
                </div>
                <div class="admin-avatar" title="Administrador">AD</div>
            </header>

            <main class="content">
                @if (session('sucesso'))
                    <div class="alert alert-success" role="status">
                        <span aria-hidden="true">✓</span> {{ session('sucesso') }}
                        <button type="button" data-dismiss-alert aria-label="Fechar">×</button>
                    </div>
                @endif
                @if (session('erro'))
                    <div class="alert alert-error" role="alert">
                        <span aria-hidden="true">!</span> {{ session('erro') }}
                        <button type="button" data-dismiss-alert aria-label="Fechar">×</button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-error" role="alert">
                        <div>
                            <strong>Revise os campos informados:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                        <button type="button" data-dismiss-alert aria-label="Fechar">×</button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ asset('adminDecor/js/admin.js') }}"></script>
    @stack('scripts')
</body>
</html>
