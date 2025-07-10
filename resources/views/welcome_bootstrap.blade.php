@extends('layouts.app')

@section('title', \App\Helpers\ConfigHelper::get('site_name', 'Sistema Corporativo'))

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
@endpush

@section('content')
<div class="container py-5">
    <!-- Menu de navegação -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow mb-4">
        <div class="container-fluid">
            <a class="navbar-brand text-primary fw-bold" href="#">
                <img src="{{ \App\Helpers\ConfigHelper::get('logo_url', '/images/logo.png') }}" alt="Logo" height="40" class="me-2">
                {{ \App\Helpers\ConfigHelper::get('site_name', 'Sistema Corporativo') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#sobre">Sobre</a></li>
                    <li class="nav-item"><a class="nav-link" href="#recursos">Recursos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contato">Contato</a></li>
                    <li class="nav-item"><a class="btn btn-primary ms-2" href="{{ route('login') }}">Entrar</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Slider/Carrossel -->
    <div id="homeCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner rounded shadow">
            @for($i = 1; $i <= 3; $i++)
                <div class="carousel-item @if($i == 1) active @endif">
                    <img src="{{ \App\Helpers\ConfigHelper::get('home_slider_image_' . $i, '/images/slider_default.jpg') }}" class="d-block w-100" alt="Slide {{ $i }}">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                        <h5>{{ \App\Helpers\ConfigHelper::get('home_slider_title_' . $i, 'Bem-vindo ao Sistema Corporativo') }}</h5>
                        <p>{{ \App\Helpers\ConfigHelper::get('home_slider_text_' . $i, 'Sua plataforma segura e eficiente.') }}</p>
                    </div>
                </div>
            @endfor
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
        </button>
    </div>

    <!-- Seção Sobre -->
    <section id="sobre" class="mb-5">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <h2 class="fw-bold text-primary mb-3">{{ \App\Helpers\ConfigHelper::get('home_about_title', 'Sobre o Sistema') }}</h2>
                <p class="lead">{{ \App\Helpers\ConfigHelper::get('home_about_text', 'Nossa missão é garantir um ambiente ético e seguro para todos.') }}</p>
            </div>
            <div class="col-md-6 text-center">
                <img src="{{ \App\Helpers\ConfigHelper::get('home_about_image', '/images/about_default.jpg') }}" alt="Sobre" class="img-fluid rounded shadow">
            </div>
        </div>
    </section>

    <!-- Seção Recursos -->
    <section id="recursos" class="mb-5">
        <h2 class="fw-bold text-primary mb-4 text-center">{{ \App\Helpers\ConfigHelper::get('home_features_title', 'Recursos do Sistema') }}</h2>
        <div class="row g-4">
            @for($i = 1; $i <= 3; $i++)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center">
                            <i class="fas fa-check-circle fa-2x text-primary mb-3"></i>
                            <h5 class="card-title">{{ \App\Helpers\ConfigHelper::get('home_feature_' . $i . '_title', 'Recurso ' . $i) }}</h5>
                            <p class="card-text">{{ \App\Helpers\ConfigHelper::get('home_feature_' . $i . '_text', 'Descrição do recurso ' . $i) }}</p>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </section>

    <!-- Seção Contato -->
    <section id="contato" class="mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h2 class="fw-bold text-primary mb-3">Fale Conosco</h2>
                        <form>
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" placeholder="Seu nome">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" placeholder="Seu e-mail">
                            </div>
                            <div class="mb-3">
                                <label for="mensagem" class="form-label">Mensagem</label>
                                <textarea class="form-control" id="mensagem" rows="4" placeholder="Digite sua mensagem"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush