# Componentes do Admin Panel

Esta documentação descreve todos os componentes reutilizáveis criados para o painel administrativo.

## 📁 Estrutura de Arquivos

```
resources/views/components/admin/
├── card.blade.php           # Componente de card
├── status-badge.blade.php   # Badge de status
├── data-table.blade.php     # Tabela de dados
├── modal.blade.php          # Modal
├── sidebar.blade.php        # Sidebar
├── navbar.blade.php         # Navbar
├── breadcrumb.blade.php     # Breadcrumb
├── alert.blade.php          # Alertas
└── example.blade.php        # Página de exemplo
```

## 🎨 Componentes

### 1. Card (`x-admin.card`)

Componente de card reutilizável com diferentes variantes.

**Propriedades:**
- `title` - Título do card
- `subtitle` - Subtítulo do card
- `icon` - Ícone FontAwesome
- `variant` - Variante de cor (default, primary, success, warning, danger, info)
- `hover` - Efeito hover (true/false)
- `class` - Classes CSS adicionais
- `header` - Conteúdo personalizado do cabeçalho
- `footer` - Conteúdo personalizado do rodapé
- `bodyClass` - Classes CSS para o corpo

**Exemplo:**
```blade
<x-admin.card title="Meu Card" icon="fas fa-star" variant="success">
    <p>Conteúdo do card</p>
    <button class="btn btn-primary">Ação</button>
</x-admin.card>
```

### 2. Status Badge (`x-admin.status-badge`)

Badge de status com ícones e cores automáticas.

**Propriedades:**
- `status` - Status (active, pending, completed, cancelled, urgent, high, medium, low, etc.)
- `text` - Texto personalizado
- `size` - Tamanho (small, normal, large)
- `pill` - Formato pill (true/false)
- `class` - Classes CSS adicionais

**Exemplo:**
```blade
<x-admin.status-badge status="active" text="Ativo" size="normal" />
<x-admin.status-badge status="pending" size="small" />
```

### 3. Data Table (`x-admin.data-table`)

Tabela de dados com DataTables integrado.

**Propriedades:**
- `id` - ID da tabela
- `class` - Classes CSS adicionais
- `responsive` - Responsivo (true/false)
- `searching` - Busca (true/false)
- `ordering` - Ordenação (true/false)
- `paging` - Paginação (true/false)
- `pageLength` - Itens por página
- `language` - Idioma
- `buttons` - Botões de exportação (true/false)
- `exportButtons` - Botões de exportação específicos (true/false)

**Exemplo:**
```blade
<x-admin.data-table id="myTable" :buttons="true" :exportButtons="true">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>João</td>
            <td><x-admin.status-badge status="active" /></td>
        </tr>
    </tbody>
</x-admin.data-table>
```

### 4. Modal (`x-admin.modal`)

Modal reutilizável com diferentes tamanhos.

**Propriedades:**
- `id` - ID do modal
- `title` - Título do modal
- `size` - Tamanho (modal-sm, modal-lg, modal-xl)
- `centered` - Centralizado (true/false)
- `scrollable` - Scrollável (true/false)
- `staticBackdrop` - Backdrop estático (true/false)
- `closeButton` - Botão fechar (true/false)
- `saveButton` - Botão salvar (true/false)
- `header` - Cabeçalho personalizado
- `footer` - Rodapé personalizado

**Exemplo:**
```blade
<x-admin.modal id="myModal" title="Meu Modal" size="modal-lg">
    <p>Conteúdo do modal</p>
    
    <x-slot name="footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary">Salvar</button>
    </x-slot>
</x-admin.modal>
```

### 5. Sidebar (`x-admin.sidebar`)

Sidebar com menu dinâmico baseado em permissões.

**Propriedades:**
- `user` - Usuário (opcional, usa auth()->user() por padrão)

**Exemplo:**
```blade
<x-admin.sidebar />
```

### 6. Navbar (`x-admin.navbar`)

