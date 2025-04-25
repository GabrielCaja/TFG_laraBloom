import axios from 'axios';
import { ref } from 'vue';

export const errorMessage = ref('');
export const showError = ref(false);

export const hideError = () => {
  showError.value = false;
  errorMessage.value = '';
};

export const showErrorMessage = (message) => {
  errorMessage.value = message;
  showError.value = true;
  
  //Ocultar automáticamente después de un tiempo 5 segundos en este caso
  setTimeout(() => {
    hideError();
  }, 5000); 
};

//Función para extraer mensaje de error de la respuesta de Axios
export const extractErrorMessage = (error) => {
  if (error.response) {
    //El servidor respondió con un código de error
    if (error.response.data && error.response.data.message) {
      return error.response.data.message;
    } else if (error.response.data && error.response.data.errors) {
      const errores = Object.values(error.response.data.errors).flat();
      return errores.join(', ');
    } else {
      return `Error ${error.response.status}: ${error.response.statusText}`;
    }
  } else if (error.request) {
    //La petición se hizo pero no se recibió respuesta
    return "No se pudo conectar con el servidor. Compruebe su conexión.";
  } else {
    //Error al configurar la petición
    return "Ocurrió un error al procesar la solicitud.";
  }
};

//Configurar interceptores globales para Axios
export const setupAxiosInterceptors = () => {
  axios.interceptors.response.use(
    response => response,
    error => {
      const errorMsg = extractErrorMessage(error);
      showErrorMessage(errorMsg);
      return Promise.reject(error);
    }
  );
};

//Plugin para Vue
export default {
  install: (app) => {
    setupAxiosInterceptors();
    
    //Agrega las funciones y variables al globalProperties para acceder desde cualquier componente
    app.config.globalProperties.$errorHandler = {
      showError,
      errorMessage,
      showErrorMessage,
      hideError,
      extractErrorMessage
    };
    
    //Proporcionar las variables reactivas a través de provide/inject
    app.provide('errorHandler', {
      showError,
      errorMessage,
      showErrorMessage,
      hideError,
      extractErrorMessage
    });
  }
};