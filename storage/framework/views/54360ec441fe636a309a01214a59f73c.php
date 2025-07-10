

<?php $__env->startSection('title', 'Tratar Denúncia'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h1>Tratar Denúncia</h1>

    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    
    <form action="<?php echo e(route('denuncias.update', $denuncia->id)); ?>" method="POST" class="mb-4">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" id="titulo" value="<?php echo e(old('titulo', $denuncia->titulo)); ?>" required>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" id="descricao" rows="4" required><?php echo e(old('descricao', $denuncia->descricao)); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="categoria_id" class="form-label">Categoria</label>
            <select name="categoria_id" id="categoria_id" class="form-select" required>
                <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($categoria->id); ?>" <?php echo e($denuncia->categoria_id == $categoria->id ? 'selected' : ''); ?>>
                        <?php echo e($categoria->nome); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="prioridade" class="form-label">Prioridade</label>
            <select name="prioridade" id="prioridade" class="form-select" required>
                <option value="baixa" <?php echo e($denuncia->prioridade == 'baixa' ? 'selected' : ''); ?>>Baixa</option>
                <option value="media" <?php echo e($denuncia->prioridade == 'media' ? 'selected' : ''); ?>>Média</option>
                <option value="alta" <?php echo e($denuncia->prioridade == 'alta' ? 'selected' : ''); ?>>Alta</option>
                <option value="critica" <?php echo e($denuncia->prioridade == 'critica' ? 'selected' : ''); ?>>Crítica</option>
            </select>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="urgente" id="urgente" value="1" <?php echo e($denuncia->urgente ? 'checked' : ''); ?>>
            <label class="form-check-label" for="urgente">Urgente</label>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>

    
    <form action="<?php echo e(route('denuncias.alterar-status', $denuncia->id)); ?>" method="POST" class="mb-4">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label for="status_id" class="form-label">Status</label>
            <select name="status_id" id="status_id" class="form-select" required>
                <?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s->id); ?>" <?php echo e($denuncia->status_id == $s->id ? 'selected' : ''); ?>>
                        <?php echo e($s->nome); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="comentario_status" class="form-label">Comentário (opcional)</label>
            <textarea name="comentario" id="comentario_status" class="form-control" rows="2"></textarea>
        </div>
        <button type="submit" class="btn btn-warning">Alterar Status</button>
    </form>

    
    <form action="<?php echo e(route('denuncias.atribuir-responsavel', $denuncia->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label for="responsavel_id" class="form-label">Atribuir a</label>
            <select name="responsavel_id" id="responsavel_id" class="form-select" required>
                <option value="">Selecione um responsável</option>
                <?php $__currentLoopData = $responsaveis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($resp->id); ?>" <?php echo e($denuncia->responsavel_id == $resp->id ? 'selected' : ''); ?>>
                        <?php echo e($resp->name); ?> (<?php echo e($resp->email); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="comentario_responsavel" class="form-label">Comentário (opcional)</label>
            <textarea name="comentario" id="comentario_responsavel" class="form-control" rows="2"></textarea>
        </div>
        <button type="submit" class="btn btn-info">Atribuir Responsável</button>
    </form>

    <a href="<?php echo e(route('denuncias.index')); ?>" class="btn btn-secondary mt-3">Voltar</a>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel com bootstrap\resources\views/denuncias/edit.blade.php ENDPATH**/ ?>