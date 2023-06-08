<template>
	<main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <!-- New Table -->
            <div v-if="!loading">
                <div v-show="delivered.length" class="p-6 my-6 bg-white rounded-lg shadow-sm dark:bg-gray-800 overflow-x-auto">
                    <h3 class="pb-4 text-2xl font-semibold text-gray-600 dark:text-gray-300">Add Parcels</h3>
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3 text-center border dark:border-gray-700 dark:bg-gray-800">Id</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Name</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Contact</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Status</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white border dark:border-gray-700 dark:bg-gray-800">
                            <tr v-for="(parcel, index) in delivered" :key="parcel.id" class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm text-center border dark:border-gray-700 dark:bg-gray-800">
                                    {{ parcel.id }}
                                </td>
                                <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                    {{ parcel.customer_name}}
                                </td>
                                <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                    {{ parcel.customer_phone }} <br>
                                </td>
                                <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                    {{ parcel.status }}
                                </td>
                                <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800 space-x-1">
                                    <span @click="addParcel(parcel, index)" class="text-sm rounded-sm p-2 bg-green-400 text-white cursor-pointer">Add</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-show="! delivered.length && ! parcels.length" class="p-6 my-6 bg-white text-gray-700 dark:text-gray-300 text-center font-medium text-1xl rounded-lg shadow-sm dark:bg-gray-800 overflow-x-auto">No delivered or returned or half returned parcel found</div>
            </div>
            <app-loading v-else></app-loading>

            <div v-show="parcels.length" class="p-6 my-6 bg-white rounded-lg shadow-sm dark:bg-gray-800 overflow-x-auto">
                <h3 class="pb-4 text-2xl font-semibold text-gray-600 dark:text-gray-300">Added Parcels</h3>

                <div class="grid grid-cols-0 sm:grid-cols-2 gap-6">
                    <div>
                        <div class="font-semibold text-md text-center text-gray-600 dark:text-gray-300 border dark:border-gray-700 py-2">Payment Details</div>
                        <table class="w-full whitespace-no-wrap">
                            <tbody class="bg-white border dark:border-gray-700 dark:bg-gray-800">
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        Total Cash Collected
                                    </td>
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        {{ total_cash_collected }}
                                    </td>
                                </tr>
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        Total Delivery Charge
                                    </td>
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        {{ total_delivery_charge }}
                                    </td>
                                </tr>
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        Subtotal
                                    </td>
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        {{ subtotal  }}
                                    </td>
                                </tr>
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        Cash & Risk Handling Charge(1%)
                                    </td>
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        {{ surcharge  }}
                                    </td>
                                </tr>
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        Total Payable
                                    </td>
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        {{ payable_amount  }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div>   
                        <div class="font-semibold text-md text-center text-gray-600 dark:text-gray-300 border dark:border-gray-700 py-2">Bank Details</div>
                        <table class="w-full whitespace-no-wrap">
                            <tbody class="bg-white border dark:border-gray-700 dark:bg-gray-800">
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        Bank Name
                                    </td>
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        ABC Bank
                                    </td>
                                </tr>
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        Branch
                                    </td>
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        Mirpur
                                    </td>
                                </tr>
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        Acoount Number
                                    </td>
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        02022054
                                    </td>
                                </tr>
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        Acoount Holder Name
                                    </td>
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        Shahadat
                                    </td>
                                </tr>
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        Routing Number
                                    </td>
                                    <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                        852654
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <table class="w-full whitespace-no-wrap mt-6">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3 text-center border dark:border-gray-700 dark:bg-gray-800">Id</th>
                            <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Invoice</th>
                            <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Customer</th>
                            <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">COD</th>
                            <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Charge</th>
                            <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white border dark:border-gray-700 dark:bg-gray-800">
                        <tr v-for="(parcel, index) in parcels" :key="parcel.id" class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm text-center border dark:border-gray-700 dark:bg-gray-800">
                                {{ parcel.id }}
                            </td>
                            <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                {{ parcel.invoice_no }}
                            </td>
                            <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                {{ parcel.customer_name }} <br>
                                {{ parcel.customer_phone }}
                            </td>
                            <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                {{ parcel.collection_amount }}
                            </td>
                            <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                {{ parcel.charge }}
                            </td>
                            <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800 space-x-1">
                                <svg @click="removeParcel(parcel, index)" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <app-button :disabled="is_creating" classes="mt-4" @click="createPyment">Create Payment</app-button>
            </div>
        </div>
    </main>
</template>
<script>
    import AppTable from '../../components/Table.vue';
    import AppButton from '../../components/Form/Button.vue';
    import AppLoading from '../../components/Loading.vue';

    export default {
        components: {
            AppTable,
            AppButton,
            AppLoading
        },

        data(){
            return {
                delivered: [],
                parcels: [],
                loading: false,
                is_creating: false,
                total_cash_collected: 0,
                total_delivery_charge: 0,
                subtotal: 0,
                surcharge: 0,
                payable_amount: 0,
            }
        },

        beforeMount(){
            this.getMerchantDeliveredParcels();
        },

        methods: {
            sumTotalCashCollected(){
                let total = this.parcels.reduce((initial, item) => {
                    return item.collection_amount + initial;
                }, 0);

                this.total_cash_collected = total;
            },
            sumDeliveryCharge(){
                let total = this.parcels.reduce((initial, item) => {
                    return item.charge + initial;
                }, 0);

                this.total_delivery_charge = total;
            },
            subTotal(){
                return this.subtotal = (this.total_cash_collected - this.total_delivery_charge);
            },
            surCharge(){
                return this.surcharge = ((this.subtotal * 1) / 100);
            },
            payable(){
                return this.payable_amount = (this.subtotal - this.surcharge);
            },
            addParcel(parcel, index){
                this.delivered.splice(index, 1);
                this.parcels.unshift(parcel);
                this.sumTotalCashCollected();
                this.sumDeliveryCharge();
                this.subTotal();
                this.surCharge();
                this.payable();
            },
            removeParcel(parcel, index){
                this.delivered.unshift(parcel);
                this.parcels.splice(index, 1);
                this.sumTotalCashCollected();
                this.sumDeliveryCharge();
                this.subTotal();
                this.surCharge();
                this.payable();
            },
            async getMerchantDeliveredParcels() {
                try {
                    this.loading = true;
                    let { data } = await axios.get(`/api/get-parcels/${this.$route.params.id}`);
                    this.delivered = data.data;
                    this.loading = false;
                } catch (error){
                    this.loading = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            },
            async createPyment(){
                let parcels = this.parcels.map(parcel => parcel.id);

                try {
                    this.is_creating = true;
                    let { data } = await axios.post(`/api/payments/store`, {
                        merchant_id: this.$route.params.id,
                        collection_amount: this.total_cash_collected,
                        total_delivery_charge: this.total_delivery_charge,
                        subtotal: this.subtotal,
                        surcharge: this.surcharge,
                        total_payable: this.payable_amount,
                        total_parcel: this.parcels.length,
                        parcels: parcels,
                    });

                    this.$notify({ text: data.message, type: data.success ? 'success' : 'error' });
                    this.$router.push({ name: 'merchants.show', param: { id: this.$route.params.id }});
                } catch (error){
                    this.errors = error.response.data.errors;
                    this.loading = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            }
        }
    }
</script>