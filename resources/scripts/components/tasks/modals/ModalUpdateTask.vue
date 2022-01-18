<template>
    <Teleport to="body">
        <div
            v-if="open"
            class="z-[999] flex justify-center h-screen top-0 fixed right-0 left-0 bg-black/20"
        >
            <div class="bg-white shadow border max-h-72 w-96 mt-16 p-5">
                <div class="text-right">
                    <button @click="emit('close')">
                        <XIcon class="w-4 h-4 float-right" />
                    </button>
                </div>

                <form @submit.prevent="">
                    <h3 class="text-2xl">Update Task # {{ task.id }}</h3>
                    <label for="title" class="my-2 inline-block">Title</label>
                    <div class="mb-2">
                        <input
                            type="text"
                            class="form-input"
                            id="title"
                            v-model="task.title"
                        />
                    </div>

                    <button class="px-4 py-1 text-white bg-black" @click="updateTask(task)">
                        update
                    </button>
                </form>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { Inertia } from "@inertiajs/inertia";
import { XIcon } from "@heroicons/vue/outline";
import { useToast } from "vue-toastification";
import { provide } from "@vue/runtime-core";
const props = defineProps({
    open: Boolean,
    task: Object,
});
const emit = defineEmits(["close"]);

const toast = useToast();
function updateTask(task) {

    Inertia.put(
        `/update/${task.id}`,
        { title: task.title},
        {
            preserveState: false,
            onSuccess: () => {
                toast.success("Task completed with success", {
                    timeout: 1500,
                });

                emit('close')
            },
        }
    );
}


</script>
