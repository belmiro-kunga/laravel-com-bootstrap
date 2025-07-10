<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ \App\Helpers\ConfigHelper::get('site_description', 'Sistema de Denúncias Seguro e Confiável') }}">
    <title>{{ \App\Helpers\ConfigHelper::get('site_name', 'Sistema de Denúncias') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ \App\Helpers\ConfigHelper::get('favicon_url', asset('favicon.ico')) }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Animate on Scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #3a5f8d;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-color: #f8f9fa;
            --dark-color: #2c3e50;
            --text-color: #333;
            --text-light: #6c757d;
            --transition: all 0.3s ease;
            --border-radius: 8px;
            --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --gradient-primary: linear-gradient(135deg, #3a5f8d 0%, #2c3e50 100%);
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            line-height: 1.7;
            overflow-x: hidden;
            background-color: #ffffff;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: var(--dark-color);
        }

        /* Header & Navigation */
        .navbar {
            background-color: rgba(255, 255, 255, 0.98);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            padding: 15px 0;
            transition: var(--transition);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar.scrolled {
            padding: 10px 0;
            background-color: rgba(255, 255, 255, 0.98);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand img {
            height: 50px;
            transition: var(--transition);
        }

        .navbar-nav .nav-item {
            margin: 0 8px;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--dark-color);
            padding: 8px 15px !important;
            border-radius: var(--border-radius);
            transition: var(--transition);
            position: relative;
            font-size: 15px;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--accent-color);
            transition: var(--transition);
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color);
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 70%;
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(58, 95, 141, 0.3);
            font-size: 0.9rem;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(58, 95, 141, 0.4);
            background: var(--secondary-color);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 50px;
            transition: var(--transition);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(58, 95, 141, 0.3);
        }

        .feature-card {
            background: #fff;
            border: none;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,.12);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--bs-link-color);
            margin-bottom: 20px;
        }

        .cta-section {
            background-color: #3c506e;
            color: #fff;
        }
        
        .cta-section .btn-light {
            font-weight: 600;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 40px 0;
        }
        
        .footer a {
            color: #adb5bd;
            text-decoration: none;
        }
        
        .footer a:hover {
            color: #fff;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: var(--primary-color);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <img src="{{ \App\Helpers\ConfigHelper::get('logo_url', asset('img/logo-white.png')) }}" alt="{{ \App\Helpers\ConfigHelper::get('site_name', 'Sistema de Denúncias') }}" height="40" class="me-2">
                {{ \App\Helpers\ConfigHelper::get('site_name', 'Sistema de Denúncias') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <a href="{{ route('denuncias.formulario-publico') }}" class="btn btn-outline-light">
                            <i class="fas fa-exclamation-triangle me-2"></i>Fazer Denúncia
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('rastreamento.publico') }}" class="btn btn-light text-primary">
                            <i class="fas fa-search-location me-2"></i>Rastrear Denúncia
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #3a5f8d 0%, #2c3e50 100%); color: #fff;">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                    <h1 class="display-4 fw-bold mb-4">Faça sua <span class="text-warning">denúncia</span> de forma segura e anônima</h1>
                    <p class="lead mb-4">Proteja sua comunidade com nosso sistema de denúncias online. Rápido, seguro e totalmente sigiloso.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('denuncias.formulario-publico') }}" class="btn btn-warning btn-lg px-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>Fazer Denúncia
                        </a>
                        <a href="{{ route('rastreamento.publico') }}" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-search-location me-2"></i>Rastrear Denúncia
                        </a>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <img src="https://images.unsplash.com/photo-1581094794329-c811e9f8dd53?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80" 
                         alt="Sistema de Denúncias" 
                         class="img-fluid rounded-3 shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <h3 class="h4 mb-3">Anonimato Garantido</h3>
                            <p class="text-muted">Sua identidade será mantida em sigilo total. Ninguém saberá que foi você quem fez a denúncia.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-lock"></i>
                            </div>
                            <h3 class="h4 mb-3">Segurança Máxima</h3>
                            <p class="text-muted">Utilizamos criptografia avançada para proteger todas as informações fornecidas.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <h3 class="h4 mb-3">Acesso Fácil</h3>
                            <p class="text-muted">Faça denúncias de qualquer dispositivo, a qualquer momento. Totalmente responsivo e fácil de usar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                    <h2 class="fw-bold mb-4">Como funciona</h2>
                    <div class="d-flex mb-4">
                        <div class="me-4">
                            <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle" style="width: 50px; height: 50px; font-size: 1.5rem; font-weight: bold;">1</div>
                        </div>
                        <div>
                            <h4 class="h5">Preencha o formulário</h4>
                            <p class="text-muted mb-0">Forneça os detalhes da ocorrência de forma clara e objetiva.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="me-4">
                            <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle" style="width: 50px; height: 50px; font-size: 1.5rem; font-weight: bold;">2</div>
                        </div>
                        <div>
                            <h4 class="h5">Receba o número de protocolo</h4>
                            <p class="text-muted mb-0">Anote o número para acompanhar o andamento da sua denúncia.</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="me-4">
                            <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle" style="width: 50px; height: 50px; font-size: 1.5rem; font-weight: bold;">3</div>
                        </div>
                        <div>
                            <h4 class="h5">Acompanhe o andamento</h4>
                            <p class="text-muted mb-0">Use o número do protocolo para verificar o status da sua denúncia.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="h4 mb-4">Acompanhe sua denúncia</h3>
                            <form action="{{ route('rastreamento.publico') }}" method="GET">
                                <div class="mb-3">
                                    <label for="protocolo" class="form-label">Número do Protocolo</label>
                                    <input type="text" class="form-control form-control-lg" id="protocolo" name="protocolo" placeholder="Digite o número do protocolo" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-2"></i> Acompanhar Denúncia
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 cta-section">
        <div class="container text-center">
            <h2 class="mb-4">Pronto para fazer a diferença?</h2>
            <p class="lead mb-4">Use nossos canais para registrar sua denúncia ou acompanhar um caso existente.</p>
            <a href="{{ route('denuncias.formulario-publico') }}" class="btn btn-light btn-lg me-2">
                <i class="fas fa-bullhorn me-2"></i> Fazer Denúncia
            </a>
            <a href="{{ route('rastreamento.publico') }}" class="btn btn-outline-light btn-lg">
                <i class="fas fa-search me-2"></i> Rastrear Denúncia
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} {{ \App\Helpers\ConfigHelper::get('site_name', 'Sistema de Denúncias') }}. Todos os direitos reservados.</p>
            <p>
                <a href="#">Política de Privacidade</a> | 
                <a href="#">Termos de Uso</a>
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Navbar scroll effect
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Counter animation
        const counters = document.querySelectorAll('.counter');
        const speed = 200;
        
        const animateCounters = () => {
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const increment = target / speed;
                
                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(animateCounters, 1);
                } else {
                    counter.innerText = target;
                }
            });
        };

        // Start counter when element is in viewport
        const counterSection = document.querySelector('.stats-section');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        if (counterSection) {
            observer.observe(counterSection);
        }
    </script>
</body>
</html>
