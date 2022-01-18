
<template>
    <div>
        <Head>
            <title>Login</title>
        </Head>

        <h1 class="font-display text-4xl font-bold mb-4">Register</h1>

        <form @submit.prevent="form.post('/register')">
            <div class="flex">
                <label class="w-32" for="firstname">Firstname</label>
                <input
                    type="text"
                    name="firstname"
                    id="firstname"
                    class="form-input py-1 w-64"
                    v-model="form.firstname"
                    autofocus
                    required
                />
            </div>

            <div class="flex my-3">
                <label class="w-32" for="lastname">Lastname</label>
                <input
                    type="text"
                    name="lastname"
                    id="lastname"
                    class="form-input py-1 w-64"
                    v-model="form.lastname"
                    required
                />
            </div>

              <div class="flex my-3">
                <label class="w-32" for="lastname">Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-input py-1 w-64"
                    v-model="form.name"
                    required
                />
            </div>

            <div class="flex">
                <label class="w-32" for="email">Email</label>
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
                <label class="w-32" for="password">Password</label>
                <input
                    type="password"
                    name="title"
                    id="password"
                    class="form-input py-1 w-64"
                    v-model="form.password"
                    required
                />
            </div>

            <div class="flex">
                <label class="w-32" for="password">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="form-input py-1 w-64"
                    v-model="form.password_confirmation"
                    required
                />
            </div>

            <div class="ml-32 mt-3">
                <button type="submit" class="px-8 py-2 text-white bg-black">
                    Register
                </button>

                <p class="mt-3 text-sm">
                    If you already have an account.
                    <Link class="font-bold underline" href="/login">Login</Link>
                </p>
            </div>
        </form>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
const form = useForm({
    firstname: null,
    lastname: null,
    email: null,
    password: null,
    password_confirmation: null,
    name: null
});
</script>
