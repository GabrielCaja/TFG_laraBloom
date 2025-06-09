<template>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            Gestión de Productos
        </h1>

        <!-- Formulario de agregación -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">
                Agregar nuevo producto
            </h2>
            <form class="flex flex-wrap gap-4 items-end" @submit.prevent>
                <div class="flex-grow min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Nombre</label
                    >
                    <input
                        type="text"
                        placeholder="Nombre del producto"
                        class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        v-model="nuevoProducto.nombre"
                    />
                </div>
                <div class="flex-grow min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Descripción</label
                    >
                    <textarea
                        placeholder="Descripción del producto"
                        class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        v-model="nuevoProducto.descripcion"
                    ></textarea>
                </div>
                <div class="w-36">
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Precio</label
                    >
                    <input
                        type="decimal"
                        step="0.01"
                        placeholder="0.00"
                        class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        v-model="nuevoProducto.precio"
                    />
                </div>
                <div class="w-36">
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Stock</label
                    >
                    <input
                        type="number"
                        placeholder="0"
                        class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        v-model="nuevoProducto.stock"
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Categoría</label
                    >
                    <select
                        class="bg-white border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        v-model="nuevoProducto.categoria_id"
                    >
                        <option value="" disabled>Seleccione categoría</option>
                        <option
                            v-for="categoria in categorias"
                            :key="categoria.id"
                            :value="categoria.id"
                        >
                            {{ categoria.nombre }}
                        </option>
                    </select>
                </div>
                <div class="flex-grow min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Imagen del producto</label
                    >
                    <input
                        type="file"
                        accept="image/*"
                        @change="subirImagen"
                        class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    />
                    <img
                        v-if="nuevoProducto.rutaImg"
                        :src="nuevoProducto.rutaImg"
                        class="mt-2 h-32 object-contain"
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Visible</label
                    >
                    <select
                        class="bg-white border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        v-model="nuevoProducto.visible"
                    >
                        <option :value="true">Mostrar</option>
                        <option :value="false">Ocultar</option>
                    </select>
                </div>
                <div>
                    <button
                        @click="agregarProducto"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-5 rounded-lg transition-colors"
                    >
                        Agregar producto
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabla de productos -->
        <div class="overflow-x-auto shadow-lg rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-white uppercase bg-blue-600">
                    <tr>
                        <th scope="col" class="px-6 py-4 cursor-pointer" @click="cambiarOrden('id')">
                            ID
                            <span v-if="ordenarPor === 'id'" class="ml-1">{{ ordenAscendente ? '↑' : '↓' }}</span>
                        </th>
                        <th scope="col" class="px-6 py-4">Imagen</th>
                        <th scope="col" class="px-6 py-4 cursor-pointer" @click="cambiarOrden('nombre')">
                            Nombre
                            <span v-if="ordenarPor === 'nombre'" class="ml-1">{{ ordenAscendente ? '↑' : '↓' }}</span>
                        </th>
                        <th scope="col" class="px-6 py-4 cursor-pointer" @click="cambiarOrden('precio')">
                            Precio
                            <span v-if="ordenarPor === 'precio'" class="ml-1">{{ ordenAscendente ? '↑' : '↓' }}</span>
                        </th>
                        <th scope="col" class="px-6 py-4 cursor-pointer" @click="cambiarOrden('stock')">
                            Stock
                            <span v-if="ordenarPor === 'stock'" class="ml-1">{{ ordenAscendente ? '↑' : '↓' }}</span>
                        </th>
                        <th scope="col" class="px-6 py-4 cursor-pointer" @click="cambiarOrden('categoria_id')">
                            Categoría
                            <span v-if="ordenarPor === 'categoria_id'" class="ml-1">{{ ordenAscendente ? '↑' : '↓' }}</span>
                        </th>
                        <th scope="col" class="px-6 py-4 cursor-pointer" @click="cambiarOrden('visible')">
                            Visible
                            <span v-if="ordenarPor === 'visible'" class="ml-1">{{ ordenAscendente ? '↑' : '↓' }}</span>
                        </th>
                        <th scope="col" class="px-6 py-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="producto in productosOrdenados"
                        :key="producto.id"
                        class="bg-white border-b hover:bg-gray-50 transition-colors"
                    >
                        <td class="px-6 py-4 font-medium">{{ producto.id }}</td>

                        <td class="px-6 py-4 font-medium">
                            <img
                                v-if="producto.rutaImg"
                                :src="producto.rutaImg"
                                alt="Imagen del producto"
                                class="h-16 w-16 object-cover rounded"
                            />
                            <span v-else class="text-gray-400">Sin imagen</span>
                        </td>

                        <td class="px-6 py-4">{{ producto.nombre }}</td>
                        <td class="px-6 py-4">{{ producto.precio }}€</td>
                        <td class="px-6 py-4">{{ producto.stock }}</td>
                        <td class="px-6 py-4">
                            {{ getNombreCategoria(producto.categoria_id) }}
                        </td>
                        <td class="px-6 py-4">
                            <span
                                :class="
                                    producto.visible
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-red-100 text-red-800'
                                "
                                class="px-2.5 py-1 rounded-full text-xs font-medium"
                            >
                                {{ producto.visible ? "Visible" : "Oculto" }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-3">
                                <button
                                    @click="editarProducto(producto)"
                                    class="font-medium text-blue-600 hover:text-blue-800 flex items-center"
                                >
                                    <span>Editar</span>
                                </button>
                                <button
                                    @click="eliminarProducto(producto.id)"
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

        <!-- Modal para editar producto -->
        <div
            v-if="mostrarModal"
            class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4"
        >
            <div
                class="bg-white rounded-xl shadow-2xl w-full max-w-2xl transform transition-all"
            >
                <div class="border-b px-6 py-4">
                    <h2 class="text-xl font-bold text-gray-800">
                        Editar Producto
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
                            v-model="productoEditando.nombre"
                        />
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Descripción</label
                        >
                        <textarea
                            class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            v-model="productoEditando.descripcion"
                        ></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                                >Precio</label
                            >
                            <input
                                type="decimal"
                                step="0.01"
                                class="w-full bg-white border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                v-model="productoEditando.precio"
                            />
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                                >Stock</label
                            >
                            <input
                                type="number"
                                class="w-full bg-white border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                v-model="productoEditando.stock"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                                >Categoría</label
                            >
                            <select
                                class="w-full bg-white border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                v-model="productoEditando.categoria_id"
                            >
                                <option
                                    v-for="categoria in categorias"
                                    :key="categoria.id"
                                    :value="categoria.id"
                                >
                                    {{ categoria.nombre }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                                >Visibilidad</label
                            >
                            <select
                                class="w-full bg-white border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                v-model="productoEditando.visible"
                            >
                                <option :value="true">Visible</option>
                                <option :value="false">Oculto</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex-grow min-w-[200px]">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Imagen</label
                        >
                        <input
                            type="file"
                            accept="image/*"
                            @change="(e) => subirImagen(e, true)"
                            class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        />
                        <img
                            v-if="productoEditando.rutaImg"
                            :src="productoEditando.rutaImg"
                            class="mt-2 h-32 object-contain"
                        />
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
                        @click="actualizarProducto"
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
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import { showErrorMessage, extractErrorMessage } from '../errorHandler';

//Variables para ordenación
const ordenarPor = ref('id');
const ordenAscendente = ref(true);

//Función para cambiar el criterio de ordenación
const cambiarOrden = (campo) => {
    if (ordenarPor.value === campo) {
        //Si ya estábamos ordenando por este campo, invertimos la dirección
        ordenAscendente.value = !ordenAscendente.value;
    } else {
        //Si cambiamos de campo, establecemos orden ascendente por defecto
        ordenarPor.value = campo;
        ordenAscendente.value = true;
    }
};

//Transformar imagen
const subirImagen = (event, esEdicion = false) => {
    const file = event.target.files[0];
    if (!file) return;

    // Verificar tamaño (máximo 2MB) para no saturar la base de datos
    if (file.size > 2 * 1024 * 1024) {
        alert("La imagen no debe superar los 2MB");
        return;
    }

    //Convertir a base64
    const reader = new FileReader();
    reader.onload = (e) => {
        if (esEdicion) {
            productoEditando.value.rutaImg = e.target.result;
        } else {
            nuevoProducto.value.rutaImg = e.target.result;
        }
    };
    reader.readAsDataURL(file);
};

//Estados reactivos
const mostrarModal = ref(false);
const productos = ref([]);
const categorias = ref([]);

//Estado para el producto que se está editando
const productoEditando = ref({
    id: null,
    nombre: "",
    descripcion: "",
    precio: 0,
    stock: 0,
    categoria_id: null,
    rutaImg: "",
    visible: true,
});

//Estado para un nuevo producto
const nuevoProducto = ref({
    nombre: "",
    descripcion: "",
    precio: 0,
    stock: 0,
    categoria_id: "",
    rutaImg: "",
    visible: true,
});

//Productos ordenados según criterio seleccionado
const productosOrdenados = computed(() => {
    return [...productos.value].sort((a, b) => {
        let valorA = a[ordenarPor.value];
        let valorB = b[ordenarPor.value];
        
        //Manejo especial para categoría (mostrar el nombre en vez del ID)
        if (ordenarPor.value === 'categoria_id') {
            const categoriaA = categorias.value.find(c => c.id === valorA);
            const categoriaB = categorias.value.find(c => c.id === valorB);
            valorA = categoriaA ? categoriaA.nombre : '';
            valorB = categoriaB ? categoriaB.nombre : '';
        }
        
        //Comparación según tipo de dato
        if (typeof valorA === 'string' || ordenarPor.value === 'categoria_id') {
            // Ordenación por strings 
            valorA = String(valorA).toLowerCase();
            valorB = String(valorB).toLowerCase();
            const comparacion = valorA.localeCompare(valorB);
            return ordenAscendente.value ? comparacion : -comparacion;
        } else if (typeof valorA === 'number') {
            //Ordenación para números
            const comparacion = valorA - valorB;
            return ordenAscendente.value ? comparacion : -comparacion;
        } else if (typeof valorA === 'boolean') {
            //Ordenación para booleanos
            const comparacion = valorA === valorB ? 0 : valorA ? 1 : -1;
            return ordenAscendente.value ? comparacion : -comparacion;
        } else {
            const comparacion = valorA > valorB ? 1 : valorA < valorB ? -1 : 0;
            return ordenAscendente.value ? comparacion : -comparacion;
        }
    });
});

//Token de autenticación
const token = localStorage.getItem("access_token");

//Cargar productos y categorías al iniciar
onMounted(() => {
    cargarProductos();
    cargarCategorias();
});

//Obtener todos los productos
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

//Obtener el nombre de una categoría por su ID
const getNombreCategoria = (categoriaId) => {
    const categoria = categorias.value.find((c) => c.id === categoriaId);
    return categoria ? categoria.nombre : "Desconocida";
};

//Abrir modal para editar un producto
const editarProducto = (producto) => {
    productoEditando.value = {
        id: producto.id,
        nombre: producto.nombre,
        descripcion: producto.descripcion,
        precio: producto.precio,
        stock: producto.stock,
        categoria_id: producto.categoria_id,
        rutaImg: producto.rutaImg,
        visible: producto.visible,
    };
    mostrarModal.value = true;
};

//Cerrar el modal
const cerrarModal = () => {
    mostrarModal.value = false;
    productoEditando.value = {
        id: null,
        nombre: "",
        descripcion: "",
        precio: 0,
        stock: 0,
        categoria_id: null,
        rutaImg: "",
        visible: true,
    };
};
//Mostrar mensaje de error
const actualizarProducto = () => {
    axios
        .put(
            `/api/producto/${productoEditando.value.id}`,
            productoEditando.value,
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        )
        .then((response) => {
            //Actualizar el producto en la lista local
            const index = productos.value.findIndex(
                (p) => p.id === productoEditando.value.id
            );
            if (index !== -1) {
                productos.value[index] = productoEditando.value;
            }
            cerrarModal();
        })
        .catch((error) => {
            console.error("Error al actualizar producto:", error);
            showErrorMessage(extractErrorMessage(error));
        });
};

//Para eliminar un producto
const eliminarProducto = (id) => {
    if (!confirm("¿Estás seguro de que deseas eliminar este producto?")) {
        return;
    }

    axios
        .delete(`/api/producto/${id}`, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
        .then(() => {
            productos.value = productos.value.filter(
                (producto) => producto.id !== id
            );
        })
        .catch((error) => {
            console.error("Error al eliminar producto:", error);
            showErrorMessage(extractErrorMessage(error));
        });
};

//Para agregar un producto
const agregarProducto = () => {
    axios
        .post("/api/producto", nuevoProducto.value, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        })
        .then((response) => {
            //Agregar el nuevo producto a la lista
            productos.value.push(response.data);

            //Reiniciar el formulario
            nuevoProducto.value = {
                nombre: "",
                descripcion: "",
                precio: 0,
                stock: 0,
                categoria_id: "",
                rutaImg: "",
                visible: true,
            };
        })
        .catch((error) => {
            console.error("Error al agregar producto:", error);
            showErrorMessage(extractErrorMessage(error));
        });
};
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}

th:hover {
    background-color: rgba(255, 255, 255, 0.1);
}
</style>