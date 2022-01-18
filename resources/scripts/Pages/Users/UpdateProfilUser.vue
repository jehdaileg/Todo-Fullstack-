<template>
    <div>
        <Head title="Update User Profile" />

        <h1 class="font-display text-4xl font-bold mb-4">Update Profile</h1>

        <form
            @submit.prevent="form.post('user-update-profil')"
            class="flex flex-col items-center"
        >
            <div
                :class="{ hidden: !form.avatar }"
                class="text-right w-full cursor-pointer"
                @click="
                    form.avatar = null;
                    src = null;
                "
            >
                <XIcon class="h-5 w-5 inline" />
            </div>

            <img
                class="h-32 w-32 bg-white rounded-full"
                :src="src ?? '/storage/avatars/avatar_default.jpg'"
                alt=""
            />
            <div class="mt-4">
                <label
                    for="avatar"
                    :class="{ hidden: form.avatar }"
                    class="cursor-pointer px-8 py-2 text-white bg-black"
                    >Upload a photo</label
                >
                <input
                    class="hidden"
                    id="avatar"
                    type="file"
                    @input="
                        form.avatar = $event.target.files[0];
                        changeSrc(form.avatar);
                    "
                />
                <button
                    type="submit"
                    :class="{ hidden: !form.avatar }"
                    class="cursor-pointer px-8 py-2 text-white bg-black"
                >
                    Validate
                </button>
            </div>
            <p class="mt-8">
                <Link href="/" class="underline text-sm">Quit the page</Link>
            </p>
        </form>
    </div>
</template>
<script setup>
import { ref } from "vue";
import { Head, useForm, Link } from "@inertiajs/inertia-vue3";
import { XIcon } from "@heroicons/vue/outline";
const src = ref(null);
const form = useForm({
    avatar: null,
});
function changeSrc(avatar) {
    src.value = URL.createObjectURL(avatar);
}
</script>
