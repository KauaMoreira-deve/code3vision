
<header class="header">
  <div class="container">
    
    <div class="logo">
      <a href="{{ url('/') }}">Pingo Decor</a>
    </div>

    <button class="menu-toggle" onclick="toggleMenu()">☰</button>

    <nav class="menu" id="menu">
      <ul>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ asset('pingoDecor/sobre.html') }}">Sobre</a></li>
        <li><a href="{{ asset('pingoDecor/+projetos.html') }}">Projetos</a></li>
        <li><a href="{{ asset('pingoDecor/publicacoes.html') }}">Publicações</a></li>
        <li><a href="{{ asset('pingoDecor/contato.html') }}">Contato</a></li>
      </ul>
    </nav>

  </div>
</header>
