<template>
    <div>
        <Head>
            <title>Login</title>
        </Head>

        <h1 class="font-display text-4xl font-bold mb-4">Login</h1>

        <form @submit.prevent="form.post('/login')">
            <div class="ml-16 text-sm text-red-600 mb-4" v-if="form.hasErrors">
                * {{ form.errors.email }}
            </div>

            <div class="flex">
                <label class="w-16" for="email">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-input py-1 w-64"
                    v-model="form.email"
                    required
                />
            </div>

            <div class="flex my-3">
                <label class="w-16" for="password">Password</label>
                <input
                    type="password"
                    name="title"
                    id="password"
                    class="form-input py-1 w-64"
                    v-model="form.password"
                    required
                />
            </div>

            <div class="ml-16">
                <button type="submit" class="px-4 py-1 text-white bg-black">
                    Login
                </button>

                <p class="text-sm mt-4">
                    if you do not have any accout yet.
                    <Link class="underline font-bold" href="/register"
                        >Create one</Link
                    >
                </p>
            </div>
        </form>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
const form = useForm({
    email: null,
    password: null,
});
</script>
