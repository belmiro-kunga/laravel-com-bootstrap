// Botão flutuante para novo usuário
document.addEventListener('DOMContentLoaded', function() {
    // Verifica se o botão já existe para evitar duplicação
    if (document.getElementById('new-user-fab')) return;

    // Cria o botão flutuante
    const fab = document.createElement('button');
    fab.id = 'new-user-fab';
    fab.className = 'btn btn-primary btn-lg rounded-circle position-fixed';
    fab.style.cssText = 'bottom: 30px; right: 30px; width: 60px; height: 60px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); z-index: 1000;';
    fab.setAttribute('data-bs-toggle', 'modal');
    fab.setAttribute('data-bs-target', '#modalUsuario');
    fab.setAttribute('title', 'Adicionar Novo Usuário');
    fab.innerHTML = '<i class="fas fa-plus"></i>';
    
    // Adiciona o evento de clique
    fab.addEventListener('click', function() {
        const form = document.getElementById('formUsuario');
        const modalTitle = document.getElementById('modalUsuarioLabel');
        
        if (form && modalTitle) {
            form.reset();
            modalTitle.textContent = 'Novo Usuário';
            
            // Remove qualquer método PUT/PATCH existente
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) {
                methodInput.remove();
            }
            
            // Define a URL correta para criação de novo usuário
            form.action = form.getAttribute('data-base-url') || '/users';
            
            // Habilita os campos de senha se estiverem desabilitados
            const passwordFields = form.querySelectorAll('input[type="password"]');
            passwordFields.forEach(field => {
                field.required = true;
                field.disabled = false;
            });
        }
    });
    
    // Adiciona o botão ao corpo do documento
    document.body.appendChild(fab);
});
