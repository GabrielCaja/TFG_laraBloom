<template>
    <div>
        <Login v-if="!isAuthenticated" @loginSuccess="handleLoginSuccess" />
        <div v-else>
            <button @click="logout" class="logout-btn">Cerrar sesión</button>
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