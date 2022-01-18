<template>
<button
class="flex space-x-1 items-center cursor-pointer"
@click="completeTasks"
>

<ThumbUpIcon class="h-4 w-4" />
<span class="underline text-sm">Done</span>

</button>

</template>

<script setup>

import { inject } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { ThumbUpIcon } from '@heroicons/vue/outline';
import { useToast, TYPE } from "vue-toastification";


const tasks = inject('tasks');

const toast = useToast();

function completeTasks()
{
    const selectedTasks = tasks.value.filter(
        (task) => task.selected && !task.completed
    );  //get selected and uncompleted tasks

    const length = selectedTasks.length;

    if(length === 0 || length ===1){
        return toast("Select at least two uncompleted tasks", {
            timeout: 1500,
            type: TYPE.INFO,
        });

    }

    if(length > 1){
        Inertia.post(
            "/complete/all",
            {
                tasks: selectedTasks.map((task) => task.id),
            },
            {
                preserveState: false,

                replace: true,

                onSuccess: () => {
                    toast(`${length} tasks completed Successfully`, {
                        timeout: 1500,
                        type: TYPE.SUCCESS
                    });
                }
            }
        );
    }

}

</script>
