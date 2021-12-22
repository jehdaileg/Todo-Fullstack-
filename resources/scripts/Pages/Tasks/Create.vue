<template>
<app-layout>

    <Link href="/" class="block mb-3">&xlarr;</Link>

        <h1 class="text-3xl font-bold">Create Task</h1>

        <div class="add_task-form">

            <div class="flex justify-center">
                        <div class="w-full max-w-xs">
                        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 my-32" @submit.prevent="saveTask">
                            <div class="mb-4">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="title">
                                Title
                            </label>
                            <input v-model="form.title" class="shadow appearance-none border rounded w-full py-2 px-3" id="title" type="text" placeholder="Title...">
                            </div>

                            <div class="mb-6">
                                  <label class="block text-grey-darker text-sm font-bold mb-2" for="title">
                                Category
                                 </label>
                              <div class="relative">
                                <select  v-model="form.category_id" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option v-for="category in categories" :key="category.id"  :value="category.id">{{ category.name }}</option>
                                    </select>
                              </div>
                            </div>
                            <div class="flex items-center justify-between">
                            <button class="bg-green-500 w-full hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Save
                            </button>

                            </div>
                    </form>

</div>
</div>

        </div>


</app-layout>
</template>

<script setup>

import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-vue3";

let form = useForm({
    title: '',
    category_id: '',
});

defineProps({
    'categories': Array
});

let saveTask = () => {
    Inertia.post('/tasks', form);
};

</script>
