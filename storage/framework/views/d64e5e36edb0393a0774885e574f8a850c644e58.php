

<?php $__env->startSection('content'); ?>
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6">Editar Post</h1>
        <form action="<?php echo e(route('posts.update', $post->id_posts)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('POST'); ?>
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                <input type="text" id="title" name="title" value="<?php echo e(old('title', $post->title)); ?>" required
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Imagen</label>
                <input type="file" id="image" name="image" accept="image/*"
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md px-3 py-2">
                <img src="<?php echo e($post->image); ?>" alt="<?php echo e($post->title); ?>" class="mt-2 h-32">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                <div id="editor" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" style="min-height: 200px;"><?php echo old('description', $post->description); ?></div>
                <input type="hidden" id="description" name="description">
            </div>
            <div class="mb-4">
                <button type="submit"
                        class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>

    <!-- CDN de Quill -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow'  // Usa el tema de nieve (Snow theme)
        });

        // Al enviar el formulario, actualiza el campo de descripción con el contenido del editor de Quill
        document.querySelector('form').addEventListener('submit', function(event) {
            var description = document.querySelector('#description');
            description.value = quill.root.innerHTML;
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\app-noticis\resources\views/posts/edit.blade.php ENDPATH**/ ?>