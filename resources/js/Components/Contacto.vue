<template>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            Mensajes de Contacto
        </h1>

        <!-- Tabla de mensajes -->
        <div class="overflow-x-auto shadow-lg rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-white uppercase bg-blue-600">
                    <tr>
                        <th scope="col" class="px-6 py-4">ID</th>
                        <th scope="col" class="px-6 py-4">Nombre</th>
                        <th scope="col" class="px-6 py-4">Email</th>
                        <th scope="col" class="px-6 py-4">Asunto</th>
                        <th scope="col" class="px-6 py-4">Fecha</th>
                        <th scope="col" class="px-6 py-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="contacto in contactos"
                        :key="contacto.id"
                        :class="contacto.leido ? 'bg-white' : 'bg-yellow-50'"
                        class="border-b hover:bg-gray-50 transition-colors"
                    >
                        <td class="px-6 py-4 font-medium">{{ contacto.id }}</td>
                        <td class="px-6 py-4">{{ contacto.nombre }}</td>
                        <td class="px-6 py-4">{{ contacto.email }}</td>
                        <td class="px-6 py-4">{{ contacto.asunto }}</td>
                        <td class="px-6 py-4">{{ formatearFecha(contacto.created_at) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-3">
                                <button
                                    @click="verMensaje(contacto)"
                                    class="font-medium text-blue-600 hover:text-blue-800 flex items-center"
                                >
                                    <span>Ver</span>
                                </button>
                                <button
                                    @click="eliminarMensaje(contacto.id)"
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

        <!-- Modal para ver mensaje -->
        <div
            v-if="mostrarModal"
            class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4"
        >
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl transform transition-all">
                <div class="border-b px-6 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Mensaje de Contacto</h2>
                    <span class="text-sm text-gray-500">{{ formatearFecha(mensajeActual.created_at) }}</span>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">De:</p>
                        <p>{{ mensajeActual.nombre }} ({{ mensajeActual.email }})</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Asunto:</p>
                        <p class="font-medium">{{ mensajeActual.asunto }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Mensaje:</p>
                        <p class="whitespace-pre-line">{{ mensajeActual.mensaje }}</p>
                    </div>
                </div>

                <div class="border-t px-6 py-4 flex justify-end space-x-3">
                   
                    <button
                        @click="cerrarModal"
                        type="button"
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

const mostrarModal = ref(false);
const contactos = ref([]);
const mensajeActual = ref({
    id: null,
    nombre: "",
    email: "",
    asunto: "",
    mensaje: "",
    leido: false,
    created_at: null
});

const token = localStorage.getItem("access_token");

//Cargamos mensajes al iniciar
onMounted(() => {
    cargarMensajes();
});

const cargarMensajes = () => {
    axios
        .get("/api/contacto", {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
        .then((response) => {
            contactos.value = response.data;
        })
        .catch((error) => {
            console.error("Error al cargar mensajes:", error);
            showErrorMessage(extractErrorMessage(error));
        });
};

//Formatear fecha para la tabla
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

const verMensaje = (contacto) => {
    mensajeActual.value = { ...contacto };
    mostrarModal.value = true;
    
    if (!contacto.leido) {
        marcarComoLeido(contacto.id, true);
    }
};

const cerrarModal = () => {
    mostrarModal.value = false;
};


//Eliminar un mensaje
const eliminarMensaje = (id) => {
    if (!confirm("¿Estás seguro de que deseas eliminar este mensaje?")) {
        return;
    }

    axios
        .delete(`/api/contacto/${id}`, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
        .then(() => {
            contactos.value = contactos.value.filter(contacto => contacto.id !== id);
            
            //  Si el mensaje eliminado está abierto, cerrar el modal
            if (mostrarModal.value && mensajeActual.value.id === id) {
                cerrarModal();
            }
        })
        .catch((error) => {
            console.error("Error al eliminar mensaje:", error);
            showErrorMessage(extractErrorMessage(error));
        });
};
</script>