Navbar com notificações e menu do usuário.

**Propriedades:**
- `user` - Usuário (opcional, usa auth()->user() por padrão)

**Exemplo:**
```blade
<x-admin.navbar />
```

### 7. Breadcrumb (`x-admin.breadcrumb`)

Breadcrumb de navegação.

**Propriedades:**
- `items` - Array de itens do breadcrumb

**Estrutura dos itens:**
```php
$items = [
    ['title' => 'Página', 'icon' => 'fas fa-file', 'url' => '/page'],
    ['title' => 'Subpágina', 'icon' => 'fas fa-folder']
];
```

**Exemplo:**
```blade
@php
$breadcrumbItems = [
    ['title' => 'Usuários', 'icon' => 'fas fa-users', 'url' => route('users.index')],
    ['title' => 'Editar', 'icon' => 'fas fa-edit']
];
@endphp

<x-admin.breadcrumb :items="$breadcrumbItems" />
```

### 8. Alert (`x-admin.alert`)

Alerta reutilizável com diferentes tipos.

**Propriedades:**
- `type` - Tipo (success, warning, danger, info)
- `title` - Título do alerta
- `dismissible` - Fechável (true/false)
- `icon` - Ícone personalizado
- `class` - Classes CSS adicionais

**Exemplo:**
```blade
<x-admin.alert type="success" title="Sucesso!">
    Operação realizada com sucesso.
</x-admin.alert>

<x-admin.alert type="warning">
    Atenção: Esta ação não pode ser desfeita.
</x-admin.alert>
```

## 🎯 Como Usar

### 1. Incluir no Layout

Os componentes já estão incluídos no layout principal (`resources/views/layouts/app.blade.php`).

### 2. Usar em Páginas

```blade
@extends('layouts.app')

@section('title', 'Minha Página')

@section('content')
    <x-admin.card title="Meu Card" icon="fas fa-star">
        <p>Conteúdo</p>
    </x-admin.card>
    
    <x-admin.status-badge status="active" />
    
    <x-admin.alert type="success">
        Mensagem de sucesso
    </x-admin.alert>
@endsection
```

### 3. Breadcrumb

```blade
@section('breadcrumb')
    @php
        $breadcrumbItems = [
            ['title' => 'Seção', 'icon' => 'fas fa-folder'],
            ['title' => 'Página', 'icon' => 'fas fa-file']
        ];
    @endphp
    {{ $breadcrumbItems }}
@endsection
```

## 🎨 CSS

Os estilos estão organizados em:
- `public/css/admin/main.css` - Estilos principais
- `public/css/admin/components.css` - Estilos dos componentes

### Variáveis CSS

```css
:root {
    --primary-color: #4e73df;
    --success-color: #1cc88a;
    --warning-color: #f6c23e;
    --danger-color: #e74a3b;
    --info-color: #36b9cc;
    --border-radius: 8px;
    --transition: all 0.3s ease;
}
```

## 📱 Responsividade

Todos os componentes são responsivos e se adaptam a diferentes tamanhos de tela:

- **Desktop**: Layout completo
- **Tablet**: Sidebar colapsável
- **Mobile**: Sidebar overlay

## 🔧 Personalização

### Cores

Para alterar as cores, modifique as variáveis CSS em `public/css/admin/main.css`.

### Componentes

Para personalizar componentes, edite os arquivos em `resources/views/components/admin/`.

### Novos Componentes

Para criar novos componentes:

1. Crie o arquivo em `resources/views/components/admin/`
2. Use `@props()` para definir propriedades
3. Documente o componente neste README
4. Adicione estilos em `public/css/admin/components.css`

## 🚀 Exemplo Completo

Acesse `/admin/components-example` para ver todos os componentes em ação.

## 📝 Notas

- Todos os componentes usam Bootstrap 5
- Ícones são do FontAwesome 6
- DataTables para tabelas interativas
- Select2 para selects avançados
- Chart.js para gráficos 