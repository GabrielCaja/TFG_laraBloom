<template>
    <div>
        <Login v-if="!isAuthenticated" @loginSuccess="handleLoginSuccess" />
        <div v-else>
            
            <!-- Aquí va el contenido de dashboard -->
            <div class="flex h-screen">
                <!-- Sidebar -->
                <div class="w-64 bg-gray-800 text-white p-6">
                    <h2 class="text-xl font-bold mb-6">Dashboard</h2>
                    <nav class="space-y-2">
                        <button 
                            @click="currentView = 'Dashboard'"
                            class="w-full text-left py-2 px-4 rounded transition-colors duration-200"
                            :class="currentView === 'Dashboard' ? 'bg-blue-600' : 'hover:bg-gray-700'"
                        >
                            Dashboard
                        </button>
                        <button 
                            @click="currentView = 'Productos'"
                            class="w-full text-left py-2 px-4 rounded transition-colors duration-200"
                            :class="currentView === 'Productos' ? 'bg-blue-600' : 'hover:bg-gray-700'"
                        >
                            Productos
                        </button>
                        <button 
                            @click="currentView = 'Usuarios'"
                            class="w-full text-left py-2 px-4 rounded transition-colors duration-200"
                            :class="currentView === 'Usuarios' ? 'bg-blue-600' : 'hover:bg-gray-700'"
                        >
                            Usuarios
                        </button>
                        <button 
                            @click="currentView = 'Articulos'"
                            class="w-full text-left py-2 px-4 rounded transition-colors duration-200"
                            :class="currentView === 'Articulos' ? 'bg-blue-600' : 'hover:bg-gray-700'"
                        >
                            Articulos
                        </button>
                    </nav>
                    <div class="mt-auto pt-20">
                        <button @click="logout" class="flex items-center gap-2 px-4 py-2 bg-red-500 text-white font-medium rounded hover:bg-red-600 hover:shadow-md transition-all duration-300">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                            </span>
                            <span>Cerrar sesión</span>
                        </button>
                    </div>
                </div>
                <!-- Main -->
                <div class="flex-1 p-8">
                    <component :is="currentView" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Login from "./Login.vue";
import Productos from "./Productos.vue";
import Usuarios from "./Usuarios.vue";
import Articulos from "./Articulos.vue";
import Dashboard from "./Dashboard.vue";
import axios from "axios";

import { ref } from "vue";

export default {
    components: { 
        Login,
        Dashboard,
        Productos,
        Usuarios,
        Articulos
    },
    data() {
        return {
            isAuthenticated: false,
            currentView: "Dashboard",
        };
    },
    mounted() {
        this.checkAuth();
    },
    methods: {
        checkAuth() {
            this.isAuthenticated = !!localStorage.getItem("access_token");
        },
        handleLoginSuccess() {
            this.isAuthenticated = true;
        },
        async logout() {
            try {
                const token = localStorage.getItem("access_token");
                await fetch("/api/logout", {
                    method: "POST",
                    headers: { Authorization: `Bearer ${token}` },
                });
                localStorage.removeItem("access_token");
                this.isAuthenticated = false;
            } catch (error) {
                console.error("Error al cerrar sesión", error);
            }
        },
    },
};
</script>