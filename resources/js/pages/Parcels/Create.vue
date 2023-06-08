<template>
	<main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Create Parcel
            </h2>
            <app-notification v-if="success" :message="message"></app-notification>
            <div class="p-6 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <form @submit.prevent="createParcel" class="space-y-4">
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
                                    type="tel"
                                    :value="form.customer_phone"
                                    @inputEvent="form.customer_phone = $event"
                                    placeholder="Enter Customer Phone Number"
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
                                    type="number"
                                    :value="form.collection_amount"
                                    @inputEvent="form.collection_amount = $event"
                                    placeholder="Enter Collection Aamount"
                                />
                                <app-error :errors="errors" field="collection_amount"></app-error>
                            </label>
                            <label class="block text-sm" v-if="can('admin')">
                                <span class="text-gray-700 dark:text-gray-400">Charge</span>
                                <app-input
                                    type="number"
                                    :value="form.charge"
                                    @inputEvent="form.charge = $event"
                                    placeholder="Enter Charge"
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
                            <app-button classes="w-full" :disabled="loading">Submit</app-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</template>
<script>
    import AppButton from '../../components/Form/Button.vue';
    import AppNotification from '../../components/Notification.vue';
    import AppInput from '../../components/Form/Input.vue'
    import AppTextarea from '../../components/Form/Textarea.vue';
    import AppError from '../../components/ValidationError.vue';
    import { mapActions, mapGetters } from 'vuex'

    export default {
        components: {
            AppButton,
            AppTextarea,
            AppInput,
            AppError,
            AppNotification
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
                errors: {},
                message: '',
                success: false,
                url: '',
                loading: false
            }
        },

        computed: {
            ...mapGetters({
                user: 'auth/user'
            }),
        },

        created() {
            this.setMerchant();
        },

        updated(){
            this.setMerchant();
        },

        methods: {
            ...mapActions({
                store: 'store'
            }),

            async createParcel() {
                try {
                    this.loading = true;
                    let { data } = await axios.post('/api/parcels', this.form);
                    this.loading = false;
                    Object.assign(this.$data, this.$options.data());
                    this.message = data.message;
                    this.success = true;
                } catch (error){
                    this.errors = error.response.data.errors;
                    this.loading = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            },

            setMerchant(){
                if(this.$route.params.id){
                    return this.form.merchant_id = this.$route.params.id;
                }

                return this.form.merchant_id = this.user.id;
            }
        },
    }
</script>