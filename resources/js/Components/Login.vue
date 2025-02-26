<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-50">
        <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800">Login</h2>
            <img src="" alt="LOGO TIENDA">
            <form @submit.prevent="login" class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input 
                        id="email" 
                        type="email" 
                        v-model="email" 
                        required 
                        class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input 
                        id="password" 
                        type="password" 
                        v-model="password" 
                        required 
                        class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                </div>
                
                <div>
                    <button 
                        type="submit" 
                        class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        Login
                    </button>
                </div>
            </form>
            
            <p v-if="errorMessage" class="text-sm text-center text-red-600">{{ errorMessage }}</p>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            password: '',
            errorMessage: ''
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('/api/login', {
                    email: this.email,
                    password: this.password
                });
            
                console.log(response.data);
                if (response.data.es_admin == 0) {
                    this.errorMessage = 'No tienes permisos para acceder';
                    return;
                }
                this.$emit('loginSuccess', response.data);
                localStorage.setItem('access_token', response.data.access_token);
            } catch (error) {
                this.errorMessage = 'Credenciales inválidas';
            }
        }
    }
};
</script>