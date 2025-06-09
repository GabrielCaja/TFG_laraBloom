<template>
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Panel de Control</h1>

        <!-- Indicadores principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">
                            Total Usuarios
                        </p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ metrics.usuarios?.total || 0 }}
                        </p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="size-6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"
                            />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-500">
                        <span class="text-green-500 font-medium">{{
                            metrics.usuarios?.newsletter || 0
                        }}</span>
                        suscritos al newsletter
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">
                            Total Productos
                        </p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ metrics.productos?.total || 0 }}
                        </p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-green-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                            />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-500">
                        <span class="text-red-500 font-medium">{{
                            metrics.productos?.sin_stock || 0
                        }}</span>
                        sin stock disponible
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">
                            Total Ventas
                        </p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ metrics.ordenes?.total || 0 }}
                        </p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-purple-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                            />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-500">
                        Valor promedio:
                        <span class="text-purple-500 font-medium"
                            >{{ metrics.ordenes?.valor_promedio || 0 }}€</span
                        >
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">
                            Total Artículos
                        </p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ metrics.articulos?.total || 0 }}
                        </p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-yellow-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
                            />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid con 3 columnas: Productos vendidos, Productos valorados y Ventas mensuales -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Productos más vendidos -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    Productos más vendidos
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th
                                    class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Producto
                                </th>
                                <th
                                    class="px-4 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Unidades
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr
                                v-for="producto in metrics.productos_vendidos"
                                :key="producto.id"
                            >
                                <td
                                    class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-800"
                                >
                                    {{ producto.nombre }}
                                </td>
                                <td
                                    class="px-4 py-3 whitespace-nowrap text-sm text-right text-gray-800"
                                >
                                    {{ producto.total_vendidos }}
                                </td>
                            </tr>
                            <tr
                                v-if="
                                    !metrics.productos_vendidos ||
                                    metrics.productos_vendidos.length === 0
                                "
                            >
                                <td
                                    colspan="2"
                                    class="px-4 py-3 text-sm text-center text-gray-500"
                                >
                                    No hay datos disponibles
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Productos mejor valorados -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    Productos mejor valorados
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th
                                    class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Producto
                                </th>
                                <th
                                    class="px-4 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Valoración
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr
                                v-for="producto in metrics.productos_valorados"
                                :key="producto.id"
                            >
                                <td
                                    class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-800"
                                >
                                    {{ producto.nombre }}
                                </td>
                                <td
                                    class="px-4 py-3 whitespace-nowrap text-sm text-right text-gray-800"
                                >
                                    {{
                                        producto.promedio_valoracion
                                            ? Number(
                                                  producto.promedio_valoracion
                                              ).toFixed(1)
                                            : "-"
                                    }}
                                    / 5
                                </td>
                            </tr>
                            <tr
                                v-if="
                                    !metrics.productos_valorados ||
                                    metrics.productos_valorados.length === 0
                                "
                            >
                                <td
                                    colspan="2"
                                    class="px-4 py-3 text-sm text-center text-gray-500"
                                >
                                    No hay datos disponibles
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Ventas mensuales en tabla -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    Ventas Mensuales
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th
                                    class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Mes
                                </th>
                                <th
                                    class="px-4 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Total
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr
                                v-for="venta in metrics.ventas_mensuales"
                                :key="`${venta.año}-${venta.mes}`"
                            >
                                <td
                                    class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-800"
                                >
                                    {{ getNombreMes(venta.mes) }} {{ venta.año }}
                                </td>
                                <td
                                    class="px-4 py-3 whitespace-nowrap text-sm text-right text-gray-800"
                                >
                                    {{ formatearMoneda(venta.total) }}
                                </td>
                            </tr>
                            <tr
                                v-if="
                                    !metrics.ventas_mensuales ||
                                    metrics.ventas_mensuales.length === 0
                                "
                            >
                                <td
                                    colspan="2"
                                    class="px-4 py-3 text-sm text-center text-gray-500"
                                >
                                    No hay datos disponibles
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const metrics = ref({
    usuarios: { total: 0, newsletter: 0 },
    productos: { total: 0, visibles: 0, sin_stock: 0 },
    articulos: { total: 0 },
    ordenes: { total: 0, valor_promedio: 0 },
    productos_valorados: [],
    productos_vendidos: [],
    ventas_mensuales: [],
});

onMounted(async () => {
    try {
        const token = localStorage.getItem("access_token");
        const response = await axios.get("/api/metrics", {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });
        metrics.value = response.data;
    } catch (error) {
        console.error("Error al cargar métricas:", error);
    }
});

//Función para convertir el número de mes a nombre
const getNombreMes = (mes) => {
    const meses = [
        "Ene", "Feb", "Mar", "Abr", "May", "Jun",
        "Jul", "Ago", "Sep", "Oct", "Nov", "Dic",
    ];
    return meses[mes - 1];
};

//Función para formatear moneda
const formatearMoneda = (valor) => {
    return new Intl.NumberFormat('es-ES', {
        style: 'currency',
        currency: 'EUR'
    }).format(parseFloat(valor) || 0);
};
</script>