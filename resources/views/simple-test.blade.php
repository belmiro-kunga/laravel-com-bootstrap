<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Simples</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/components.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Teste de Componentes</h1>
        
        <div class="row">
            <div class="col-md-6">
                <x-admin.card title="Card de Teste" icon="fas fa-star">
                    <p>Este é um teste do componente card.</p>
                    <x-admin.status-badge status="active" text="Funcionando" />
                </x-admin.card>
            </div>
            
            <div class="col-md-6">
                <x-admin.alert type="success" title="Sucesso!">
                    Os componentes estão funcionando!
                </x-admin.alert>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 