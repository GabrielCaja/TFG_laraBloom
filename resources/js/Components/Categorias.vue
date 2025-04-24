<template>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            Gestión de Categorías
        </h1>

        <!-- Formulario de agregación -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">
                Agregar nueva categoría
            </h2>
            <form class="flex flex-wrap gap-4 items-end" @submit.prevent>
                <div class="flex-grow min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Nombre</label
                    >
                    <input
                        type="text"
                        placeholder="Nombre de la categoría"
                        class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        v-model="nuevaCategoria.nombre"
                    />
                </div>
                <div class="flex-grow min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Descripción</label
                    >
                    <textarea
                        placeholder="Descripción de la categoría"
                        class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        v-model="nuevaCategoria.descripcion"
                    ></textarea>
                </div>
                <div>
                    <button
                        @click="agregarCategoria"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-5 rounded-lg transition-colors"
                    >
                        Agregar categoría
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabla de categorías -->
        <div class="overflow-x-auto shadow-lg rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-white uppercase bg-blue-600">
                    <tr>
                        <th scope="col" class="px-6 py-4">ID</th>
                        <th scope="col" class="px-6 py-4">Nombre</th>
                        <th scope="col" class="px-6 py-4">Descripción</th>
                        <th scope="col" class="px-6 py-4">Productos asociados</th>
                        <th scope="col" class="px-6 py-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="categoria in categorias"
                        :key="categoria.id"
                        class="bg-white border-b hover:bg-gray-50 transition-colors"
                    >
                        <td class="px-6 py-4 font-medium">{{ categoria.id }}</td>
                        <td class="px-6 py-4">{{ categoria.nombre }}</td>
                        <td class="px-6 py-4">{{ categoria.descripcion }}</td>
                        <td class="px-6 py-4">{{ getNumeroProductos(categoria.id) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-3">
                                <button
                                    @click="editarCategoria(categoria)"
                                    class="font-medium text-blue-600 hover:text-blue-800 flex items-center"
                                >
                                    <span>Editar</span>
                                </button>
                                <button
                                    @click="eliminarCategoria(categoria.id)"
                                    class="font-medium text-red-600 hover:text-red-800 flex items-center"
                                >
                                    <span>Eliminar</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal para editar categoría -->
        <div
            v-if="mostrarModal"
            class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4"
        >
            <div
                class="bg-white rounded-xl shadow-2xl w-full max-w-2xl transform transition-all"
            >
                <div class="border-b px-6 py-4">
                    <h2 class="text-xl font-bold text-gray-800">
                        Editar Categoría
                    </h2>
                </div>

                <form class="p-6 space-y-5">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Nombre</label
                        >
                        <input
                            type="text"
                            class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            v-model="categoriaEditando.nombre"
                        />
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Descripción</label
                        >
                        <textarea
                            class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            v-model="categoriaEditando.descripcion"
                        ></textarea>
                    </div>
                </form>

                <div class="border-t px-6 py-4 flex justify-end space-x-3">
                    <button
                        @click="cerrarModal"
                        type="button"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2.5 px-5 rounded-lg transition-colors"
                    >
                        Cancelar
                    </button>
                    <button
                        @click="actualizarCategoria"
                        type="button"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-5 rounded-lg transition-colors"
                    >
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { showErrorMessage, extractErrorMessage } from '../errorHandler';

//Estados reactivos
const mostrarModal = ref(false);
const categorias = ref([]);
const productos = ref([]); 
//Estado para la categoría que se está editando
const categoriaEditando = ref({
    id: null,
    nombre: "",
    descripcion: ""
});

//Estado para una nueva categoría
const nuevaCategoria = ref({
    nombre: "",
    descripcion: ""
});

//Token de autenticación
const token = localStorage.getItem("access_token");

//Cargar categorías al iniciar
onMounted(() => {
    cargarCategorias();
    cargarProductos();
});

//Obtener todas las categorías
const cargarCategorias = () => {
    axios
        .get("/api/categoria", {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
        .then((response) => {
            categorias.value = response.data;
        })
        .catch((error) => {
            console.error("Error al cargar categorías:", error);
        });
};

//Cargar productos para contar asociaciones
const cargarProductos = () => {
    axios
        .get("/api/producto", {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
        .then((response) => {
            productos.value = response.data;
        })
        .catch((error) => {
            console.error("Error al cargar productos:", error);
        });
};

//Obtener el número de productos asociados a una categoría
const getNumeroProductos = (categoriaId) => {
    return productos.value.filter(p => p.categoria_id === categoriaId).length;
};

//Abrir modal para editar una categoría
const editarCategoria = (categoria) => {
    categoriaEditando.value = {
        id: categoria.id,
        nombre: categoria.nombre,
        descripcion: categoria.descripcion
    };
    mostrarModal.value = true;
};

//Cerrar el modal
const cerrarModal = () => {
    mostrarModal.value = false;
    categoriaEditando.value = {
        id: null,
        nombre: "",
        descripcion: ""
    };
};
// Para actualizar una categoria

const actualizarCategoria = () => {
    axios
        .put(
            `/api/categoria/${categoriaEditando.value.id}`,
            categoriaEditando.value,
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        )
        .then((response) => {
            //Actualizar la categoría en la lista local
            const index = categorias.value.findIndex(
                (c) => c.id === categoriaEditando.value.id
            );
            if (index !== -1) {
                categorias.value[index] = categoriaEditando.value;
            }
            cerrarModal();
        })
        .catch((error) => {
            console.error("Error al actualizar categoría:", error);
            showErrorMessage(extractErrorMessage(error));
        });
};

// Para eliminar una categoria
const eliminarCategoria = (id) => {
    //Verificar si hay productos asociados
    const productosAsociados = productos.value.filter(p => p.categoria_id === id);
    
    if (productosAsociados.length > 0) {
        showErrorMessage(`No se puede eliminar esta categoría porque tiene ${productosAsociados.length} productos asociados.`);
        return;
    }
    
    if (!confirm("¿Estás seguro de que deseas eliminar esta categoría?")) {
        return;
    }

    axios
        .delete(`/api/categoria/${id}`, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
        .then(() => {
            categorias.value = categorias.value.filter(
                (categoria) => categoria.id !== id
            );
        })
        .catch((error) => {
            console.error("Error al eliminar categoría:", error);
            showErrorMessage(extractErrorMessage(error));
        });
};

//Para agregar una categoria
const agregarCategoria = () => {
    if (!nuevaCategoria.value.nombre) {
        showErrorMessage("El nombre de la categoría es obligatorio");
        return;
    }
    
    axios
        .post("/api/categoria", nuevaCategoria.value, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
        .then((response) => {
            //Agregar la nueva categoría a la lista
            categorias.value.push(response.data);

            //Reiniciar el formulario
            nuevaCategoria.value = {
                nombre: "",
                descripcion: "",
            };
        })
        .catch((error) => {
            console.error("Error al agregar categoría:", error);
            showErrorMessage(extractErrorMessage(error));
        });
};
</script>

<style scoped></style>