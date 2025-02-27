<template>
    <h1>Gestion de Usuarios</h1>

    <!-- Formulario de edición y agregacion de usuarios-->
    <div>
        <form class="flex space-x-2" @submit.prevent>
            <input
                type="text"
                placeholder="Nombre"
                class="border border-gray-300 p-2 rounded-lg"
                v-model="nuevoUsuario.username"
            />
            <input
                type="email"
                placeholder="Email"
                class="border border-gray-300 p-2 rounded-lg"
                v-model="nuevoUsuario.email"
            />
            <select
                class="border border-gray-300 p-2 rounded-lg"
                v-model="nuevoUsuario.admin"
            >
                <option :value="false">Usuario normal</option>
                <option :value="true">Administrador</option>
            </select>
            <select
                class="border border-gray-300 p-2 rounded-lg"
                v-model="nuevoUsuario.newsletter"
            >
                <option :value="false">Sin newsletter</option>
                <option :value="true">Con newsletter</option>
            </select>
            <input
                type="password"
                placeholder="Contraseña"
                class="border border-gray-300 p-2 rounded-lg"
                v-model="nuevoUsuario.password"
            />
            <button
                @click="agregarUsuario"
                class="bg-blue-500 text-white p-2 rounded-lg"
            >
                Agregar
            </button>
        </form>
    </div>

    <!-- Tabla de usuarios -->
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Nombre</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Admin</th>
                    <th scope="col" class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="usuario in usuarios"
                    :key="usuario.id"
                    class="bg-white border-b hover:bg-gray-50"
                >
                    <td class="px-6 py-4">{{ usuario.id }}</td>
                    <td class="px-6 py-4">{{ usuario.username }}</td>
                    <td class="px-6 py-4">{{ usuario.email }}</td>
                    <td class="px-6 py-4">{{ usuario.admin }}</td>

                    <td class="px-6 py-4 space-x-2">
                        <button
                            @click="editarUsuario(usuario)"
                            class="font-medium text-blue-600 hover:underline"
                        >
                            Editar
                        </button>
                        <button
                            @click="eliminarUsuario(usuario.id)"
                            class="font-medium text-red-600 hover:underline"
                        >
                            Eliminar
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Modal para editar usuario -->
    <div v-if="mostrarModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
            <h2 class="text-xl font-bold mb-4">Editar Usuario</h2>
            
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input
                        type="text"
                        class="w-full border border-gray-300 p-2 rounded-lg mt-1"
                        v-model="usuarioEditando.username"
                    />
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input
                        type="email"
                        class="w-full border border-gray-300 p-2 rounded-lg mt-1"
                        v-model="usuarioEditando.email"
                    />
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipo de Usuario</label>
                    <select
                        class="w-full border border-gray-300 p-2 rounded-lg mt-1"
                        v-model="usuarioEditando.admin"
                    >
                        <option :value="false">Usuario normal</option>
                        <option :value="true">Administrador</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Newsletter</label>
                    <select
                        class="w-full border border-gray-300 p-2 rounded-lg mt-1"
                        v-model="usuarioEditando.newsletter"
                    >
                        <option :value="false">Sin newsletter</option>
                        <option :value="true">Con newsletter</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Contraseña (dejar en blanco para mantener la actual)
                    </label>
                    <input
                        type="password"
                        class="w-full border border-gray-300 p-2 rounded-lg mt-1"
                        v-model="usuarioEditando.password"
                        placeholder="Nueva contraseña (opcional)"
                    />
                </div>
                
                <div class="flex space-x-3 justify-end">
                    <button
                        @click="cerrarModal"
                        type="button"
                        class="bg-gray-500 text-white p-2 rounded-lg"
                    >
                        Cancelar
                    </button>
                    <button
                        @click="actualizarUsuario"
                        type="button"
                        class="bg-green-500 text-white p-2 rounded-lg"
                    >
                        Guardar Cambios
                    </button>
                </div>
            </form>
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
