<template>
    <div>
        <Login v-if="!isAuthenticated" @loginSuccess="checkAuth" />
        <div v-else>
    <button @click="logout" class="logout-btn">Cerrar sesión</button>
    </div>
    </div>
</template>
<script setup>
import Login from "./Login.vue";
import { ref } from "vue";

</script>
