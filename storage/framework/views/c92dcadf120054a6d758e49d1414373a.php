<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo e(\App\Helpers\ConfigHelper::get('site_description', 'Sistema de Denúncias Seguro e Confiável')); ?>">
    <title><?php echo e(\App\Helpers\ConfigHelper::get('site_name', 'Sistema de Denúncias')); ?></title>

    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(\App\Helpers\ConfigHelper::get('favicon_url', asset('favicon.ico'))); ?>" type="image/x-icon">

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
            <a class="navbar-brand fw-bold" href="<?php echo e(url('/')); ?>">
                <img src="<?php echo e(\App\Helpers\ConfigHelper::get('logo_url', asset('img/logo-white.png'))); ?>" alt="<?php echo e(\App\Helpers\ConfigHelper::get('site_name', 'Sistema de Denúncias')); ?>" height="40" class="me-2">
                <?php echo e(\App\Helpers\ConfigHelper::get('site_name', 'Sistema de Denúncias')); ?>

            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <a href="<?php echo e(route('denuncias.formulario-publico')); ?>" class="btn btn-outline-light">
                            <i class="fas fa-exclamation-triangle me-2"></i>Fazer Denúncia
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('rastreamento.publico')); ?>" class="btn btn-light text-primary">
                            <i class="fas fa-search-location me-2"></i>Rastrear Denúncia
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="min-vh-100 d-flex align-items-center" style="background: linear-gradient(135deg, #3a5f8d 0%, #2c3e50 100%); color: #fff;">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-4 fw-bold mb-4">Faça sua <span class="text-warning">denúncia</span> de forma segura e anônima</h1>
                    <p class="lead mb-4">Proteja sua comunidade com nosso sistema de denúncias online. Rápido, seguro e totalmente sigiloso.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="<?php echo e(route('denuncias.formulario-publico')); ?>" class="btn btn-warning btn-lg px-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>Fazer Denúncia
                        </a>
                        <a href="<?php echo e(route('rastreamento.publico')); ?>" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-search-location me-2"></i>Rastrear Denúncia
                        </a>
                    </div>
                    <div class="mt-4 d-flex flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>100% Anônimo</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Fácil de usar</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left">
                    <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1581094271901-8022df4466f9?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80" 
                             alt="Segurança" 
                             class="img-fluid"
                             style="width: 100%; height: 400px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                <i class="fas fa-user-shield text-primary" style="font-size: 1.8rem;"></i>
                            </div>
                            <h4 class="h5 mb-3">Totalmente Anônimo</h4>
                            <p class="text-muted mb-0">Sua identidade é preservada em todas as etapas do processo de denúncia.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                <i class="fas fa-shield-alt text-primary" style="font-size: 1.8rem;"></i>
                            </div>
                            <h4 class="h5 mb-3">Segurança Garantida</h4>
                            <p class="text-muted mb-0">Utilizamos criptografia avançada para proteger todas as informações.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                <i class="fas fa-mobile-alt text-primary" style="font-size: 1.8rem;"></i>
                            </div>
                            <h4 class="h5 mb-3">Acesso Fácil</h4>
                            <p class="text-muted mb-0">Interface intuitiva e responsiva para qualquer dispositivo.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                    <h2 class="fw-bold mb-4">Como funciona</h2>
                    <div class="d-flex mb-4">
                        <div class="me-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold mb-2" style="width: 40px; height: 40px;">1</div>
                        </div>
                        <div>
                            <h4 class="h5">Preencha o formulário</h4>
                            <p class="text-muted mb-0">Forneça os detalhes da ocorrência de forma clara e objetiva.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="me-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold mb-2" style="width: 40px; height: 40px;">2</div>
                        </div>
                        <div>
                            <h4 class="h5">Receba o protocolo</h4>
                            <p class="text-muted mb-0">Anote o número de protocolo para acompanhar o andamento.</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="me-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold mb-2" style="width: 40px; height: 40px;">3</div>
                        </div>
                        <div>
                            <h4 class="h5">Acompanhe sua denúncia</h4>
                            <p class="text-muted mb-0">Use o número do protocolo para verificar atualizações.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h3 class="h5 fw-bold mb-4">Rastreie sua denúncia</h3>
                            <form action="<?php echo e(route('rastreamento.publico')); ?>" method="GET" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label for="protocolo" class="form-label">Número do Protocolo</label>
                                    <input type="text" class="form-control form-control-lg" id="protocolo" name="protocolo" placeholder="Digite o número do protocolo" required>
                                    <div class="invalid-feedback">Por favor, informe o número do protocolo.</div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 btn-lg">
                                    <i class="fas fa-search me-2"></i>Rastrear Agora
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container py-5">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8" data-aos="zoom-in">
                    <h2 class="fw-bold mb-4">Pronto para fazer sua denúncia?</h2>
                    <p class="lead mb-4">Ajude a manter nossa comunidade segura. Sua identidade será preservada.</p>
                    <a href="<?php echo e(route('denuncias.formulario-publico')); ?>" class="btn btn-light btn-lg px-5">
                        <i class="fas fa-exclamation-triangle me-2"></i>Fazer Denúncia Agora
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(\App\Helpers\ConfigHelper::get('site_name', 'Sistema de Denúncias')); ?>. Todos os direitos reservados.</p>
            <p>
                <a href="#">Política de Privacidade</a> | 
                <a href="#">Termos de Uso</a>
            </p>
        </div>
    </footer>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inicializa AOS (Animate On Scroll)
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true
        });

        // Back to top button
        const backToTopButton = document.getElementById('backToTop');
        if (backToTopButton) {
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 300) {
                    backToTopButton.style.opacity = '1';
                    backToTopButton.style.visibility = 'visible';
                } else {
                    backToTopButton.style.opacity = '0';
                    backToTopButton.style.visibility = 'hidden';
                }
            });

            backToTopButton.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        // Validação de formulário
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        // Anima os números das estatísticas
        function animateStats() {
            const statNumbers = document.querySelectorAll('.stat-number');
            
            statNumbers.forEach(stat => {
                const target = parseInt(stat.getAttribute('data-target'));
                const duration = 2000; // 2 segundos
                const step = target / (duration / 16); // 60fps
                let current = 0;
                
                const updateNumber = () => {
                    current += step;
                    if (current < target) {
                        stat.textContent = Math.floor(current).toLocaleString();
                        requestAnimationFrame(updateNumber);
                    } else {
                        stat.textContent = target.toLocaleString();
                    }
                };
                
                updateNumber();
            });
        }

        // Inicia a animação quando a seção de estatísticas estiver visível
        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateStats();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });
            observer.observe(statsSection);
        }
        
        // Back to top button visibility on scroll
        window.addEventListener('scroll', () => {
            const backToTopButton = document.getElementById('backToTop');
            if (backToTopButton) {
                if (window.pageYOffset > 300) {
                    backToTopButton.style.opacity = '1';
                    backToTopButton.style.visibility = 'visible';
                    backToTopButton.classList.add('show');
                } else {
                    backToTopButton.style.opacity = '0';
                    backToTopButton.style.visibility = 'hidden';
                    backToTopButton.classList.remove('show');
                }
            }
        });

        backToTopButton.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
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
    <!-- CTA Section -->
    <section class="section cta-section">
        <div class="container text-center">
            <h2 class="mb-4"><?php echo e(\App\Helpers\ConfigHelper::get('home_cta_title', 'Pronto para fazer a diferença?')); ?></h2>
            <p class="lead mb-4"><?php echo e(\App\Helpers\ConfigHelper::get('home_cta_subtitle', 'Use nossos canais para registrar sua denúncia ou acompanhar um caso existente.')); ?></p>
            <a href="<?php echo e(route('denuncias.formulario-publico')); ?>" class="btn btn-light btn-lg me-2">
                <i class="fas fa-bullhorn me-2"></i> <?php echo e(\App\Helpers\ConfigHelper::get('home_cta_button_text', 'Fazer Denúncia')); ?>

            </a>
            <a href="<?php echo e(route('rastreamento.publico')); ?>" class="btn btn-outline-light btn-lg">
                <i class="fas fa-search me-2"></i> <?php echo e(\App\Helpers\ConfigHelper::get('home_cta_button_secondary', 'Rastrear Denúncia')); ?>

            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(\App\Helpers\ConfigHelper::get('site_name', 'Sistema de Denúncias')); ?>. Todos os direitos reservados.</p>
            <p>
                <a href="#">Política de Privacidade</a> | 
                <a href="#">Termos de Uso</a>
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/home.blade.php ENDPATH**/ ?>