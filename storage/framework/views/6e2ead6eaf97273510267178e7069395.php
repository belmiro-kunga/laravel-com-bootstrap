<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['user' => null]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['user' => null]); ?>
<?php foreach (array_filter((['user' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $user = $user ?? auth()->user();
    
    $menuItems = [
        [
            'title' => 'Dashboard',
            'route' => 'dashboard.index',
            'icon' => 'fas fa-tachometer-alt',
            'permission' => null
        ],
        [
            'title' => 'Denúncias',
            'route' => 'denuncias.index',
            'icon' => 'fas fa-exclamation-triangle',
            'permission' => 'denuncias.menu'
        ],
        [
            'title' => 'Categorias',
            'route' => 'categorias.index',
            'icon' => 'fas fa-tags',
            'permission' => 'categorias.menu'
        ],
        [
            'title' => 'Relatórios',
            'route' => 'dashboard.relatorios',
            'icon' => 'fas fa-chart-bar',
            'permission' => 'relatorios.menu'
        ],
        [
            'title' => 'Usuários',
            'route' => 'users.index',
            'icon' => 'fas fa-users',
            'permission' => 'usuarios.menu'
        ],
        [
            'title' => 'Auditoria',
            'route' => 'audit.index',
            'icon' => 'fas fa-history',
            'permission' => 'auditoria.menu'
        ],
        [
            'title' => 'Configurações',
            'route' => 'system-config.index',
            'icon' => 'fas fa-cogs',
            'permission' => 'system-config.menu'
        ],
        [
            'title' => 'Configuração de Email',
            'route' => 'email-config.index',
            'icon' => 'fas fa-envelope',
            'permission' => 'system-config.menu'
        ],
        [
            'title' => 'Permissões',
            'route' => 'permissions.index',
            'icon' => 'fas fa-key',
            'permission' => 'manage-system-config'
        ]
    ];
?>

<nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="text-center mb-4">
            <h4 class="text-white">
                <i class="fas fa-shield-alt"></i>
                <?php echo e(\App\Helpers\ConfigHelper::get('site_name', 'Sistema de Denúncias')); ?>

            </h4>
            <small class="text-white-50"><?php echo e(\App\Helpers\ConfigHelper::get('site_description', 'Corporativas')); ?></small>
        </div>
        
        <ul class="nav flex-column">
            <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!$item['permission'] || $user->hasPermission($item['permission'])): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs($item['route'] . '*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route($item['route'])); ?>">
                            <i class="<?php echo e($item['icon']); ?>"></i>
                            <?php echo e($item['title']); ?>

                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <li class="nav-item mt-4">
                <a class="nav-link" href="<?php echo e(route('denuncias.formulario-publico')); ?>" target="_blank">
                    <i class="fas fa-plus-circle"></i>
                    Nova Denúncia
                </a>
            </li>
        </ul>
        
        <?php if(auth()->guard()->check()): ?>
        <hr class="text-white-50">
        
        <div class="px-3">
            <small class="text-white-50">Usuário</small>
            <div class="d-flex align-items-center mt-2">
                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-user text-primary"></i>
                </div>
                <div class="ms-3">
                    <div class="text-white"><?php echo e($user->name); ?></div>
                    <small class="text-white-50"><?php echo e($user->role_label); ?></small>
                </div>
            </div>
            
            <div class="mt-3">
                <a href="<?php echo e(route('users.perfil')); ?>" class="btn btn-outline-light btn-sm w-100 mb-2">
                    <i class="fas fa-user-edit"></i> Meu Perfil
                </a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="redirect_to" value="<?php echo e(url('/admin')); ?>">
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-outline-light btn-sm w-100">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </a>
            </div>
        </div>
        <?php else: ?>
        <hr class="text-white-50">
        
        <div class="px-3">
            <div class="mt-3">
                <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-light btn-sm w-100">
                    <i class="fas fa-sign-in-alt"></i> Entrar
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</nav> <?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/components/admin/sidebar.blade.php ENDPATH**/ ?>