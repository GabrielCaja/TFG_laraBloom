<template>
    <div 
      v-if="showError" 
      class="fixed top-5 right-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-md z-50 max-w-md"
    >
      <div class="flex items-center">
        <div class="py-1">
          <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
          </svg>
        </div>
        <div>
          <p>{{ errorMessage }}</p>
        </div>
        <div class="ml-auto">
          <button @click="hideError" class="text-red-700 hover:text-red-900">
            <span class="text-2xl">&times;</span>
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { errorMessage, showError, hideError } from '../errorHandler';
  </script>