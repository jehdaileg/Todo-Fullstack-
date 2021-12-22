<template>


        <div class="navbar">
            <Navbar />
        </div>
        <div class="body">
            <h1 class="text-3xl font-bold">Tasks List</h1>
            <Link href="/tasks/create" class="block mt-3 mb-5 text-sm underline-offset-2">Add Task</Link>



            <div class="mb-4 space-x-3">
                  <ul class="categories " v-if="categories.length">
                <span @click="category.selected = !category.selected" :class="{'bg-gray-500': category.selected}" class="p-1 bg-black cursor-pointer rounded-lg mr-2 text-white" v-for="category in categories" :key="category.id">{{ category.name }}</span>

            </ul>
            </div>

            <ul class="tasks" v-if="tasks.length">
                <li v-for="task in tasks" :key="task.id">{{ task.title }}</li>
                <li></li>
            </ul>

            <div v-else>No datas</div>

        </div>


</template>


<script setup>
import Navbar from "~/Partials/Navbar.vue";
import { ref, watch } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    tasks: Array,
    categories: Array,
});

const categories = ref(
    props.categories.map((cat) => ({
        ...cat,
        selected: false
    }))
);


watch(

    categories,

    (current) => {

        current = current

         .filter((cat) => cat.selected)
         .map((cat) => cat.name);

         const data = Inertia.get(

             "/",
             { categories: current.join('+') },
             { replace: true, preserveState: true }

         );

         console.log(data);
    },

    { deep: true }

);



</script>
<style>


</style>
