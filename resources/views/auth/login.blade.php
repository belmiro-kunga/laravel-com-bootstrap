<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistema de Denúncias Corporativas</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4e73df;
            --primary-dark: #2e59d9;
            --secondary-color: #858796;
            --light-gray: #f8f9fc;
            --border-color: #d1d3e2;
            --error-color: #e74a3b;
            --success-color: #1cc88a;
            --box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        body {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            padding: 20px;
            line-height: 1.6;
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }
        
        .login-card {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--box-shadow);
            overflow: hidden;
            transition: all 0.3s ease;
            border: none;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
        }
        
        .login-header {
            background: var(--primary-color);
            color: white;
            text-align: center;
            padding: 2.5rem 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 60%);
            transform: rotate(30deg);
            pointer-events: none;
        }
        
        .login-header i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            width: 80px;
            height: 80px;
            line-height: 80px;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        
        .login-header h3 {
            font-weight: 600;
            margin-bottom: 0.5rem;
            position: relative;
            font-size: 1.75rem;
        }
        
        .login-header p {
            opacity: 0.9;
            margin: 0;
            font-size: 1rem;
            position: relative;
        }
        
        .card-body {
            padding: 2.5rem;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        
        .form-control {
            height: 3rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .form-control.is-invalid {
            border-color: var(--error-color);
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='%23e74a3b'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23e74a3b' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        .invalid-feedback {
            color: var(--error-color);
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: block;
        }
        
        .btn-login {
            background: var(--primary-color);
            border: none;
            border-radius: 0.5rem;
            height: 3rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login i {
            font-size: 1rem;
        }
        
        .spinner-border {
            width: 1.25rem;
            height: 1.25rem;
            border-width: 0.15em;
            display: none;
        }
        
        .btn-login.loading .spinner-border {
            display: inline-block;
        }
        
        .btn-login.loading span:not(.spinner-border) {
            display: none;
        }
        
        .form-text {
            font-size: 0.8rem;
            color: var(--secondary-color);
        }
        
        .alert {
            border-radius: 0.5rem;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            animation: fadeIn 0.3s ease-out;
        }
        
        .alert i {
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }
        
        .alert-dismissible .btn-close {
            padding: 0.75rem 1rem;
            background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
            opacity: 0.5;
        }
        
        .alert-success {
            background-color: #d1f3e0;
            color: #0a3622;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #58151c;
        }
        
        .form-check-input {
            width: 1.1em;
            height: 1.1em;
            margin-top: 0.2em;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-check-label {
            color: var(--secondary-color);
            font-size: 0.9rem;
            cursor: pointer;
        }
        
        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.2s ease;
        }
        
        .forgot-password:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: var(--secondary-color);
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border-color);
        }
        
        .divider:not(:empty)::before {
            margin-right: 1rem;
        }
        
        .divider:not(:empty)::after {
            margin-left: 1rem;
        }
        
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--secondary-color);
        }
        
        .register-link a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .register-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .back-to-home {
            display: inline-flex;
            align-items: center;
            color: var(--secondary-color);
            text-decoration: none;
            font-size: 0.9rem;
            margin-top: 1.5rem;
            transition: all 0.2s ease;
        }
        
        .back-to-home i {
            margin-right: 0.5rem;
            transition: transform 0.2s ease;
        }
        
        .back-to-home:hover {
            color: var(--primary-color);
        }
        
        .back-to-home:hover i {
            transform: translateX(-3px);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .card-body {
                padding: 2rem 1.5rem;
            }
            
            .login-header {
                padding: 2rem 1.5rem;
            }
            
            .login-header i {
                width: 70px;
                height: 70px;
                line-height: 70px;
                font-size: 2rem;
            }
            
            .login-header h3 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-shield-alt"></i>
                <h3>Sistema de Denúncias</h3>
                <p>Bem-vindo de volta! Por favor, faça login para continuar.</p>
            </div>
            
            <div class="card-body">
                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <strong>Sucesso!</strong> {{ session('status') }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shake" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Erro!</strong> {{ $errors->first() }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login.post') }}" id="loginForm" novalidate>
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="form-label">Endereço de E-mail</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="seu@email.com" required autofocus>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="form-label">Senha</label>
                            @if(Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-password">
                                    Esqueceu sua senha?
                                </a>
                            @endif
                        </div>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="••••••••" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Lembrar de mim
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-login mb-4" id="loginButton">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Entrar na Plataforma</span>
                    </button>
                    
                    @if(Route::has('register'))
                        <div class="register-link">
                            Novo no sistema? <a href="{{ route('register') }}">Criar uma conta</a>
                        </div>
                    @endif
                </form>
                
                <div class="text-center mt-5">
                    <a href="{{ route('home') }}" class="back-to-home">
                        <i class="fas fa-arrow-left"></i> Voltar para o início
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            
            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    const icon = this.querySelector('i');
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                    this.setAttribute('title', type === 'password' ? 'Mostrar senha' : 'Ocultar senha');
                });
            }
            
            // Form submission with loading state
            const form = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');
            const spinner = loginButton.querySelector('.spinner-border');
            const buttonIcon = loginButton.querySelector('i');
            const buttonText = loginButton.querySelector('span:last-child');
            
            if (form && loginButton) {
                form.addEventListener('submit', function() {
                    // Show loading state
                    spinner.style.display = 'inline-block';
                    buttonIcon.style.display = 'none';
                    buttonText.textContent = 'Entrando...';
                    loginButton.classList.add('loading');
                    loginButton.disabled = true;
                });
            }
            
            // Auto-focus email field if empty, otherwise password
            const emailField = document.getElementById('email');
            if (emailField && !emailField.value) {
                emailField.focus();
            } else if (password) {
                password.focus();
            }
            
            // Add shake effect to form on error
            const errorAlert = document.querySelector('.alert.alert-danger');
            if (errorAlert) {
                errorAlert.addEventListener('animationend', function() {
                    this.classList.remove('shake');
                });
            }
        });
    </script>
</body>
</html>