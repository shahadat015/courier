<template>
	<main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <div class="p-6 my-6 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                <template v-if="! loading">
                    <h2 class="pb-4 mb-4 border-b border-gray-200 dark:border-gray-600 text-2xl text-center font-normal text-gray-700 dark:text-gray-200">
                        ID #{{ $route.params.id }}
                    </h2>
                    <div v-show="! is_editing" class="flex justify-between">
                        <div class="">
                            <div class="text-sm text-gray-700 dark:text-gray-300 leading-6">Merchant: {{ form.merchant_name }} </div>
                            <div class="text-sm text-gray-700 dark:text-gray-300 leading-6">Contact: {{ form.contact }} </div>
                            <div class="text-sm text-gray-700 dark:text-gray-300 leading-6">Pickup Location: {{ form.Pickup_location }} </div>
                            <div class="text-sm text-gray-700 dark:text-gray-300 leading-6">Estimated Parcel: {{ form.total_parcel }} </div>
                            <div class="text-sm text-gray-700 dark:text-gray-300 leading-6">Note: {{ form.note }} </div>
                            <div class="text-sm text-gray-700 dark:text-gray-300 leading-6">Entry: {{ form.created_at }}</div>
                            
                            <div class="text-sm text-gray-700 dark:text-gray-300 leading-6">Last Update: {{ form.updated_at }}</div>
                            <app-button class="mt-2" @click="is_editing = true">Edit</app-button>
                        </div>
                        <div>
                            <span class="px-2 py-1 font-normal text-xs leading-tight text-purple-700 bg-blue-100 rounded-sm dark:bg-purple-700 dark:text-purple-100">{{ form.status }}</span>
                        </div>
                    </div>
                    <form @submit.prevent="update" class="space-y-4" v-show="is_editing">
                        <div class="space-y-4">
                            <div class="w-full space-y-4">
                                <span class="text-gray-700 dark:text-gray-400">Select Location</span>
                                <label class="block text-sm">
                                    <label v-for="shop in form.shops" :key="shop.id" class="inline-flex items-center text-gray-600 dark:text-gray-400">
                                        <input type="radio" class="text-purple-600 form-radio border border-gray-300 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" v-model="form.shop_id" :value="form.shop_id">
                                        <span class="mx-2">{{ shop.pickup_location }}</span>
                                    </label><br>
                                    <app-error :errors="errors" field="shop_id"></app-error>
                                    <app-error :errors="errors" field="customer_phone"></app-error>
                                </label>
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">How many parcels?</span>
                                   <app-input 
                                        :value="form.total_parcel"
                                        @inputEvent="form.total_parcel = $event"
                                        placeholder="Estimated Parcels"
                                        type="number"
                                    />
                                    <app-error :errors="errors" field="total_parcel"></app-error>
                                </label>
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Note</span>
                                    <app-input 
                                        :value="form.note"
                                        @inputEvent="form.note = $event"
                                        placeholder="Special Instruction"
                                    />
                                    <app-error :errors="errors" field="note"></app-error>
                                </label>

                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Status</span>
                                    <app-select 
                                        :value="form.status"
                                        @changeEvent="form.status = $event"
                                        class="w-full block border border-gary-700"
                                    >
                                        <option value="Pending">Pending</option>
                                        <option value="Accepted">Accepted</option>
                                        <option value="On The Way">On The Way</option>
                                        <option value="Picked">Picked</option>
                                    </app-select>
                                    <app-error :errors="errors" field="note"></app-error>
                                </label>
                                
                                <app-button :disabled="is_updating">Update</app-button>
                                <app-button type="button" @click="is_editing = false" classes="ml-2">Cancel</app-button>
                            </div>
                        </div>
                    </form>
                </template>
                <app-loading v-else></app-loading>
            </div>
        </div>
    </main>
</template>
<script>
    import AppButton from '../../components/Form/Button.vue';
    import AppInput from '../../components/Form/Input.vue'
    import AppTextarea from '../../components/Form/Textarea.vue';
    import AppSelect from '../../components/Form/Select.vue';
    import AppError from '../../components/ValidationError.vue';
    import AppLoading from '../../components/Loading.vue'

    export default {
        components: {
            AppButton,
            AppTextarea,
            AppInput,
            AppSelect,
            AppError,
            AppLoading
        },

        data() {
            return {
                form: {
                    merchant_name: '',
                    contact: '',
                    Pickup_location: '',
                    total_parcel: '',
                    created_at: '',
                    updated_at: '',
                    status: '',
                    shop_id: '',
                    note: '',
                    shops:[],
                },
                errors: {},
                loading: false,
                is_editing: false,
                is_updating: false,
            }
        },

        beforeMount(){
            this.getPickupRequest();
        },

        methods: {
            async getPickupRequest() {
                try {
                    this.loading = true;
                    let { data } = await axios.get(`/api/pickup-requests/${this.$route.params.id}`);
                    this.form = data.data;
                    this.loading = false;
                } catch (error){
                    this.loading = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            },

            async update() {
                try {
                    this.is_updating = true;
                    let { data } = await axios.put(`/api/pickup-requests/${this.$route.params.id}`, this.form);
                    this.is_updating = false;
                    this.is_editing = false;
                    this.$notify({ text: data.message, type: data.success ? 'success' : 'error' });
                } catch (error){
                    this.errors = error.response.data.errors;
                    this.is_updating = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            }
    
        },
    }
</script>