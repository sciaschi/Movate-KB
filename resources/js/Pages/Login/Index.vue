<template>
    <Head title="Login" />

    <auth-card>
        <form method="POST" :action="route('login')">
            <input type="hidden" name="_token" :value="csrf">

            <!-- Email Address -->
            <div>
                <input-label for="email" value="Email" />

                <text-input v-model="form.email" :error="form.errors.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <input-label for="password" value="Password" />

                <text-input id="password" class="block mt-1 w-full"
                              type="password"
                              name="password"
                              v-model="form.password"
                              :error="form.errors.password"
                              required autocomplete="current-password" />

<!--                <input-error :messages="$errors->get('password')" class="mt-2" />-->
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input v-model="form.remember" id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" :href="route('password.request')">
                    Forgot your password?
                </a>

                <button type="button" @click="submit" class="ml-3">
                    Log In
                </button>
            </div>
        </form>
    </auth-card>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3'
import PrimaryButton from "../../Shared/Widgets/primary-button";
import InputLabel from "../../Shared/Widgets/input-label";
import TextInput from "../../Shared/Widgets/text-input";
import AuthSessionStatus from "../../Shared/Widgets/auth-session-status";
import AuthCard from "../../Shared/Widgets/auth-card";
import { Inertia } from '@inertiajs/inertia'

export default {
    name: "Index",
    components: {
        AuthCard,
        AuthSessionStatus,
        TextInput,
        InputLabel,
        PrimaryButton,
        Head,
    },
    data: () => ({
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        form: Inertia.form({
            email: null,
            password: null,
            remember: false,
        }),
    }),
    methods: {
        submit : function(e){
            // e.preventDefault();
            // e.target.closest('form').submit();
            this.form.post('/login');
        }
    },
}
</script>

<style scoped>

</style>
