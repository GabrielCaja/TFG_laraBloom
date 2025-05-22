<template>
        <ErrorNotification />

    <div>
        <Login v-if="!isAuthenticated" @loginSuccess="handleLoginSuccess" />
        <div v-else class="min-h-screen bg-gray-50">
            <!-- Dashboard  -->
            <div class="flex h-screen overflow-hidden">
                <!-- Sidebar  -->
                <div class="w-64 bg-gray-900 text-white shadow-xl">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold mb-8 text-blue-400">Bienvenido</h2>
                        <nav class="space-y-3">
                            <button 
                                @click="currentView = 'Dashboard'"
                                class="w-full text-left py-3 px-4 rounded-lg transition-all duration-200 flex items-center"
                                :class="currentView === 'Dashboard' ? 'bg-blue-600 shadow-md' : 'hover:bg-gray-800 hover:pl-6'"
                            >
                                <span class="font-medium">Métricas</span>
                            </button>
                            <button 
                                @click="currentView = 'Productos'"
                                class="w-full text-left py-3 px-4 rounded-lg transition-all duration-200 flex items-center"
                                :class="currentView === 'Productos' ? 'bg-blue-600 shadow-md' : 'hover:bg-gray-800 hover:pl-6'"
                            >
                                <span class="font-medium">Productos</span>
                            </button>
                            <button 
                                @click="currentView = 'Categorias'"
                                class="w-full text-left py-3 px-4 rounded-lg transition-all duration-200 flex items-center"
                                :class="currentView === 'Categorias' ? 'bg-blue-600 shadow-md' : 'hover:bg-gray-800 hover:pl-6'"
                            >
                                <span class="font-medium">Categorias</span>
                            </button>
                            <button 
                                @click="currentView = 'Usuarios'"
                                class="w-full text-left py-3 px-4 rounded-lg transition-all duration-200 flex items-center"
                                :class="currentView === 'Usuarios' ? 'bg-blue-600 shadow-md' : 'hover:bg-gray-800 hover:pl-6'"
                            >
                                <span class="font-medium">Usuarios</span>
                            </button>
                            <button 
                                @click="currentView = 'Articulos'"
                                class="w-full text-left py-3 px-4 rounded-lg transition-all duration-200 flex items-center"
                                :class="currentView === 'Articulos' ? 'bg-blue-600 shadow-md' : 'hover:bg-gray-800 hover:pl-6'"
                            >
                                <span class="font-medium">Articulos</span>
                                
                            </button>
                            <button 
                                @click="currentView = 'Contacto'"
                                class="w-full text-left py-3 px-4 rounded-lg transition-all duration-200 flex items-center"
                                :class="currentView === 'Contacto' ? 'bg-blue-600 shadow-md' : 'hover:bg-gray-800 hover:pl-6'"
                            >
                                <span class="font-medium">Contacto</span>
                            </button>
                        </nav>
                    </div>
                    <!-- Logout -->
                    <div class="absolute bottom-0 left-0 w-64 p-4 border-t border-gray-700">
                        <button @click="logout" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 active:bg-red-800 shadow-md hover:shadow-lg transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            <span>Cerrar sesión</span>
                        </button>
                    </div>
                </div>

                <!-- Main -->
                <div class="flex-1 overflow-y-auto bg-gray-50">
                    <div class="p-8">
                        <component :is="currentView" />
                    </div>
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
import Categorias from "./Categorias.vue";
import ErrorNotification from "./ErrorNotification.vue";
import Contacto from "./Contacto.vue";


export default {
    components: { 
        Login,
        Categorias,
        Dashboard,
        Productos,
        Usuarios,
        Articulos,
        ErrorNotification,
        Contacto
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
        //Verificar si el usuario esta autenticado
        checkAuth() {
            this.isAuthenticated = !!localStorage.getItem("access_token");
        },
        handleLoginSuccess() {
            this.isAuthenticated = true;
        },
        //Cerrar sesion 
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