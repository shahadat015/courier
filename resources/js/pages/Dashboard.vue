<template>
	<main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid" v-if="! loading">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Dashboard
            </h2>
            <!-- Cards -->
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                <!-- Card -->
                <template v-if="can('merchant')">
                    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                        <div class="p-3 mr-4 rounded-full text-orange-500 bg-orange-100 dark:text-orange-100 dark:bg-orange-500">
                            <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                Pickup Request
                            </p>
                            <p @click="showPickupModal  = true" class="text-sm font-normal cursor-pointer text-gray-700 dark:text-gray-200">
                                Send Request
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                        <div class="p-3 mr-4 rounded-full text-purple-500 bg-purple-100 dark:text-purple-100 dark:bg-purple-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-normal text-gray-600 dark:text-gray-400">
                                Payment Request
                            </p>
                            <p @click="showPaymentModal  = true" class="text-sm font-normal cursor-pointer text-gray-700 dark:text-gray-200">
                                Send Request
                            </p>
                        </div>
                    </div>
                </template>
                <template v-for="card in cards" :key="card.title">
                    <app-card :card="card" v-if="can(card.role)"></app-card>
                </template>
            </div>

            <!-- New Table -->
            <div v-if="can('admin')" class="w-full overflow-hidden rounded-lg shadow-xs">
                <h2 class="mb-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">Pickup Requests</h2>
                <app-table endpoint="pickup-requests" actionUrl="pickup"></app-table>

                <h2 class="mb-2 mt-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Withdrow Requests</h2>
                <app-table endpoint="withdrow-requests" actionUrl="withdrow"></app-table>
            </div>
            <form @submit.prevent="sendPaymentRequest">
                <app-modal :show="showPaymentModal" @close="showPaymentModal = false">
                    <!-- Modal title -->
                    <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                        Payment Request
                    </p>
                    <!-- Modal description -->
                    <div class="mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Withdraw Method</span>
                        <div class="mt-2">
                            <app-select
                                classes="w-full block border border-gray-300"
                                :value="bank_account_id"
                                @changeEvent="bank_account_id = $event"
                            >
                                <option value="">Select</option>
                                <template v-for="account in bank_accounts" :key="account.id">
                                    <option v-if="account.bank_type == 'bank_account'" :value="account.id">{{ account.bank_name }} - {{ account.account_number }}</option>
                                    <option v-else :value="account.id">{{ account.provider }} - {{ account.phone_number }}</option>
                                </template>
                            </app-select>
                            <app-error :errors="errors" field="bank_account_id"></app-error>
                        </div>
                    </div>
                    <template v-slot:SubmitButton>
                        <app-button :disabled="loading">
                            Submit
                        </app-button>
                    </template>
                </app-modal>
            </form>
            <form @submit.prevent="sendPickupRequest">
                <app-modal :show="showPickupModal" @close="showPickupModal = false">
                    <!-- Modal title -->
                    <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                        Pickup Request
                    </p>
                    <!-- Modal description -->
                    <div class="mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Select Location</span>
                        <div class="mt-2">
                            <label v-for="shop in shops" :key="shop.id" class="inline-flex items-center text-gray-600 dark:text-gray-400">
                                <input type="radio" class="text-purple-600 form-radio border border-gray-300 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" v-model="form.shop_id" :value="shop.id">
                                <span class="mx-2">{{ shop.pickup_location }}</span>
                            </label><br>
                            <app-error :errors="errors" field="shop_id"></app-error>
                        </div>
                        
                        <span class="text-gray-700 dark:text-gray-400 block mt-4">How many parcels?</span>
                        <label class="block text-sm w-full">
                            <app-input 
                                :value="form.total_parcel"
                                @inputEvent="form.total_parcel = $event"
                                placeholder="Estimated Parcels"
                                type="number"
                            />
                            <app-error :errors="errors" field="total_parcel"></app-error>
                        </label>
                        <label class="block text-sm w-full mt-2">
                            <app-input 
                                :value="form.note"
                                @inputEvent="form.note = $event"
                                placeholder="Special Instruction"
                            />
                            <app-error :errors="errors" field="note"></app-error>
                        </label>
                    </div>
                    <template v-slot:SubmitButton>
                        <app-button :disabled="loading">
                            Submit
                        </app-button>
                    </template>
                </app-modal>
            </form>
        </div>
        <div class="container px-6 mx-auto my-6" v-else>
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-md px-5 py-6 my-4">
                <app-loading></app-loading>
            </div>
        </div>
    </main>
</template>
<script>
    import AppCard from '../components/Card.vue';
    import AppTable from '../components/Table.vue';
    import AppModal from '../components/Modal.vue';
    import AppInput from '../components/Form/Input.vue';
    import AppSelect from '../components/Form/Select.vue';
    import AppButton from '../components/Form/Button.vue'
    import AppError from '../components/ValidationError.vue';
    import AppLoading from '../components/Loading.vue';
    import { mapGetters } from 'vuex'

    export default {
        components: {
            AppCard,
            AppTable,
            AppModal,
            AppInput,
            AppError,
            AppButton,
            AppSelect,
            AppLoading
        },
        
        data(){
            return {
                showPaymentModal: false,
                showPickupModal: false,
                cards: [],
                shops: [],
                bank_accounts: [],
                form: {
                    shop_id: '',
                    total_parcel: '',
                    note: ''
                },
                bank_account_id: '',
                errors: {},
                loading: false,
            }
        },

        computed: {
            ...mapGetters({
                user: 'auth/user'
            }),
        },

        beforeMount(){
            if(this.can('merchant')){
                this.getShops();
            }
            if(this.can('admin')){
                this.getAnalytics();
            }
        },

        methods: {
            async getShops(){
                try {
                    this.loading = true;
                    let { data } = await axios.get(`/api/merchants/${this.user.id}`);
                    this.shops = data.data.shops;
                    this.bank_accounts = data.data.bank_accounts;
                    this.cards.push(...data.data.cards);
                    this.loading = false;
                } catch (error){
                    this.loading = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            },

            async getAnalytics(){
                try {
                    this.loading = true;
                    let data = await axios.get('/api/analytics');
                    this.cards.push(...data.data);
                    this.loading = false;
                } catch (error){
                    this.loading = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            },

            async sendPickupRequest(){
                try {
                    this.loading = true;
                    let { data } = await axios.post(`/api/pickup-requests`, this.form);
                    this.showPickupModal = false;
                    this.form.shop_id = '';
                    this.form.total_parcel = '';
                    this.form.note = '';
                    this.loading = false;
                    this.$notify({ text: data.message, type: data.success ? 'success' : 'error' });
                } catch (error){
                    this.errors = error.response.data.errors;
                    this.loading = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            },

            async sendPaymentRequest(){
                try {
                    this.loading = true;
                    let { data } = await axios.post(`/api/withdrow-requests`, { bank_account_id: this.bank_account_id });
                    this.showPaymentModal = false;
                    this.bank_account_id = '';
                    this.loading = false;
                    this.$notify({ text: data.message, type: data.success ? 'success' : 'error' });
                } catch (error){
                    this.errors = error.response.data.errors;
                    this.loading = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            }
        }
    }
</script>