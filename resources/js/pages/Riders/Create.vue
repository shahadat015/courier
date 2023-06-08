<template>
	<main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-10 text-2xl font-semibold text-gray-700 text-center dark:text-gray-200">
                Register New Rider
            </h2>
            <div class="px-10 py-12 w-4/5 mx-auto bg-white rounded-sm shadow-md dark:bg-gray-800">
                <form @submit.prevent="submit" class="space-y-4">
                    <div class="sm:flex space-y-4 sm:space-y-0 sm:space-x-6">
                        <label class="block text-sm w-full sm:w-1/2">
                            <span class="text-gray-700 dark:text-gray-400">Rider Name</span>
                            <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                <app-input
                                    :value="form.name"
                                    @inputEvent="form.name = $event"
                                    placeholder="Full Name"
                                    classes="pl-10"
                                />
                                <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            <app-error :errors="errors" field="name"></app-error>
                        </label>
                        <label class="block text-sm w-full sm:w-1/2">
                            <span class="text-gray-700 dark:text-gray-400">Phone Number</span>
                            <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                <app-input
                                    :value="form.phone"
                                    @inputEvent="form.phone = $event"
                                    placeholder="01XXXXXXXXX"
                                    classes="pl-10"
                                    type="tel"
                                />
                                <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                            </div>
                            <app-error :errors="errors" field="phone"></app-error>
                        </label>
                    </div>
                    <div class="sm:flex space-y-4 sm:space-y-0 sm:space-x-6">
                        <label class="block text-sm w-full sm:w-1/2">
                            <span class="text-gray-700 dark:text-gray-400">Present Address</span>
                            <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                <app-textarea 
                                    :value="form.present_address"
                                    @inputEvent="form.present_address = $event"
                                    placeholder="Present Address"
                                    classes="pl-10"
                                />
                                <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                            <app-error :errors="errors" field="present_address"></app-error>
                        </label>
                        <label class="block text-sm w-full sm:w-1/2">
                            <span class="text-gray-700 dark:text-gray-400">Permanent Address</span>
                            <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                <app-textarea
                                    :value="form.permanent_address"
                                    @inputEvent="form.permanent_address = $event"
                                    placeholder="Permanent Address"
                                    classes="pl-10"
                                />
                                <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                            <app-error :errors="errors" field="permanent_address"></app-error>
                        </label>
                    </div>
                    <label class="block text-sm w-full">
                        <span class="text-gray-700 dark:text-gray-400">Reference</span>
                        <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                            <app-input
                                :value="form.reference"
                                @inputEvent="form.reference = $event"
                                placeholder="Reference Information"
                                classes="pl-10"
                            />
                            <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <app-error :errors="errors" field="reference"></app-error>
                    </label>
                    <app-button :disabled="loading" classes="w-full">Sign Up</app-button>
                </form>
            </div>
        </div>
    </main>
</template>
<script>
    import AppButton from '../../components/Form/Button.vue';
    import AppInput from '../../components/Form/Input.vue';
    import AppTextarea from '../../components/Form/Textarea.vue';
    import AppError from '../../components/ValidationError.vue';

    export default {
        components: {
            AppButton,
            AppTextarea,
            AppInput,
            AppError
        },

        data() {
            return {
                form: {
                    name: '',
                    phone: '',
                    present_address: '',
                    permanent_address: '',
                    reference: '',
                    role: 'rider',
                },
                errors: {},
                loading: false
            }
        },

        methods: {
            async submit() {
                try {
                    this.loading = true;
                    let { data } = await axios.post('/api/riders', this.form);
                    this.loading = false;
                    this.$notify({ text: data.message, type: data.success ? 'success' : 'error' });
                    Object.assign(this.$data, this.$options.data());
                } catch (error){
                    this.errors = error.response.data.errors;
                    this.loading = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            },
        },
    }
</script>