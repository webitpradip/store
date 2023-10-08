<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="{{route('posts.index')}}">Posts</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('posts.create')}}">Create</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('backup.download') }}">Backup</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('backup.download-db') }}">Backup DB</a>
        </li>

    </div>
</nav>
