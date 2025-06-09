<template>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            Gestión de Valoraciones
        </h1>

        <!-- Lista de valoraciones -->
        <div class="overflow-x-auto shadow-lg rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-white uppercase bg-blue-600">
                    <tr>
                        <th scope="col" class="px-6 py-4">ID</th>
                        <th scope="col" class="px-6 py-4">Usuario</th>
                        <th scope="col" class="px-6 py-4">Producto</th>
                        <th scope="col" class="px-6 py-4">Valoración</th>
                        <th scope="col" class="px-6 py-4">Comentario</th>
                        <th scope="col" class="px-6 py-4">Fecha</th>
                        <th scope="col" class="px-6 py-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="valoracion in valoraciones"
                        :key="valoracion.id"
                        class="bg-white border-b hover:bg-gray-50 transition-colors"
                    >
                        <td class="px-6 py-4 font-medium">{{ valoracion.id }}</td>
                        <td class="px-6 py-4">{{ getNombreUsuario(valoracion.user_id) }}</td>
                        <td class="px-6 py-4">{{ getNombreProducto(valoracion.producto_id) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="text-yellow-400 mr-1">
                                    {{ "★".repeat(valoracion.valoracion) }}
                                </span>
                                <span class="text-gray-400">
                                    {{ "☆".repeat(5 - valoracion.valoracion) }}
                                </span>
                                <span class="ml-2 text-sm">({{ valoracion.valoracion }}/5)</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 max-w-xs truncate">
                            {{ valoracion.comentario }}
                        </td>
                        <td class="px-6 py-4">{{ formatearFecha(valoracion.created_at) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-3">
                                <button
                                    @click="verValoracion(valoracion)"
                                    class="font-medium text-blue-600 hover:text-blue-800"
                                >
                                    Ver
                                </button>
                                <button
                                    @click="eliminarValoracion(valoracion.id)"
                                    class="font-medium text-red-600 hover:text-red-800"
                                >
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal para ver valoración completa -->
        <div
            v-if="mostrarModal"
            class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4"
        >
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl transform transition-all">
                <div class="border-b px-6 py-4">
                    <h2 class="text-xl font-bold text-gray-800">Valoración Completa</h2>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Producto:</p>
                        <p class="font-medium">{{ getNombreProducto(valoracionActual.producto_id) }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Usuario:</p>
                        <p class="font-medium">{{ getNombreUsuario(valoracionActual.user_id) }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Valoración:</p>
                        <div class="flex items-center">
                            <span class="text-yellow-400 text-xl mr-2">
                                {{ "★".repeat(valoracionActual.valoracion) }}
                            </span>
                            <span class="text-gray-400 text-xl">
                                {{ "☆".repeat(5 - valoracionActual.valoracion) }}
                            </span>
                            <span class="ml-2">({{ valoracionActual.valoracion }}/5)</span>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Comentario:</p>
                        <p class="whitespace-pre-line">{{ valoracionActual.comentario }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Fecha:</p>
                        <p>{{ formatearFecha(valoracionActual.created_at) }}</p>
                    </div>
                </div>

                <div class="border-t px-6 py-4 flex justify-end">
                    <button
                        @click="cerrarModal"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2.5 px-5 rounded-lg transition-colors"
                    >
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { showErrorMessage, extractErrorMessage } from '../errorHandler';

// Estados reactivos
const valoraciones = ref([]);
const productos = ref([]);
const usuarios = ref([]);
const mostrarModal = ref(false);
const valoracionActual = ref({});

const token = localStorage.getItem("access_token");

// Cargar datos al iniciar
onMounted(() => {
    cargarValoraciones();
    cargarProductos();
    cargarUsuarios();
});

// Cargar valoraciones
const cargarValoraciones = () => {
    axios.get("/api/valoraciones", {
        headers: {
            Authorization: `Bearer ${token}`,
        },
    })
    .then((response) => {
        valoraciones.value = response.data;
    })
    .catch((error) => {
        console.error("Error al cargar valoraciones:", error);
        showErrorMessage(extractErrorMessage(error));
    });
};

// Cargar productos
const cargarProductos = () => {
    axios.get("/api/producto", {
        headers: {
            Authorization: `Bearer ${token}`,
        },
    })
    .then((response) => {
        productos.value = response.data;
    })
    .catch((error) => {
        console.error("Error al cargar productos:", error);
    });
};

// Cargar usuarios
const cargarUsuarios = () => {
    axios.get("/api/usuario", {
        headers: {
            Authorization: `Bearer ${token}`,
        },
    })
    .then((response) => {
        usuarios.value = response.data;
    })
    .catch((error) => {
        console.error("Error al cargar usuarios:", error);
    });
};

// Obtener nombre de producto
const getNombreProducto = (productoId) => {
    const producto = productos.value.find(p => p.id === productoId);
    return producto ? producto.nombre : "Producto desconocido";
};

// Obtener nombre de usuario
const getNombreUsuario = (userId) => {
    const usuario = usuarios.value.find(u => u.id === userId);
    return usuario ? usuario.username : "Usuario desconocido";
};

// Formatear fecha
const formatearFecha = (fecha) => {
    if (!fecha) return '';
    const date = new Date(fecha);
    return date.toLocaleDateString('es-ES', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

// Ver valoración completa
const verValoracion = (valoracion) => {
    valoracionActual.value = valoracion;
    mostrarModal.value = true;
};

// Cerrar modal
const cerrarModal = () => {
    mostrarModal.value = false;
    valoracionActual.value = {};
};

// Eliminar valoración
const eliminarValoracion = (id) => {
    if (!confirm("¿Estás seguro de que deseas eliminar esta valoración?")) {
        return;
    }

    axios.delete(`/api/valoraciones/${id}`, {
        headers: {
            Authorization: `Bearer ${token}`,
        },
    })
    .then(() => {
        valoraciones.value = valoraciones.value.filter(v => v.id !== id);
        if (mostrarModal.value && valoracionActual.value.id === id) {
            cerrarModal();
        }
        showErrorMessage("Valoración eliminada correctamente", "success");
    })
    .catch((error) => {
        console.error("Error al eliminar valoración:", error);
        showErrorMessage(extractErrorMessage(error));
    });
};
</script>

<style scoped>
.truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>