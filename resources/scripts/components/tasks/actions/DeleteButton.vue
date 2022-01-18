<template>
    <button
        class="flex space-x-1 text-red-600 items-center cursor-pointer"
        @click="deleteTasks"
    >
        <TrashIcon class="h-4 w-4" />
        <span class="underline text-sm">Delete</span>
    </button>
</template>

<script setup>
import { inject } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { TrashIcon} from '@heroicons/vue/outline';
import { useToast, TYPE } from "vue-toastification";
const tasks = inject("tasks");
const toast = useToast();
function deleteTasks() {
    const selectedTasks = tasks.value.filter((task) => task.selected);
    const length = selectedTasks.length;
    if (length === 0 || length === 1) {
        return toast("Select at least two tasks to delete", {
            timeout: 1500,
            type: TYPE.INFO,
        });
    }
    if (length > 1) {
        Inertia.post(
            "/destroy/all",
            {
                tasks: selectedTasks.map((task) => task.id),
            },
            {
                preserveState: false,
                replace: true,
                onSuccess: () => {
                    toast(`${length} tasks deleted succefully`, {
                        timeout: 1500,
                        type: TYPE.SUCCESS,
                    });
                },
            }
        );
    }
}
</script>
