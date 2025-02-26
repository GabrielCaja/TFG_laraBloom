<template>
    <div>
        <Login v-if="!isAuthenticated" @loginSuccess="handleLoginSuccess" />
        <div v-else>
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
            <!-- // Aquí va el contenido de dashboard -->


            



        </div>
    </div>
</template>

<script>
import Login from "./Login.vue";
import { ref } from "vue";

export default {
    components: { Login },
    data() {
        return {
            isAuthenticated: false,
            currentView: "Productos",
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