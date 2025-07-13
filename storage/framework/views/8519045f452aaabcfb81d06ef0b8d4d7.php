<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo e(\App\Helpers\ConfigHelper::get('site_description', 'Sistema de Denúncias Seguro e Confiável')); ?>">
    <title><?php echo e(\App\Helpers\ConfigHelper::get('site_name', 'Sistema de Denúncias')); ?>"></title>

    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(\App\Helpers\ConfigHelper::get('favicon_url', asset('favicon.ico'))); ?>" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Animate on Scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* Variáveis CSS para cores e sombras */
        :root {
            --primary-color: #0056b3; /* Azul mais escuro para botões e detalhes */
            --secondary-color: #007bff; /* Azul padrão */
            --light-bg: #f8f9fa; /* Fundo claro */
            --dark-text: #343a40; /* Texto escuro */
            --light-text: #6c757d; /* Texto mais claro */
            --white: #ffffff;
            --shadow: rgba(0, 0, 0, 0.1);
            --border-radius: 8px;
        }

        /* Estilos globais do corpo */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: var(--light-bg);
            color: var(--dark-text);
            line-height: 1.6;
            overflow-x: hidden; /* Evita rolagem horizontal */
        }

        /* Contêiner central para conteúdo */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* --- Cabeçalho (Header) --- */
        .header {
            background-color: var(--white);
            box-shadow: 0 2px 10px var(--shadow);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease; /* Transição para efeito de rolagem */
        }

        .header.scrolled {
            padding: 10px 0;
            box-shadow: 0 1px 5px var(--shadow);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }

        .logo img {
            height: 40px; /* Tamanho do logo */
            margin-right: 10px;
            border-radius: var(--border-radius);
        }

        .nav-menu {
            display: flex;
            gap: 20px;
        }

        .nav-button {
            background-color: var(--secondary-color);
            color: var(--white);
            padding: 10px 20px;
            border: none;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 5px var(--shadow);
        }

        .nav-button:hover {
            background-color: var(--primary-color);
            transform: translateY(-2px);
        }

        /* --- Seção Hero --- */
        .hero {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            color: var(--white);
            padding: 100px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: bubble 15s infinite ease-in-out;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -70px;
            right: -70px;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: bubble 18s infinite reverse ease-in-out;
        }

        @keyframes bubble {
            0% { transform: scale(0.8) translate(0, 0); opacity: 0.8; }
            50% { transform: scale(1.2) translate(20px, -20px); opacity: 0.6; }
            100% { transform: scale(0.8) translate(0, 0); opacity: 0.8; }
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 40px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons .button {
            background-color: var(--white);
            color: var(--primary-color);
            padding: 15px 30px;
            border: none;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            margin: 0 10px;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .hero-buttons .button:hover {
            background-color: var(--light-bg);
            color: var(--secondary-color);
            transform: translateY(-3px);
        }

        /* --- Seção de Recursos (Features) --- */
        .features {
            padding: 80px 0;
            background-color: var(--white);
            text-align: center;
        }

        .features h2 {
            font-size: 2.5rem;
            margin-bottom: 60px;
            color: var(--primary-color);
            font-weight: 700;
        }

        .feature-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background-color: var(--light-bg);
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: 0 5px 15px var(--shadow);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e0e0e0;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .feature-card .icon {
            font-size: 3rem;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .feature-card p {
            color: var(--light-text);
        }

        /* --- Seção "Como Funciona" --- */
        .how-it-works {
            padding: 80px 0;
            text-align: center;
        }

        .how-it-works h2 {
            font-size: 2.5rem;
            margin-bottom: 60px;
            color: var(--primary-color);
            font-weight: 700;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-bottom: 60px;
        }

        .step-item {
            background-color: var(--white);
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: 0 5px 15px var(--shadow);
            text-align: left;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e0e0e0;
        }

        .step-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .step-item .step-number {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--secondary-color);
            color: var(--white);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.8rem;
            font-weight: 700;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        }

        .step-item h3 {
            font-size: 1.6rem;
            margin-top: 20px;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .step-item p {
            color: var(--light-text);
        }

        .tracking-section {
            background-color: var(--white);
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: 0 5px 15px var(--shadow);
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #e0e0e0;
        }

        .tracking-section h3 {
            font-size: 1.8rem;
            margin-bottom: 25px;
            color: var(--primary-color);
            font-weight: 600;
        }

        .tracking-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .tracking-form input[type="text"] {
            padding: 12px 15px;
            border: 1px solid #ced4da;
            border-radius: var(--border-radius);
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box; /* Garante que o padding não aumente a largura total */
        }

        .tracking-form .button {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 12px 25px;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .tracking-form .button:hover {
            background-color: #004085;
            transform: translateY(-2px);
        }

        /* --- Seção de Chamada para Ação (CTA) --- */
        .cta {
            background: linear-gradient(45deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: var(--white);
            padding: 80px 0;
            text-align: center;
        }

        .cta h2 {
            font-size: 3rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .cta p {
            font-size: 1.3rem;
            margin-bottom: 40px;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons .button {
            background-color: var(--white);
            color: var(--primary-color);
            padding: 18px 35px;
            border: none;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 700;
            font-size: 1.2rem;
            margin: 0 15px;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .cta-buttons .button:hover {
            background-color: var(--light-bg);
            color: var(--secondary-color);
            transform: translateY(-3px);
        }

        /* --- Rodapé --- */
        .footer {
            background-color: var(--dark-text);
            color: var(--white);
            padding: 40px 0;
            text-align: center;
            font-size: 0.9rem;
        }

        .footer p {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: var(--white);
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--secondary-color);
        }

        /* --- Contador Animado (Estilo) --- */
        .counter-section {
            padding: 60px 0;
            background-color: var(--light-bg);
            text-align: center;
        }

        .counter-section h2 {
            font-size: 2.2rem;
            margin-bottom: 40px;
            color: var(--primary-color);
            font-weight: 600;
        }

        .counter-item {
            display: inline-block;
            margin: 0 30px;
            text-align: center;
        }

        .counter-value {
            font-size: 4rem;
            font-weight: 700;
            color: var(--secondary-color);
            display: block;
            margin-bottom: 10px;
        }

        .counter-label {
            font-size: 1.2rem;
            color: var(--dark-text);
            font-weight: 500;
        }

        /* --- Responsividade --- */
        @media (max-width: 992px) {
            .hero h1 {
                font-size: 2.8rem;
            }
            .hero p {
                font-size: 1.1rem;
            }
            .nav-menu {
                gap: 15px;
            }
            .nav-button {
                padding: 8px 15px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }
            .nav-menu {
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }
            .nav-button {
                width: 100%;
                text-align: center;
            }
            .hero {
                padding: 80px 0;
            }
            .hero h1 {
                font-size: 2.2rem;
            }
            .hero p {
                font-size: 1rem;
            }
            .hero-buttons {
                display: flex;
                flex-direction: column;
                gap: 15px;
            }
            .hero-buttons .button {
                margin: 0;
                width: 100%;
            }
            .features, .how-it-works, .cta {
                padding: 60px 0;
            }
            .features h2, .how-it-works h2, .cta h2 {
                font-size: 2rem;
                margin-bottom: 40px;
            }
            .feature-cards, .steps-grid {
                grid-template-columns: 1fr;
            }
            .step-item .step-number {
                position: static;
                transform: none;
                margin: 0 auto 20px;
            }
            .tracking-section {
                padding: 30px;
            }
            .cta h2 {
                font-size: 2.5rem;
            }
            .cta p {
                font-size: 1.1rem;
            }
            .cta-buttons {
                display: flex;
                flex-direction: column;
                gap: 15px;
            }
            .cta-buttons .button {
                margin: 0;
                width: 100%;
            }
            .counter-item {
                margin: 0 15px;
            }
            .counter-value {
                font-size: 3rem;
            }
            .counter-label {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .logo {
                font-size: 1.5rem;
            }
            .logo img {
                height: 30px;
            }
            .hero h1 {
                font-size: 1.8rem;
            }
            .hero p {
                font-size: 0.9rem;
            }
            .features h2, .how-it-works h2, .cta h2 {
                font-size: 1.8rem;
            }
            .feature-card h3 {
                font-size: 1.3rem;
            }
            .step-item h3 {
                font-size: 1.4rem;
            }
            .tracking-section h3 {
                font-size: 1.5rem;
            }
            .counter-value {
                font-size: 2.5rem;
            }
            .counter-label {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Cabeçalho (Header) -->
    <header class="header" id="main-header">
        <div class="container header-content">
            <a href="<?php echo e(url('/')); ?>" class="logo">
                <img src="<?php echo e(\App\Helpers\ConfigHelper::get('logo_url', asset('images/logo.png'))); ?>" alt="Logo do Sistema">
                <?php echo e(\App\Helpers\ConfigHelper::get('site_name', 'Sistema de Denúncias')); ?>

            </a>
            <nav class="nav-menu">
                <a href="<?php echo e(route('denuncias.formulario-publico')); ?>" class="nav-button"><?php echo e(\App\Helpers\ConfigHelper::get('home_cta_button_text', 'Fazer Denúncia')); ?></a>
                <a href="<?php echo e(route('rastreamento.publico')); ?>" class="nav-button"><?php echo e(\App\Helpers\ConfigHelper::get('home_cta_button_secondary', 'Rastrear Denúncia')); ?></a>
            </nav>
        </div>
    </header>

    <!-- Seção Hero -->
    <section class="hero">
        <div class="container" data-aos="fade-up" data-aos-duration="1000">
            <h1><?php echo e(\App\Helpers\ConfigHelper::get('home_main_title', 'Sua Voz, Nossa Prioridade. Denuncie com Segurança.')); ?></h1>
            <p><?php echo e(\App\Helpers\ConfigHelper::get('home_main_paragraph', 'Um ambiente seguro e confidencial para você relatar irregularidades, garantindo que sua denúncia seja ouvida e tratada com a seriedade que merece.')); ?></p>
            <div class="hero-buttons">
                <a href="<?php echo e(route('denuncias.formulario-publico')); ?>" class="button"><?php echo e(\App\Helpers\ConfigHelper::get('home_cta_button_text', 'Fazer uma Denúncia Agora')); ?></a>
                <a href="<?php echo e(route('rastreamento.publico')); ?>" class="button"><?php echo e(\App\Helpers\ConfigHelper::get('home_cta_button_secondary', 'Rastrear Minha Denúncia')); ?></a>
            </div>
        </div>
    </section>

    <!-- Seção de Recursos (Features) -->
    <section class="features">
        <div class="container">
            <h2 data-aos="fade-up"><?php echo e(\App\Helpers\ConfigHelper::get('home_features_title', 'Por Que Escolher Nosso Sistema?')); ?></h2>
            <div class="feature-cards">
                <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon">🔒</div>
                    <h3><?php echo e(\App\Helpers\ConfigHelper::get('home_feature_1_title', 'Anonimato Garantido')); ?></h3>
                    <p><?php echo e(\App\Helpers\ConfigHelper::get('home_feature_1_text', 'Sua identidade é protegida. Você pode denunciar com total confiança, sem medo de retaliações.')); ?></p>
                </div>
                <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon">🛡️</div>
                    <h3><?php echo e(\App\Helpers\ConfigHelper::get('home_feature_2_title', 'Segurança Máxima')); ?></h3>
                    <p><?php echo e(\App\Helpers\ConfigHelper::get('home_feature_2_text', 'Utilizamos tecnologia de ponta para proteger seus dados e informações, garantindo a integridade da sua denúncia.')); ?></p>
                </div>
                <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon">🚀</div>
                    <h3><?php echo e(\App\Helpers\ConfigHelper::get('home_feature_3_title', 'Acesso Fácil')); ?></h3>
                    <p><?php echo e(\App\Helpers\ConfigHelper::get('home_feature_3_text', 'Interface intuitiva e acessível de qualquer dispositivo, tornando o processo de denúncia simples e rápido.')); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Seção "Como Funciona" -->
    <section class="how-it-works" id="fazer-denuncia">
        <div class="container">
            <h2 data-aos="fade-up"><?php echo e(\App\Helpers\ConfigHelper::get('home_how_title', 'Como Funciona o Processo de Denúncia?')); ?></h2>
            <div class="steps-grid">
                <div class="step-item" data-aos="fade-right">
                    <div class="step-number">1</div>
                    <h3><?php echo e(\App\Helpers\ConfigHelper::get('home_how_step_1_title', 'Preencha o Formulário')); ?></h3>
                    <p><?php echo e(\App\Helpers\ConfigHelper::get('home_how_step_1_text', 'Descreva a situação em detalhes no nosso formulário seguro. Quanto mais informações, melhor.')); ?></p>
                </div>
                <div class="step-item" data-aos="fade-up" data-aos-delay="100">
                    <div class="step-number">2</div>
                    <h3><?php echo e(\App\Helpers\ConfigHelper::get('home_how_step_2_title', 'Receba o Protocolo')); ?></h3>
                    <p><?php echo e(\App\Helpers\ConfigHelper::get('home_how_step_2_text', 'Após o envio, você receberá um número de protocolo único para acompanhar o status da sua denúncia.')); ?></p>
                </div>
                <div class="step-item" data-aos="fade-left" data-aos-delay="200">
                    <div class="step-number">3</div>
                    <h3><?php echo e(\App\Helpers\ConfigHelper::get('home_how_step_3_title', 'Acompanhe o Andamento')); ?></h3>
                    <p><?php echo e(\App\Helpers\ConfigHelper::get('home_how_step_3_text', 'Use seu protocolo para rastrear a denúncia e ver as ações tomadas pela nossa equipe.')); ?></p>
                </div>
            </div>

            <div class="tracking-section" id="rastrear-denuncia" data-aos="fade-up" data-aos-delay="300">
                <h3><?php echo e(\App\Helpers\ConfigHelper::get('home_tracking_title', 'Rastreie Sua Denúncia')); ?></h3>
                <p><?php echo e(\App\Helpers\ConfigHelper::get('home_tracking_paragraph', 'Insira o número do protocolo que você recebeu para verificar o status da sua denúncia.')); ?></p>
                <form class="tracking-form" action="<?php echo e(route('rastreamento.publico')); ?>" method="GET">
                    <input type="text" id="tracking-code" name="protocolo" placeholder="Digite seu número de protocolo" required>
                    <button type="submit" class="button"><?php echo e(\App\Helpers\ConfigHelper::get('home_tracking_button', 'Rastrear Denúncia')); ?></button>
                </form>
            </div>
        </div>
    </section>

    <!-- Seção de Contador Animado -->
    <section class="counter-section">
        <div class="container">
            <h2 data-aos="fade-up"><?php echo e(\App\Helpers\ConfigHelper::get('home_counter_title', 'Nosso Impacto em Números')); ?></h2>
            <div class="counter-item" data-aos="fade-up" data-aos-delay="100">
                <span class="counter-value" data-target="<?php echo e(\App\Helpers\ConfigHelper::get('home_counter_1_value', '1500')); ?>">0</span>
                <span class="counter-label"><?php echo e(\App\Helpers\ConfigHelper::get('home_counter_1_label', 'Denúncias Recebidas')); ?></span>
            </div>
            <div class="counter-item" data-aos="fade-up" data-aos-delay="200">
                <span class="counter-value" data-target="<?php echo e(\App\Helpers\ConfigHelper::get('home_counter_2_value', '98')); ?>">0</span>
                <span class="counter-label"><?php echo e(\App\Helpers\ConfigHelper::get('home_counter_2_label', '% de Resolução')); ?></span>
            </div>
            <div class="counter-item" data-aos="fade-up" data-aos-delay="300">
                <span class="counter-value" data-target="<?php echo e(\App\Helpers\ConfigHelper::get('home_counter_3_value', '500')); ?>">0</span>
                <span class="counter-label"><?php echo e(\App\Helpers\ConfigHelper::get('home_counter_3_label', 'Casos Concluídos')); ?></span>
            </div>
        </div>
    </section>

    <!-- Seção de Chamada para Ação (CTA) -->
    <section class="cta">
        <div class="container" data-aos="zoom-in">
            <h2><?php echo e(\App\Helpers\ConfigHelper::get('home_cta_section_title', 'Faça a Diferença. Denuncie Agora!')); ?></h2>
            <p><?php echo e(\App\Helpers\ConfigHelper::get('home_cta_section_paragraph', 'Sua coragem em denunciar é fundamental para construir um ambiente mais justo e transparente para todos.')); ?></p>
            <div class="cta-buttons">
                <a href="<?php echo e(route('denuncias.formulario-publico')); ?>" class="button"><?php echo e(\App\Helpers\ConfigHelper::get('home_cta_section_button_1', 'Iniciar Nova Denúncia')); ?></a>
                <a href="<?php echo e(route('rastreamento.publico')); ?>" class="button"><?php echo e(\App\Helpers\ConfigHelper::get('home_cta_section_button_2', 'Verificar Status')); ?></a>
            </div>
        </div>
    </section>

    <!-- Rodapé -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(\App\Helpers\ConfigHelper::get('site_name', 'Sistema de Denúncias')); ?>. <?php echo e(\App\Helpers\ConfigHelper::get('home_footer_text', 'Todos os direitos reservados.')); ?></p>
            <div class="footer-links">
                <a href="#">Política de Privacidade</a>
                <a href="#">Termos de Uso</a>
                <a href="#">Contato</a>
            </div>
        </div>
    </footer>

    <!-- Scripts JavaScript -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inicializa AOS (Animate On Scroll)
        AOS.init({
            once: true, // Animações acontecem apenas uma vez
            duration: 800, // Duração da animação em ms
            easing: 'ease-out-quad', // Tipo de easing
        });

        // Efeito de rolagem no cabeçalho
        window.addEventListener('scroll', function() {
            const header = document.getElementById('main-header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Navegação suave (smooth scroll)
        document.querySelectorAll('.scroll-link').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Contador animado
        const counters = document.querySelectorAll('.counter-value');
        const speed = 200; // Quanto maior, mais lento

        const animateCounter = (counter) => {
            const target = +counter.getAttribute('data-target');
            let count = 0;
            const updateCount = () => {
                const increment = target / speed;
                if (count < target) {
                    count = Math.ceil(count + increment);
                    counter.innerText = count;
                    setTimeout(updateCount, 1);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        };

        // Observador de Interseção para iniciar o contador quando visível
        const counterSection = document.querySelector('.counter-section');
        if (counterSection) {
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        counters.forEach(animateCounter);
                        observer.unobserve(entry.target); // Para de observar depois de animar
                    }
                });
            }, { threshold: 0.5 }); // Inicia quando 50% da seção está visível

            observer.observe(counterSection);
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\Kunga\Documents\GitHub\laravel-com-bootstrap\resources\views/home.blade.php ENDPATH**/ ?>