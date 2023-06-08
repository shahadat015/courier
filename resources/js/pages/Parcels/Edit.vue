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
                            <div class="text-sm text-gray-700 dark:text-gray-300 leading-6">Entry: {{ form.entry_date }}</div>
                            <div class="text-sm text-gray-700 dark:text-gray-300 leading-6">Invoice: {{ form.invoice_no }}</div>
                            <div class="text-sm text-gray-700 dark:text-gray-300 leading-6">Delivery Charge: {{ form.charge }}</div>
                            <div class="text-sm text-gray-700 dark:text-gray-300 leading-6">Customer Name: {{ form.customer_name }}</div>
                            <div class="text-sm text-gray-700 dark:text-gray-300 leading-6">Customer Address: {{ form.customer_address }}</div>
                            <div class="text-sm text-gray-700 dark:text-gray-300 leading-6">Customer Phone: {{ form.customer_phone }}</div>
                            <div class="text-sm text-gray-700 dark:text-gray-300 leading-6">Note: {{ form.parcel_note }}</div>
                            <div class="text-sm text-gray-700 dark:text-gray-300 leading-6">Last Update: {{ form.updated_date }}</div>
                            <div class="text-2xl text-gray-700 dark:text-gray-300 mt-2">Rider</div>
                            <div class="italic text-sm text-gray-700 dark:text-gray-300 mb-3">{{ form.rider_name }} - {{ form.rider_phone }}</div>
                            <app-button @click="is_editing = true" v-if="can('admin')">Edit Parcel</app-button>
                        </div>
                        <div>
                            <h4 class="text-2xl text-gray-700 dark:text-cool-gray-300 mb-2">৳ {{ form.collection_amount }}</h4>
                            <span class="px-2 py-1 font-normal text-xs leading-tight text-purple-700 bg-blue-100 rounded-sm dark:bg-purple-700 dark:text-purple-100">{{ form.status }}</span>
                        </div>
                    </div>
                    <form @submit.prevent="update" class="space-y-4" v-show="is_editing">
                        <div class="sm:flex space-y-4 sm:space-y-0 sm:space-x-6">
                            <div class="sm:w-1/2 space-y-4">
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Customer Name</span>
                                    <app-input
                                        :value="form.customer_name"
                                        @inputEvent="form.customer_name = $event"
                                        placeholder="Enter Customer Name"
                                    />
                                    <app-error :errors="errors" field="customer_name"></app-error>
                                </label>
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Customer Phone</span>
                                    <app-input
                                        :value="form.customer_phone"
                                        @inputEvent="form.customer_phone = $event"
                                        placeholder="Enter Customer Phone Number"
                                        type="tel"
                                    />
                                    <app-error :errors="errors" field="customer_phone"></app-error>
                                </label>
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Customer Address</span>
                                    <app-textarea
                                        :value="form.customer_address"
                                        @inputEvent="form.customer_address = $event"
                                        placeholder="Enter Customer Address"
                                    />
                                    <app-error :errors="errors" field="customer_address"></app-error>
                                </label>
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Invoice/Cash Memo</span>
                                    <app-input
                                        :value="form.invoice_no"
                                        @inputEvent="form.invoice_no = $event"
                                        placeholder="Enter Invoice/Cash Memo No"
                                    />
                                    <app-error :errors="errors" field="invoice_no"></app-error>
                                </label>
                            </div>
                            <div class="sm:w-1/2 space-y-4">
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Collection Amount</span>
                                    <app-input
                                        :value="form.collection_amount"
                                        @inputEvent="form.collection_amount = $event"
                                        placeholder="Enter Collection Aamount"
                                        type="number"
                                    />
                                    <app-error :errors="errors" field="collection_amount"></app-error>
                                </label>
                                <label class="block text-sm" v-if="can('admin')">
                                    <span class="text-gray-700 dark:text-gray-400">Charge</span>
                                    <app-input
                                        :value="form.charge"
                                        @inputEvent="form.charge = $event"
                                        placeholder="Enter Charge"
                                        type="number"
                                    />
                                    <app-error :errors="errors" field="charge"></app-error>
                                </label>
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Parcel Note</span>
                                    <app-textarea
                                        :value="form.parcel_note"
                                        @inputEvent="form.parcel_note = $event"
                                        placeholder="Enter Parcel Note"
                                    />
                                    <small class="dark:text-gray-400 text-gray-700">If you have any specific instruction.</small>
                                    <app-error :errors="errors" field="parcel_note"></app-error>
                                </label>
                                <app-button :disabled="is_updating">Update</app-button>
                                <app-button type="button" @click="is_editing = false" classes="ml-2">Cancel</app-button>
                            </div>
                        </div>
                    </form>

                    <h2 class="pb-4 my-6 border-b border-gray-200 dark:border-gray-600 text-2xl text-center font-normal text-gray-700 dark:text-gray-200">
                        Trackings
                    </h2>

                    <div class="pl-4">
                        <template v-if="form.trackings.length">
                            <ul class="border-purple-200 border-l-4 pl-8">
                                <li v-for="track in form.trackings" :key="track.id" class="relative mb-6 before:content-[''] before:absolute before:-left-10 before:top-2 before:h-3 before:w-3 before:bg-purple-600 before:rounded-full before:border-2 before:border-purple-50 before:z-10 after:content-[''] after:absolute after:-left-8 after:top-3 after:h-1 after:w-6 after:bg-purple-200">
                                    <div class="flex items-start">
                                        <div class="text-center mr-4">
                                            <div class="h-10 w-10 rounded-full bg-purple-100 dark:bg-purple-600 flex items-center justify-center">
                                                <span class=" text-md text-purple-600 dark:text-white font-normal">{{ track.date }}</span>
                                            </div>
                                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-200">{{ track.month_year }}</p>
                                        </div>
                                        <div class="inline-block p-4">
                                            <h5 class="mt-0 text-gray-600 dark:text-gray-200">{{ track.status }}</h5>
                                            <p class="text-gray-600 dark:text-gray-200 text-sm">{{ track.description }}</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </template>
                        <h5 v-else class="mb-3 font-medium text-md text-gray-700 dark:text-gray-300 text-center">
                            No tracking information found
                        </h5>
                    </div>

                    <div v-if="can('admin')">
                        <h3 class="my-6 text-2xl text-center font-normal text-gray-700 dark:text-gray-200">Add Tracking</h3>
                        <form @submit.prevent="addTracking" class="space-y-4">
                            <div class="sm:flex space-y-4 sm:space-y-0 sm:space-x-6">
                                <label class="block text-sm w-full sm:w-1/2">
                                    <span class="text-gray-700 dark:text-gray-400">Status</span>
                                    <app-select
                                        :value="tracking.status"
                                        @changeEvent="tracking.status = $event"
                                        classes="block w-full border border-gray-200 mt-1"
                                    >
                                        <option value="Accepted">Accepted</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Return">Return</option>
                                        <option value="Half Return">Half Return</option>
                                        <option value="Delivered">Delivered</option>
                                        <option value="Paid">Paid</option>
                                    </app-select>
                                    <app-error :errors="errors" field="status"></app-error>
                                </label>
                                <label class="block text-sm w-full sm:w-1/2">
                                    <span class="text-gray-700 dark:text-gray-400">Description</span>
                                    <app-textarea
                                        :value="tracking.description"
                                        @inputEvent="tracking.description = $event"
                                        placeholder="Description"
                                        :rows="1"
                                    />
                                    <app-error :errors="errors" field="description"></app-error>
                                </label>
                            </div>
                            <app-button :disabled="add_tracking">Submit</app-button>
                        </form>
                    </div>
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
                    customer_name: '',
                    customer_phone: '',
                    customer_address: '',
                    invoice_no: '',
                    collection_amount: '',
                    charge: '',
                    parcel_note: '',
                    merchant_id: '',
                },
                tracking: {
                    status: 'Accepted',
                    description: '',
                    date: new Date().getDate(),
                    month_year: `${['Jan', 'Feb', 'Mar', 'App', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'][new Date().getMonth()]}-${new Date().getFullYear()}`,
                },
                errors: {},
                loading: false,
                is_editing: false,
                add_tracking: false,
                is_updating: false,
            }
        },

        beforeMount(){
            this.getParcel();
        },

        methods: {
            async getParcel() {
                try {
                    this.loading = true;
                    let { data } = await axios.get(`/api/parcels/${this.$route.params.id}`);
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
                    let { data } = await axios.put(`/api/parcels/${this.$route.params.id}`, this.form);
                    this.is_updating = false;
                    this.is_editing = false;
                    this.$notify({ text: data.message, type: data.success ? 'success' : 'error' });
                } catch (error){
                    this.errors = error.response.data.errors;
                    this.is_updating = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            },

            async addTracking() {
                try {
                    this.add_tracking = true;
                    let { data } = await axios.post(`/api/trackings/${this.$route.params.id}`, this.tracking);
                    this.form.trackings.push({...this.tracking});
                    this.form.status = this.tracking.status == 'Accepted' ? 'Processing' : this.tracking.status;
                    this.tracking.description = '';
                    this.add_tracking = false;
                    this.$notify({ text: data.message, type: data.success ? 'success' : 'error' });
                } catch (error){
                    this.errors = error.response.data.errors;
                    this.add_tracking = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            }
    
        },
    }
</script>