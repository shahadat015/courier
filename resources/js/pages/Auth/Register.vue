<template>
    <div class="flex items-center p-6 bg-gray-50 dark:bg-gray-900">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <img class="w-32 h-10 object-cover mb-6" :src="settings.logo" alt="">
                        <h2 class="mb-2 text-xl font-semibold text-gray-700 dark:text-gray-200">
                            Register with us!
                        </h2>
                        <p class="mb-6 text-sm text-gray-700 dark:text-gray-200">Enter your personal and company information below</p>
                        <form @submit.prevent="register">
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Phone</span>
                                <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                    <app-input 
                                        placeholder="01XXXXXXXX"
                                        :value="form.phone"
                                        @inputEvent="form.phone = $event"
                                        classes="pl-10"
                                    />
                                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                </div>
                                <app-error :errors="errors" field="phone" ></app-error>
                            </label>
                            <label class="block text-sm mt-4">
                                <span class="text-gray-700 dark:text-gray-400">Email</span>
                                <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                    <app-input 
                                        type="email" 
                                        placeholder="Enter your email"
                                        :value="form.email"
                                        @inputEvent="form.email = $event"
                                        classes="pl-10"
                                    />
                                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <app-error :errors="errors" field="email" ></app-error>
                            </label>
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Password</span>
                                <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                    <app-input 
                                        type="password" 
                                        placeholder="Enter your password"
                                        :value="form.password"
                                        @inputEvent="form.password = $event"
                                        classes="pl-10"
                                    />
                                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                </div>
                                <app-error :errors="errors" field="password" ></app-error>
                            </label>
                            <label class="block text-sm mt-4">
                                <span class="text-gray-700 dark:text-gray-400">Merchant Name</span>
                                <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                    <app-input 
                                        placeholder="Enter your Full name"
                                        :value="form.name"
                                        @inputEvent="form.name = $event"
                                        classes="pl-10"
                                    />
                                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <app-error :errors="errors" field="name" ></app-error>
                            </label>
                            <label class="block text-sm mt-4">
                                <span class="text-gray-700 dark:text-gray-400">Business Name</span>
                                <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                    <app-input 
                                        placeholder="Enter your Business Name"
                                        :value="form.business_name"
                                        @inputEvent="form.business_name = $event"
                                        classes="pl-10"
                                    />
                                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <app-error :errors="errors" field="business_name" ></app-error>
                            </label>
                            <label class="block text-sm mt-4">
                                <span class="text-gray-700 dark:text-gray-400">Pickup Location</span>
                                <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                    <app-input 
                                        placeholder="Enter your pickup location"
                                        :value="form.pickup_location"
                                        @inputEvent="form.pickup_location = $event"
                                        classes="pl-10"
                                    />
                                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <app-error :errors="errors" field="pickup_location" ></app-error>
                            </label>

                            <div class="flex mt-6 text-sm">
                                <label class="flex items-center dark:text-gray-400">
                                    <input type="checkbox" class="text-purple-600 form-checkbox border focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" />
                                    <span class="ml-2">
                                        I accept
                                        <span class="underline">Terms and Conditions</span>
                                    </span>
                                </label>
                            </div>

                            <!-- You should use a button here, as the anchor is only used for the example  -->
                            <app-button :disabled="loading" classes="w-full mt-4 inline-flex justify-center">
                                <svg v-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Sign Up
                            </app-button>
                        </form>

                        <hr class="my-8" />

                        <p class="mt-4">
                            <router-link class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" :to="{ name: 'login' }">
                                Already have an account? Login
                            </router-link>
                        </p>
                    </div>
                </div>
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-cover w-full h-full dark:hidden" src="/images/create-account-office.jpeg" alt="Office" />
                    <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block" src="/images/create-account-office-dark.jpeg" alt="Office" />
                </div>
            </div>
        </div>
    </div>

</template>
<script>
    import AppButton from '../../components/Form/Button.vue'
    import AppInput from '../../components/Form/Input.vue'
    import AppError from '../../components/ValidationError.vue'
    import { mapActions, mapGetters } from 'vuex'

    export default {
        components: {
            AppButton,
            AppInput,
            AppError
        },

        data(){
            return {
                form: {
                    name: '',
                    email: '',
                    phone: '',
                    password: '',
                    business_name: '',
                    pickup_location: '',
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
                signUp: 'auth/signUp'
            }),

            async register() {
                try {
                    this.loading = true;
                    await this.signUp(this.form)
                    this.loading = false;
                    this.$router.go({ name: 'dashboard' });
                } catch (error){
                    this.errors = error.response.data.errors;
                    this.loading = false;
                }

            }
        }
    }
</script>