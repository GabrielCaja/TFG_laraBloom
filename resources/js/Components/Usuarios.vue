<template>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Gestión de Usuarios</h1>

        <!-- Formulario de agregación -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Agregar nuevo usuario</h2>
            <form class="flex flex-wrap gap-4 items-end" @submit.prevent>
                <div class="flex-grow min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input
                        type="text"
                        placeholder="Nombre de usuario"
                        class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        v-model="nuevoUsuario.username"
                    />
                </div>
                <div class="flex-grow min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input
                        type="email"
                        placeholder="correo@ejemplo.com"
                        class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        v-model="nuevoUsuario.email"
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                    <select
                        class="bg-white border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        v-model="nuevoUsuario.admin"
                    >
                        <option :value="false">Usuario normal</option>
                        <option :value="true">Administrador</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Newsletter</label>
                    <select
                        class="bg-white border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        v-model="nuevoUsuario.newsletter"
                    >
                        <option :value="false">Sin newsletter</option>
                        <option :value="true">Con newsletter</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                    <input
                        type="password"
                        placeholder="••••••••"
                        class="border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        v-model="nuevoUsuario.password"
                    />
                </div>
                <div>
                    <button
                        @click="agregarUsuario"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-5 rounded-lg transition-colors"
                    >
                        Agregar usuario
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabla de usuarios -->
        <div class="overflow-x-auto shadow-lg rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-white uppercase bg-blue-600">
                    <tr>
                        <th scope="col" class="px-6 py-4">ID</th>
                        <th scope="col" class="px-6 py-4">Nombre</th>
                        <th scope="col" class="px-6 py-4">Email</th>
                        <th scope="col" class="px-6 py-4">Rol</th>
                        <th scope="col" class="px-6 py-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="usuario in usuarios"
                        :key="usuario.id"
                        class="bg-white border-b hover:bg-gray-50 transition-colors"
                    >
                        <td class="px-6 py-4 font-medium">{{ usuario.id }}</td>
                        <td class="px-6 py-4">{{ usuario.username }}</td>
                        <td class="px-6 py-4">{{ usuario.email }}</td>
                        <td class="px-6 py-4">
                            <span 
                                :class="usuario.admin ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800'" 
                                class="px-2.5 py-1 rounded-full text-xs font-medium"
                            >
                                {{ usuario.admin ? 'Admin' : 'Usuario' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-3">
                                <button
                                    @click="editarUsuario(usuario)"
                                    class="font-medium text-blue-600 hover:text-blue-800 flex items-center"
                                >
                                    <span>Editar</span>
                                </button>
                                <button
                                    @click="eliminarUsuario(usuario.id)"
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

        <!-- Modal para editar usuario -->
        <div v-if="mostrarModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl transform transition-all">
                <div class="border-b px-6 py-4">
                    <h2 class="text-xl font-bold text-gray-800">Editar Usuario</h2>
                </div>
                
                <form class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input
                            type="text"
                            class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            v-model="usuarioEditando.username"
                        />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input
                            type="email"
                            class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            v-model="usuarioEditando.email"
                        />
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Usuario</label>
                            <select
                                class="w-full bg-white border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                v-model="usuarioEditando.admin"
                            >
                                <option :value="false">Usuario normal</option>
                                <option :value="true">Administrador</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Newsletter</label>
                            <select
                                class="w-full bg-white border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                v-model="usuarioEditando.newsletter"
                            >
                                <option :value="false">Sin newsletter</option>
                                <option :value="true">Con newsletter</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Contraseña (dejar en blanco para mantener la actual)
                        </label>
                        <input
                            type="password"
                            class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            v-model="usuarioEditando.password"
                            placeholder="Nueva contraseña (opcional)"
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
                        @click="actualizarUsuario"
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
import { ref } from "vue";
import axios from "axios";
const mostrarModal = ref(false);
const usuarios = ref([]);
const usuarioEditando = ref({
    id: null,
    username: "",
    email: "",
    admin: false,
    newsletter: false,
    password: "",
});
const token = localStorage.getItem("access_token");

axios
    .get("/api/usuario", {
        headers: {
            Authorization: `Bearer ${token}`,
        },
    })
    .then((response) => {
        usuarios.value = response.data;
    })
    .catch((error) => {
        console.error(error);
    });

// Editar usuario - Abrir modal
const editarUsuario = (usuario) => {
    usuarioEditando.value = {
        id: usuario.id,
        username: usuario.username,
        email: usuario.email,
        admin: usuario.admin,
        newsletter: usuario.newsletter || false,
        password: "", // Vacío por seguridad
    };
    mostrarModal.value = true;
};

// Cerrar modal
const cerrarModal = () => {
    mostrarModal.value = false;
    usuarioEditando.value = {
        id: null,
        username: "",
        email: "",
        admin: false,
        newsletter: false,
        password: "",
    };
};

// Actualizar usuario
const actualizarUsuario = () => {
    const token = localStorage.getItem("access_token");
    const datosActualizados = { ...usuarioEditando.value };

    // Si no hay contraseña, la eliminamos para no actualizar este campo
    if (!datosActualizados.password) {
        delete datosActualizados.password;
    }

    axios
        .put(`/api/usuario/${usuarioEditando.value.id}`, datosActualizados, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
        .then((response) => {
            // Actualiza el usuario en la lista local
            const index = usuarios.value.findIndex(
                (u) => u.id === usuarioEditando.value.id
            );
            if (index !== -1) {
                usuarios.value[index] = response.data;
            }

            // Cerrar modal y limpiar
            cerrarModal();
        })
        .catch((error) => {
            console.error("Error al actualizar usuario:", error);
            alert("Error al actualizar usuario");
        });
};

//Eliminar usuario
const eliminarUsuario = (id) => {
    if (!confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
        return;
    }

    const token = localStorage.getItem("access_token");

    axios
        .delete(`/api/usuario/${id}`, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
        .then((response) => {
            usuarios.value = usuarios.value.filter(
                (usuario) => usuario.id !== id
            );
        })
        .catch((error) => {
            console.error(
                "Error al eliminar usuario:",
                error.response.data.errors
            );
            alert("Error al eliminar usuario", error.response.data.erros);
        });
};

//Agregar usuario
const nuevoUsuario = ref({
    username: "",
    email: "",
    admin: 0,
    password: "",
});

const agregarUsuario = () => {
    const token = localStorage.getItem("access_token");

    axios
        .post("/api/usuario", nuevoUsuario.value, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
        .then((response) => {
            // Add the new user to the list
            usuarios.value.push(response.data);

            // Reset form fields
            nuevoUsuario.value = {
                username: "",
                email: "",
                admin: false,
                newsletter: false,
                password: "",
            };
        })
        .catch((error) => {
            console.error("Error al agregar usuario:", error);
            alert("Error al agregar usuario");
        });
};
</script>

<style scoped></style>
