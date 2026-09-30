<!DOCTYPE html>
<html lang="pt-br">
<head>
     {{-- aqui entra o partial de head --}}
    @include('partials.head')
</head>


<body>
    {{-- //Cabeçalho --}}
    @include('partials.header')

    {{-- //Main --}}
        <main>
            {{-- // area de conteudo --}}
            @yield('content')
            
        </main>
    {{-- //Footer --}}
    @include('partials.footer')

    {{-- //scripts --}}

    @include('partials.scripts')
</body>

</html>

