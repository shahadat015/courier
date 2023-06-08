<template>
	<main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid my-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <app-profile :user="form"></app-profile>
                <div class="col-span-2 bg-white dark:bg-gray-800 shadow-md rounded-md p-8">
                    <app-tab :tabs="['General', 'Password']">
                        <template v-slot:General>
                            <form @submit.prevent="updateProfile">
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Name</span>
                                    <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                        <app-input 
                                            placeholder="Enter your full name"
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
                                    <span class="text-gray-700 dark:text-gray-400">Phone</span>
                                    <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                        <app-input 
                                            placeholder="01XXXXXXXX"
                                            :value="form.phone"
                                            @inputEvent="form.phone = $event"
                                            classes="pl-10"
                                            :disabled="can('merchant')"
                                        />
                                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <app-error :errors="errors" field="phone"></app-error>
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
                                            :disabled="can('merchant')"
                                        />
                                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <app-error :errors="errors" field="email" ></app-error>
                                </label>
                                <label class="block text-sm mt-4">
                                    <span class="text-gray-700 dark:text-gray-400">Profile photo</span>
                                    <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                        <app-input 
                                            type="file" 
                                            @change="selectImage"
                                            classes="pl-10"
                                        />
                                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <app-error :errors="errors" field="image" ></app-error>
                                </label>
                                <!-- You should use a button here, as the anchor is only used for the example  -->
                                <app-button :disabled="loading" classes="w-full mt-4 inline-flex justify-center">
                                    <svg v-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Update
                                </app-button>
                            </form>                    
                        </template>
                        <template v-slot:Password>
                            <form @submit.prevent="updatePassword">
                                <label class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Current Password</span>
                                    <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                        <app-input 
                                            type="password" 
                                            placeholder="Enter your current password"
                                            :value="current_password"
                                            @inputEvent="current_password = $event"
                                            classes="pl-10"
                                        />
                                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <app-error :errors="errors" field="current_password" ></app-error>
                                </label>
                                <label class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">New Password</span>
                                    <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                                        <app-input 
                                            type="password" 
                                            placeholder="Enter your new password"
                                            :value="password"
                                            @inputEvent="password = $event"
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
                                <!-- You should use a button here, as the anchor is only used for the example  -->
                                <app-button :disabled="loading" classes="w-full mt-4 inline-flex justify-center">
                                    <svg v-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Update
                                </app-button>
                            </form>
                        </template>
                    </app-tab>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
    import AppTab from '../../components/Tab.vue';
    import AppProfile from '../../components/Profile.vue';
    import AppInput from '../../components/Form/Input.vue';
    import AppButton from '../../components/Form/Button.vue';
    import AppError from '../../components/ValidationError.vue';
    import { mapGetters } from 'vuex'

    export default {
        components: {
            AppTab,
            AppProfile,
            AppInput,
            AppButton,
            AppError
        },

        data(){
            return {
                form: {
                    name: '',
                    email: '',
                    phone: '',
                    image: '',
                },
                image: '',
                current_password: '',
                password: '',
                errors: {},
                loading: false,
            }
        },

        beforeMount(){
            this.form = this.user;
        },

        computed: {
            ...mapGetters({
                user: 'auth/user'
            }),
        },

        methods: {
            selectImage(e){
                let file = e.target.files[0];
                this.image = file;
                this.form.image = URL.createObjectURL(file)
            },

            async updateProfile() {
                let formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('email', this.form.email);
                formData.append('phone', this.form.phone);
                if(typeof this.image == 'object'){
                    formData.append('image', this.image);
                }
                try {
                    this.loading = true;
                    let { data } = await axios.post(`/api/update/profile`, formData);
                    this.loading = false;
                    this.$notify({ text: data.message, type: data.success ? 'success' : 'error' });
                } catch (error){
                    this.errors = error.response.data.errors;
                    this.loading = false;
                }

            },
            async updatePassword() {
                try {
                    this.loading = true;
                    await axios.put(`/user/password`, { current_password: this.current_password, password: this.password });
                    this.loading = false;
                    this.$notify({ text: 'Password updated successfully', type: 'success' });
                } catch (error){
                    this.errors = error.response.data.errors;
                    this.loading = false;
                }

            }
        }
    }
</script>