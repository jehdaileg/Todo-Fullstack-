<template>
    <div class="navbar">
        <Navbar />
    </div>

    <div class="profil_section flex space-x-4 mb-6">
        <div>
            <img
                    class="h-16 w-16 rounded-full"
                    :src="`${
                        user.photo ?
                        '/storage/' + user.photo :
                        '/storage/avatars/avatar_default.jpg'
                    }`"
                    :alt="`${user.firstname} ${user.lastname} avatar`"
                />
        </div>

         <div class="uppercase text-xs space-y-px pt-1">
                <p>{{ user.firstname }}</p>
                <p>{{ user.lastname }}</p>
                <Link
                    method="POST"
                    href="/logout"
                    as="button"
                    type="submit"
                    class="uppercase italic underline font-bold"
                    >Logout</Link
                >
            </div>
    </div>
    <div class="body">
        <h1 class="text-3xl font-bold">Tasks List</h1>
        <Link
            href="/tasks/create"
            class="block mt-3 mb-5 text-sm underline-offset-2"
            >Add Task</Link
        >

        <ul class="tasks" v-if="tasks.length">
            <li
                class="cursor-default"
                :title="`${
                    task.completed
                        ? 'click to uncomplete the task'
                        : 'clik to complete the task'
                }`"
                :class="{ 'line-through': task.completed }"
                v-for="task in tasks"
                :key="task.id"
            >
                <div class="form_for_check_box">
                    <form>
                        <input
                            type="checkbox"
                            name="`task_${task.id}`"
                            v-model="task.selected"
                            @click="task.selected = !task.selected"
                        />
                    </form>
                </div>
                {{ task.title }}
                <div class="flex space-x-4">
                    <span
                        :class="{ 'line-through': task.completed }"
                        @click="finishThisTask(task)"
                    >
                        <CheckIcon class="h-5 w-5" />
                    </span>

                    <span @click="deleteThisTask(task)">
                        <XIcon class="h-5 w-5" />
                    </span>

                    <span @click="displayModal(task)">
                        <PencilAltIcon class="h-5 w-5" />
                    </span>
                </div>

                <ModalUpdateTask
                    :open="open"
                    :task="task"
                    @close="closeModal"
                />
            </li>
        </ul>

        <div v-else>No datas</div>

        <footer class="mt-4 bg-gray-300 flex justify-start">
            <div>
                <AllSelectedBlock />
            </div>

            <div class="all">
                <label for="FIlter">Filter</label>
                <select
                    v-model="statustask"
                    @change="filterByStatus(statustask)"
                >
                    <option value="uncompleted">Unfinished</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <div class="ml-4">
                statustask=completed&category=Music
                <label for="categories">Categories</label>
                <select v-model="category" @change="filterByCategory(category)">
                    <option
                        :value="category.name"
                        v-for="category in categories"
                        :key="category.id"
                    >
                        {{ category.name }}
                    </option>
                </select>
            </div>

            <div class="ml-4">
                <p>Filter.</p>
            </div>
        </footer>

        <div class="actions_btn flex space-x-6 mt-5">
            <CompleteButton />

            <DeleteButton />
        </div>
    </div>
</template>

<script setup>
import Navbar from "~/Partials/Navbar.vue";
import { provide, ref, watch } from "vue";
import { Link, usePage } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { useToast } from "vue-toastification";
import AllSelectedBlock from "~/components/tasks/AllSelectedBlock.vue";
import CompleteButton from "~/components/tasks/actions/CompleteButton.vue";
import DeleteButton from "~/components/tasks/actions/DeleteButton.vue";
import ModalUpdateTask from "~/components/tasks/modals/ModalUpdateTask.vue";
import { CheckIcon, XIcon, PencilAltIcon } from "@heroicons/vue/outline";

const {
    auth: { user },

} = usePage().props.value;


const props = defineProps({
    tasks: Array,
    categories: Array,
});

const open = ref(false);

const tasks = ref(props.tasks);
const categories = ref(props.categories);

const categoryQueryString = getQueryString("category");
const statustaskQueryString = getQueryString("statustask");

const category = ref(categoryQueryString ?? "");
const statustask = ref(statustaskQueryString ?? "");

const toast = useToast();

/*const finishTask = (task) => {
    Inertia.put(`/update/${task.id}`, {completed: !task.completed }, { replace: true });

    if (!task.completed) {
        toast.success("Task completed with success", {
            timeout: 1500,
        });
    }
}; */

function filterByCategory(category) {
    statustask.value
        ? Inertia.get(
              "/",
              { statustask: statustask.value, category },
              { preserveState: true }
          )
        : Inertia.get("/", { category }, { preserveState: true });
}

function filterByStatus(statustask) {
    category.value
        ? Inertia.get(
              "/",
              { category: category.value, statustask },
              { preserveState: true }
          )
        : Inertia.get("/", { statustask }, { preserveState: true });
}

function getQueryString(name) {
    return new URLSearchParams(window.location.search).get(name);
}

function finishThisTask(task) {
    //console.log(task)

    Inertia.put(
        `/update/${task.id}`,
        { completed: !task.completed },
        {
            preserveState: false,

            onSuccess: () => {
                toast.success("Task Finished Successfully", {
                    timeout: 1500,
                });
            },
        }
    );
}

function deleteThisTask(task) {
    //console.log(task)
    Inertia.delete(`/destroy/${task.id}`, {
        preserveState: false,
        onSuccess: () => {
            toast.success("Task Deleted Successfully", {
                timeout: 1200,
            });
        },
    });
}

function displayModal(task) {
    if (task.completed) {
        return toast.error("No Available updated possible", {
            timeout: 1500,
        });
    }

    open.value = true;
}

function closeModal() {
    open.value = false;
}

provide("tasks", tasks);
provide("categories", categories);
</script>
<style></style>
