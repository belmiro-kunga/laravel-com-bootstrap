<?php $__env->startSection('title', 'Página não encontrada'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container text-center mt-5">
        <h1>404</h1>
        <p>Página não encontrada.</p>
        <a href="<?php echo e(url('/')); ?>" class="btn btn-primary">Voltar para o início</a>
    </div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Kunga\Documents\GitHub\laravel-com-bootstrap\resources\views/errors/404.blade.php ENDPATH**/ ?>