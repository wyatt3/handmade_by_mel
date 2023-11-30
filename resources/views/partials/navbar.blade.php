<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container px-4 px-lg-5">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ route('home') }}">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
            </ul>
            <div class="d-flex">
                <cart-button></cart-button>
            </div>
        </div>
    </div>
</nav>