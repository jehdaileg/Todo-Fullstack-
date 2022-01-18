<template>
    <div>

        <Navbar></Navbar>

        <div class="text-blue-500">
            Categories
        </div>

        <div class="container flex justify-center mx-auto">
    <div class="flex flex-col">
        <div class="w-full">
            <div class="border-b border-gray-200 shadow">
                <table>
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-2 text-xs text-gray-500">
                                ID
                            </th>
                            <th class="px-6 py-2 text-xs text-gray-500">
                                Name
                            </th>

                            <th class="px-6 py-2 text-xs text-gray-500">
                                Image

                            </th>

                            <th class="px-6 py-2 text-xs text-gray-500">
                                Created_at
                            </th>
                            <th class="px-6 py-2 text-xs text-gray-500">
                                Edit
                            </th>
                            <th class="px-6 py-2 text-xs text-gray-500">
                                Delete
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr class="whitespace-nowrap" v-for="(category, index) in categories" :key="index">
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ category.id }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ category.name }}
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                   <img :src="category.image" style="width: 80px; height:80px;" class="w-12 h-12 rounded" alt="">
                                </div>
                                <div v-if="category.image == null" class="text-red">No image available for this cat</div>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{  category.created_at }}
                            </td>
                            <td class="px-6 py-4">
                                <Link :href="`/categories/${category.id}/edit`" class="px-4 py-1 text-sm text-white bg-blue-400 rounded">Edit</Link>
                            </td>
                            <td class="px-6 py-4">
                                <Link :href="`/categories/${category.id}`" method="delete" as="button" class="px-4 py-1 text-sm text-white bg-red-400 rounded">Delete</Link>
                            </td>
                        </tr>



                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    </div>
</template>

<script setup>

import Navbar from "~/Partials/Navbar.vue";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    categories: Array,

});

console.log(props.categories)
</script>
