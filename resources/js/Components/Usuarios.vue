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
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";

const usuarios = ref([]);

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

//Editar usuario
const editarUsuario = (usuario) => {
    console.log(usuario);
};

//Eliminar usuario
const eliminarUsuario = (id) => {
    console.log(id);
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
