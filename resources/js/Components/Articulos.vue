<template>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            Gestión de Artículos
        </h1>

        <!-- Formulario de agregación -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">
                Agregar nuevo artículo
            </h2>
            <form class="flex flex-wrap gap-4 items-end" @submit.prevent>
                <div class="flex-grow min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Título</label
                    >
                    <input
                        type="text"
                        placeholder="Título del artículo"
                        class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        v-model="nuevoArticulo.titulo"
                    />
                </div>
                <div class="flex-grow min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Contenido</label
                    >
                    <textarea
                        placeholder="Contenido del artículo"
                        class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        rows="4"
                        v-model="nuevoArticulo.contenido"
                    ></textarea>
                </div>
                <div class="flex-grow min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Imagen de portada</label
                    >
                    <input
                        type="file"
                        accept="image/*"
                        @change="subirImagen"
                        class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    />
                    <img
                        v-if="nuevoArticulo.rutaImg"
                        :src="nuevoArticulo.rutaImg"
                        class="mt-2 h-32 object-contain"
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Publicado</label
                    >
                    <select
                        class="bg-white border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        v-model="nuevoArticulo.publicado"
                    >
                        <option :value="true">Sí</option>
                        <option :value="false">No</option>
                    </select>
                </div>
                <div>
                    <button
                        @click="agregarArticulo"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-5 rounded-lg transition-colors"
                    >
                        Agregar artículo
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabla de artículos -->
        <div class="overflow-x-auto shadow-lg rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-white uppercase bg-blue-600">
                    <tr>
                        <th scope="col" class="px-6 py-4">ID</th>
                        <th scope="col" class="px-6 py-4">Imagen</th>
                        <th scope="col" class="px-6 py-4">Título</th>
                        <th scope="col" class="px-6 py-4">Fecha</th>
                        <th scope="col" class="px-6 py-4">Estado</th>
                        <th scope="col" class="px-6 py-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="articulo in articulos"
                        :key="articulo.id"
                        class="bg-white border-b hover:bg-gray-50 transition-colors"
                    >
                        <td class="px-6 py-4 font-medium">{{ articulo.id }}</td>
                        <td class="px-6 py-4 font-medium">
                            <img
                                v-if="articulo.rutaImg"
                                :src="articulo.rutaImg"
                                alt="Imagen del artículo"
                                class="h-16 w-16 object-cover rounded"
                            />
                            <span v-else class="text-gray-400">Sin imagen</span>
                        </td>
                        <td class="px-6 py-4">{{ articulo.titulo }}</td>
                        <td class="px-6 py-4">{{ formatearFecha(articulo.created_at) }}</td>
                        <td class="px-6 py-4">
                            <span
                                :class="
                                    articulo.publicado
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-red-100 text-red-800'
                                "
                                class="px-2.5 py-1 rounded-full text-xs font-medium"
                            >
                                {{ articulo.publicado ? "Publicado" : "Borrador" }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-3">
                                <button
                                    @click="editarArticulo(articulo)"
                                    class="font-medium text-blue-600 hover:text-blue-800 flex items-center"
                                >
                                    <span>Editar</span>
                                </button>
                                <button
                                    @click="eliminarArticulo(articulo.id)"
                                    class="font-medium text-red-600 hover:text-red-800 flex items-center"
                                >
                                    <span>Eliminar</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal para editar artículo -->
        <div
            v-if="mostrarModal"
            class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4"
        >
            <div
                class="bg-white rounded-xl shadow-2xl w-full max-w-2xl transform transition-all"
            >
                <div class="border-b px-6 py-4">
                    <h2 class="text-xl font-bold text-gray-800">
                        Editar Artículo
                    </h2>
                </div>

                <form class="p-6 space-y-5">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Título</label
                        >
                        <input
                            type="text"
                            class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            v-model="articuloEditando.titulo"
                        />
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Contenido</label
                        >
                        <textarea
                            class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            rows="6"
                            v-model="articuloEditando.contenido"
                        ></textarea>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Estado</label
                        >
                        <select
                            class="w-full bg-white border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            v-model="articuloEditando.publicado"
                        >
                            <option :value="true">Publicado</option>
                            <option :value="false">Borrador</option>
                        </select>
                    </div>

                    <div class="flex-grow min-w-[200px]">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Imagen</label
                        >
                        <input
                            type="file"
                            accept="image/*"
                            @change="(e) => subirImagen(e, true)"
                            class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        />
                        <img
                            v-if="articuloEditando.rutaImg"
                            :src="articuloEditando.rutaImg"
                            class="mt-2 h-32 object-contain"
                        />
                    </div>
                </form>

                <div class="border-t px-6 py-4 flex justify-end space-x-3">
                    <button
                        @click="cerrarModal"
                        type="button"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2.5 px-5 rounded-lg transition-colors"
                    >
                        Cancelar
                    </button>
                    <button
                        @click="actualizarArticulo"
                        type="button"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-5 rounded-lg transition-colors"
                    >
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

// Estados reactivos
const mostrarModal = ref(false);
const articulos = ref([]);

// Estado para el artículo que se está editando
const articuloEditando = ref({
    id: null,
    titulo: "",
    contenido: "",
    publicado: true,
    rutaImg: null,
    autor_id: 1  // Siempre usar autor_id 1
});

// Estado para un nuevo artículo
const nuevoArticulo = ref({
    titulo: "",
    contenido: "",
    publicado: true,
    rutaImg: null,
    autor_id: 1  // Siempre usar autor_id 1
});

// Token de autenticación
const token = localStorage.getItem("access_token");

// Cargar artículos al iniciar
onMounted(() => {
    cargarArticulos();
});

// Obtener todos los artículos
const cargarArticulos = () => {
    axios
        .get("/api/articulo", {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
        .then((response) => {
            articulos.value = response.data;
        })
        .catch((error) => {
            console.error("Error al cargar artículos:", error);
        });
};

// Formatear fecha para la tabla
const formatearFecha = (fecha) => {
    if (!fecha) return '';
    const date = new Date(fecha);
    return date.toLocaleDateString('es-ES', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
};

// Subir imagen (funciona tanto para nuevo artículo como para edición)
const subirImagen = (event, esEdicion = false) => {
    const file = event.target.files[0];
    if (!file) return;
    
    // Verificar tamaño (máximo 2MB) para no saturar la base de datos
    if (file.size > 2 * 1024 * 1024) {
        alert('La imagen no debe superar los 2MB');
        return;
    }
    
    // Convertir a base64
    const reader = new FileReader();
    reader.onload = (e) => {
        if (esEdicion) {
            articuloEditando.value.rutaImg = e.target.result;
        } else {
            nuevoArticulo.value.rutaImg = e.target.result;
        }
    };
    reader.readAsDataURL(file);
};

// Abrir modal para editar un artículo
const editarArticulo = (articulo) => {
    // Copiar el artículo pero asegurarnos que siempre tenga autor_id = 1
    articuloEditando.value = { 
        ...articulo,
        autor_id: 1
    };
    mostrarModal.value = true;
};

// Cerrar el modal
const cerrarModal = () => {
    mostrarModal.value = false;
    articuloEditando.value = {
        id: null,
        titulo: "",
        contenido: "",
        publicado: true,
        rutaImg: null,
        autor_id: 1  // Mantener autor_id 1
    };
};

// Actualizar un artículo
const actualizarArticulo = () => {
    if (!articuloEditando.value.titulo) {
        alert("El título es obligatorio");
        return;
    }

    // Asegurarse de que tenga autor_id = 1 antes de enviar
    articuloEditando.value.autor_id = 1;

    axios
        .put(
            `/api/articulo/${articuloEditando.value.id}`,
            articuloEditando.value,
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        )
        .then((response) => {
            // Actualizar el artículo en la lista local
            const index = articulos.value.findIndex(
                (a) => a.id === articuloEditando.value.id
            );
            if (index !== -1) {
                articulos.value[index] = response.data;
            }
            cerrarModal();
        })
        .catch((error) => {
            console.error("Error al actualizar artículo:", error);
            alert("Error al actualizar artículo");
        });
};

// Eliminar un artículo
const eliminarArticulo = (id) => {
    if (!confirm("¿Estás seguro de que deseas eliminar este artículo?")) {
        return;
    }

    axios
        .delete(`/api/articulo/${id}`, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
        .then(() => {
            articulos.value = articulos.value.filter(
                (articulo) => articulo.id !== id
            );
        })
        .catch((error) => {
            console.error("Error al eliminar artículo:", error);
            alert("Error al eliminar artículo");
        });
};

// Agregar un nuevo artículo
const agregarArticulo = () => {
    if (!nuevoArticulo.value.titulo) {
        alert("El título del artículo es obligatorio");
        return;
    }
    
    // Asegurarse de que tenga autor_id = 1 antes de enviar
    nuevoArticulo.value.autor_id = 1;
    
    axios
        .post("/api/articulo", nuevoArticulo.value, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
        .then((response) => {
            // Agregar el nuevo artículo a la lista
            articulos.value.push(response.data);

            // Reiniciar el formulario
            nuevoArticulo.value = {
                titulo: "",
                contenido: "",
                publicado: true,
                rutaImg: null,
                autor_id: 1  // Mantener autor_id 1
            };
        })
        .catch((error) => {
            console.error("Error al agregar artículo:", error);
            alert("Error al agregar artículo");
        });
};
</script>

<style scoped></style>