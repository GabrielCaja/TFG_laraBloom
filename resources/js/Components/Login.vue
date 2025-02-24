<template>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form @submit.prevent="login">
            <label>Email</label>
            <input type="email" v-model="email" required />
            <label>Contraseña</label>
            <input type="password" v-model="password" required />
            <button type="submit">Iniciar sesión</button>
        </form>
        <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    </div>
</template>
<script>
import axios from "axios";
export default {
    data() {
        return {
            email: "",
            password: "",
            errorMessage: "",
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post("/api/login", {
                    email: this.email,
                    password: this.password,
                });
                if (!response.ok) throw new Error("Login incorrecto");
                const data = response.data;
                localStorage.setItem("token", data.token);
                this.$emit("loginSuccess");
            } catch (error) {
                this.errorMessage = "Credenciales inválidas";
            }
        },
    },
};
</script>
<style>
.login-container {
    max-width: 300px;
    margin: auto;
    padding: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}
.error {
    color: red;
}
</style>
