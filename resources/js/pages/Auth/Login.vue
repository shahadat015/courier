<template>
    <div class="flex items-center p-6 bg-gray-50 dark:bg-gray-900">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <img class="w-32 h-10 object-cover mb-6" :src="settings.logo" alt="">
                        <h2 class="mb-2 text-xl font-semibold text-gray-700 dark:text-gray-200">Welcome back!</h2>
                        <p class="mb-6 text-sm text-gray-700 dark:text-gray-200">Enter your email address and password to access merchant panel.</p>
                        <span class="text-xs text-red-600 dark:text-red-400" v-if="errors && errors.message">{{ errors.message }}</span>
                        <form @submit.prevent="login">
                        
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Username</span>
                                <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                    <app-input
                                        :value="form.username"
                                        @inputEvent="form.username = $event"
                                        placeholder="Phone or Email"
                                        classes="pl-10"
                                    />
                                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <app-error :errors="errors" field="username"></app-error>
                            </label>
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Password</span>
                                <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                    <app-input 
                                        :value="form.password"
                                        @inputEvent="form.password = $event"
                                        type="password" 
                                        placeholder="Enter your password"
                                        classes="pl-10"
                                    />

                                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                </div>
                                <app-error :errors="errors" field="password"></app-error>
                            </label>

                            <div class="flex mt-6 text-sm">
                                <label class="flex items-center dark:text-gray-400">
                                    <input v-model="form.remember" type="checkbox" class="text-purple-600 form-checkbox border focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" />
                                    <span class="ml-2">
                                        Remenber me
                                    </span>
                                </label>
                            </div>

                            <!-- You should use a button here, as the anchor is only used for the example  -->
                            <app-button :disabled="loading" classes="w-full mt-4 inline-flex justify-center">
                                <svg v-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Log in
                            </app-button>
                        </form>

                        <hr class="my-8" />

                        <p class="mt-1">
                            <router-link class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" :to="{ name: 'register'}">
                                Don't have an acount? Sign Up
                            </router-link>
                        </p>
                        <!-- <p class="mt-4">
                            <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="./forgot-password.html">
                                Forgot your password?
                            </a>
                        </p> -->
                    </div>
                </div>
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-cover w-full h-full dark:hidden" src="/images/login-office.jpeg" alt="Office" />
                    <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block" src="/images/login-office-dark.jpeg" alt="Office" />
                </div>
            </div>
        </div>
    </div>

</template>
<script>
    import AppButton from '../../components/Form/Button.vue';
    import AppInput from '../../components/Form/Input.vue';
    import AppError from '../../components/ValidationError.vue';
    import { mapActions, mapGetters } from 'vuex';

    export default {
        components: {
            AppButton,
            AppInput,
            AppError
        },

        data(){
            return {
                form: {
                    username: '',
                    password: '',
                    remember: true,
                },
                errors: {},
                loading: false,
            }
        },

        
        computed: {
            ...mapGetters({
                settings: 'settings/settings'
            })
        },
        
        methods: {
            ...mapActions({
                signIn: 'auth/signIn'
            }),

            async login() {
                try {
                    this.loading = true;
                    await this.signIn(this.form)
                    this.loading = false;
                    this.$router.go({ name: 'dashboard' });
                } catch (error){
                    if(error.response.status == '422') {
                        this.errors = error.response.data.errors;
                    }else{
                        this.errors = error.response.data;
                    }
                    this.loading = false;
                }

            }
        }
    }
</script>