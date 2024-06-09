@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class=" w-full bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-8">
            <h1 class="text-3xl font-semibold mb-4 text-center">Crear Nuevo Post</h1>
            <form id="postForm" class="space-y-6">
                @csrf
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                    <input type="text" id="title" name="title" required
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md px-3 py-2">
                </div>
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Imagen</label>
                    <input type="file" id="image" name="image" accept="image/*" required
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md px-3 py-2">
                    <!-- Contenedor para previsualización de la imagen -->
                    <div id="imagePreview" class="mt-2"></div>
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <div id="editor" style="height: 200px" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></div>
                    <input type="hidden" id="description" name="description">
                </div>
                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Enviar
                    </button>
                </div>
            </form>
            <div id="alertBadge" class="hidden mt-4 px-3 py-2 rounded-md">
                <span id="alertText"></span>
            </div>
        </div>
    </div>
</div>

    <!-- CDN de Quill -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow'  // Usa el tema de nieve (Snow theme)
        });

           // Función para previsualizar la imagen seleccionada
           document.getElementById('image').addEventListener('change', function(event) {
            var file = event.target.files[0];
            var reader = new FileReader();
            
            reader.onload = function(e) {
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.innerHTML = ''; // Limpiar cualquier imagen previa
                
                var img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('max-w-full', 'h-auto');
                imagePreview.appendChild(img);
            };
            
            reader.readAsDataURL(file);
        });
    
        // Al enviar el formulario, actualiza el campo de descripción con el contenido del editor de Quill
        document.getElementById('postForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el envío normal del formulario
    
            // Obtener el contenido del editor Quill
            var descriptionContent = quill.root.innerHTML;
    
            // Crear un objeto FormData con los datos del formulario
            var formData = new FormData(this);
            formData.set('description', descriptionContent); // Agregar el contenido del editor al formData
    
            // Realizar la solicitud fetch
            fetch('{{ route('posts.store') }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Hacer algo con la respuesta del servidor
                var alertBadge = document.getElementById('alertBadge');
                var alertText = document.getElementById('alertText');
                
                if (data.success) {
                    alertBadge.classList.remove('bg-red-500');
                    alertBadge.classList.add('bg-green-500');
                    alertText.innerText = data.message;
                    // Limpiar el formulario
                    document.getElementById('postForm').reset();
                    quill.root.innerHTML = ''; // Limpiar el contenido del editor
                } else {
                    alertBadge.classList.remove('bg-green-500');
                    alertBadge.classList.add('bg-red-500');
                    alertText.innerText = data.error;
                }
                
                alertBadge.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error); // Manejar cualquier error de red
                var alertBadge = document.getElementById('alertBadge');
                var alertText = document.getElementById('alertText');
                alertBadge.classList.remove('bg-green-500');
                alertBadge.classList.add('bg-red-500');
                alertText.innerText = 'Ha ocurrido un error al crear el post. Por favor, inténtalo de nuevo más tarde.';
                alertBadge.classList.remove('hidden');
            });
        });
    </script>
@endsection
