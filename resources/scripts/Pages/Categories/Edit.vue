<template>
<app-layout>

    <Link href="/categories" class="block mb-3">&xlarr;</Link>

        <h1 class="text-3xl font-bold">Update Category</h1>

        <div class="add_task-form">

            <div class="flex justify-center">
                        <div class="w-full max-w-xs">
                    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 my-32" @submit.prevent="updateCategory" enctype="multipart/form-data">
                            <div class="mb-4">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="title">
                                Name
                            </label>
                            <input v-model="form.name"  class="shadow appearance-none border rounded w-full py-2 px-3" id="title" type="text" placeholder="Title...">
                            </div>

                             <div class="mb-4">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="title">
                               Image:
                            </label>

                            <div class="m-2 p-2">
                                <img :src="image" />

                            </div>
                            <input @input="form.image = $event.target.files[0]"  class="shadow mb-2  border rounded w-full py-2 px-3" id="title" type="file">
                            </div>
                            <div v-if="form.progress"  class="w-full  bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mb-2">
                                           <div class="bg-blue-600 h-2.5 rounded-full"  :value="form.progress.percentage" :style="`width: ${form.progress.percentage}`"></div>
                              </div>

                            <div class="flex items-center justify-between">
                            <button class="bg-green-500 w-full hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Update
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


const props = defineProps({

    category: Object,
    image: String,

});


const form = useForm({
    name: props.category.name,
    image: null,
});

function updateCategory()
{

    Inertia.post(`/categories/${props.category.id}`, {

        _method: 'put',
        name: form.name,
        image: form.image,

    });
}



</script>
