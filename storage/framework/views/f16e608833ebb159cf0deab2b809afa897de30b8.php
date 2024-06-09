

<?php $__env->startSection('content'); ?>
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6">Noticias</h1>
        <a href="<?php echo e(route('posts.create')); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">Crear Nueva Noticia</a>
        <?php if(count($posts) > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="rounded-lg shadow-md overflow-hidden">
                        <img src="<?php echo e($post->image); ?>" class="w-full h-48 object-cover object-center" alt="<?php echo e($post->title); ?>">
                        <div class="p-4">
                            <h2 class="text-xl font-semibold mb-2"><?php echo e($post->title); ?></h2>
                            <div class="text-gray-700 mt-2 overflow-hidden" style="max-height: 60px" id="text<?php echo e($post->id_posts); ?>">
                                <?php echo $post->description; ?>

                            </div>
                            
                            <div class="flex mt-2">
                                
                                <?php if(strlen($post->description) > 120): ?>
                                    <button id="toggle<?php echo e($post->id_posts); ?>" class="text-blue-500 focus:outline-none bg-gray-300 hover:bg-gray-400 py-2 px-4 rounded mr-2">Ver más</button>
                                <?php endif; ?>
                                <form action="<?php echo e(route('posts.destroy', $post->id_posts)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="bg-red-500 ml-1 mr-1 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">Eliminar</button>
                                </form>
                                
                            
                                
                                <a href="<?php echo e(route('posts.edit', $post->id_posts)); ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-block">Editar</a>
                            
                            </div>
                            <p class="text-sm text-gray-500 mt-2"><?php echo e($post->created_at ? $post->created_at->diffForHumans() : ''); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p>No se encontraron posts.</p>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                var toggle<?php echo e($post->id_posts); ?> = document.getElementById('toggle<?php echo e($post->id_posts); ?>');
                var text<?php echo e($post->id_posts); ?> = document.getElementById('text<?php echo e($post->id_posts); ?>');

                toggle<?php echo e($post->id_posts); ?>.addEventListener('click', function() {
                    text<?php echo e($post->id_posts); ?>.style.maxHeight = text<?php echo e($post->id_posts); ?>.style.maxHeight ? null : '60px';
                    this.textContent = text<?php echo e($post->id_posts); ?>.style.maxHeight ? 'Ver menos' : 'Ver más';
                });
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\app-noticis\resources\views/posts/index.blade.php ENDPATH**/ ?>