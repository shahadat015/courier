<template>
	<main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <!-- New Table -->
            <div class="p-6 my-6 bg-white rounded-lg shadow-sm dark:bg-gray-800 overflow-x-auto">
                <div v-if="! loading" >
                    <div class="space-y-4 pb-4 text-sm font-normal text-gray-600 dark:text-gray-300">
                        <div>
                            Delivery Person: <span class="font-semibold">{{ rider.name }} ({{ rider.phone }})</span>
                        </div>
                        <div>Date: <span class="font-semibold">{{ assigned_date }}</span></div>
                        <div>Total Parcel: <span class="font-semibold">{{ total_parcel }}</span></div>
                    </div>
                    <table v-show="parcels.length" class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3 text-center border dark:border-gray-700 dark:bg-gray-800">Id</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Merchant Details</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Invoice</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Customer Details</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">COD</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Note</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white border dark:border-gray-700 dark:bg-gray-800">
                            <tr v-for="(parcel, index) in parcels" :key="parcel.id" class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm text-center border dark:border-gray-700 dark:bg-gray-800">
                                    {{ parcel.id }} <br>
                                    {{ parcel.entry_date }}
                                </td>
                                <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                    <span class="font-semibold text-sm text-gray-600 dark:text-gray-400">{{ parcel.merchant_name }}</span> <br>
                                    {{ parcel.merchant_phone}}
                                </td>
                                <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                    {{ parcel.invoice_no }}
                                </td>
                                <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                    <span class="font-semibold text-sm text-gray-600 dark:text-gray-400">{{ parcel.customer_name }}</span> <br>
                                    {{ parcel.customer_phone }} <br>
                                    {{ parcel.customer_address }}
                                </td>
                                <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                    {{ parcel.collection_amount }}
                                </td>
                                <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                    {{ parcel.parcel_note }}
                                </td>
                                <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800 space-x-1">
                                    <span @click="deliveryParcel(parcel, index)" class="text-sm rounded-sm p-2 bg-green-400 text-white cursor-pointer" title="Delivery">DEL</span>
                                    <span @click="returnParcel(parcel, index)" class="text-sm rounded-sm p-2 bg-red-500 text-white cursor-pointer" title="Return">RTN</span>
                                    <span @click="halfReturnParcel(parcel, index)" class="text-sm rounded-sm p-2 bg-yellow-300 text-white cursor-pointer" title="Half Return">HR</span>
                                    <span @click="pendingParcel(parcel, index)" class="text-sm rounded-sm p-2 bg-purple-500 text-white cursor-pointer" title="Pending">PEN</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h2 v-if="delivered.length" class="my-6 text-md text-center font-semibold text-gray-600 dark:text-gray-300">Total Delivered: {{ total_delivered }}Tk</h2>
                    <div class="grid grid-cols-0 sm:grid-cols-2 gap-6">
                        <div v-show="delivered.length">
                            <div class="font-semibold text-md text-center text-gray-600 dark:text-gray-400 border dark:border-gray-700 py-2">Delivered</div>
                            <table class="w-full whitespace-no-wrap">
                                <thead>
                                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-4 py-3 text-center border dark:border-gray-700 dark:bg-gray-800">Id</th>
                                        <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">COD</th>
                                        <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white border dark:border-gray-700 dark:bg-gray-800">
                                    <tr v-for="(parcel, index) in delivered" :key="parcel.id" class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm text-center border dark:border-gray-700 dark:bg-gray-800">
                                            {{ parcel.id }}
                                        </td>
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            {{ parcel.collection_amount }}
                                        </td>
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800 space-x-1">
                                            <svg @click="removeDelivered(parcel, index)" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-show="returned.length">
                            <div class="font-semibold text-md text-center text-gray-600 dark:text-gray-300 border dark:border-gray-700 py-2">Return</div>
                            <table class="w-full whitespace-no-wrap">
                                <thead>
                                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-4 py-3 text-center border dark:border-gray-700 dark:bg-gray-800">Id</th>
                                        <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">COD</th>
                                        <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white border dark:border-gray-700 dark:bg-gray-800">
                                    <tr v-for="(parcel, index) in returned" :key="parcel.id" class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm text-center border dark:border-gray-700 dark:bg-gray-800">
                                            {{ parcel.id }}
                                        </td>
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            {{ parcel.collection_amount }}
                                        </td>
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800 space-x-1">
                                            <svg @click="removeReturned(parcel, index)" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>                                    
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-show="half_returned.length">
                            <div class="font-semibold text-md text-center text-gray-600 dark:text-gray-300 border dark:border-gray-700 py-2">Half Return</div>
                            <table class="w-full whitespace-no-wrap">
                                <thead>
                                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-4 py-3 text-center border dark:border-gray-700 dark:bg-gray-800">Id</th>
                                        <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">COD</th>
                                        <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white border dark:border-gray-700 dark:bg-gray-800">
                                    <tr v-for="(parcel, index) in half_returned" :key="parcel.id" class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm text-center border dark:border-gray-700 dark:bg-gray-800">
                                            {{ parcel.id }}
                                        </td>
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            {{ parcel.collection_amount }}
                                        </td>
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800 space-x-1">
                                            <svg @click="removeHalfReturned(parcel, index)" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-show="pending.length">
                            <div class="font-semibold text-md text-center text-gray-600 dark:text-gray-300 border dark:border-gray-700 py-2">Pending</div>
                            <table class="w-full whitespace-no-wrap">
                                <thead>
                                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-4 py-3 text-center border dark:border-gray-700 dark:bg-gray-800">Id</th>
                                        <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">COD</th>
                                        <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white border dark:border-gray-700 dark:bg-gray-800">
                                    <tr v-for="(parcel, index) in pending" :key="parcel.id" class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm text-center border dark:border-gray-700 dark:bg-gray-800">
                                            {{ parcel.id }}
                                        </td>
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            {{ parcel.collection_amount }}
                                        </td>
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800 space-x-1">
                                            <svg @click="removePending(parcel, index)" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <app-button v-if="! parcels.length && (delivered.length || pending.length || returned.length || half_returned.length)" :disabled="is_updating" classes="mt-4" @click="submit">Submit</app-button>
                </div>
                <app-loading v-else></app-loading>
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
                rider: {},
                parcels: [],
                delivered: [],
                returned: [],
                half_returned: [],
                pending: [],
                loading: false,
                total_delivered: 0,
                total_returned: 0,
                total_half_returned: 0,
                total_pending: 0,
                assigned_date: '',
                total_parcel: 0,
                is_updating: false,
            }
        },

        beforeMount(){
            this.getRiderParcels();
        },

        methods: {
            sumTotalDelivery(){
                let total = this.delivered.reduce((initial, item) => {
                    return item.collection_amount + initial; 
                }, 0);

                this.total_delivered = total;
            },
            sumTotalReturned(){
                let total = this.returned.reduce((initial, item) => {
                    return item.collection_amount + initial; 
                }, 0);

                this.total_returned = total;
            },
            sumTotalHalfReturned(){
                let total = this.half_returned.reduce((initial, item) => {
                    return item.collection_amount + initial; 
                }, 0);

                this.total_half_returned = total;
            },
            sumTotalPending(){
                let total = this.pending.reduce((initial, item) => {
                    return item.collection_amount + initial; 
                }, 0);

                this.total_pending = total;
            },
            deliveryParcel(parcel, index){
                this.parcels.splice(index, 1);
                this.delivered.unshift(parcel);
                this.sumTotalDelivery();
            },
            returnParcel(parcel, index){
                this.parcels.splice(index, 1);
                this.returned.unshift(parcel);
                this.sumTotalReturned();
            },
            halfReturnParcel(parcel, index){
                this.parcels.splice(index, 1);
                this.half_returned.unshift(parcel);
                this.sumTotalHalfReturned();
            },
            pendingParcel(parcel, index){
                this.parcels.splice(index, 1);
                this.pending.unshift(parcel);
                this.sumTotalPending();
            },
            removeDelivered(parcel, index){
                this.parcels.unshift(parcel);
                this.delivered.splice(index, 1);
                this.sumTotalDelivery();
            },
            removeReturned(parcel, index){
                this.parcels.unshift(parcel);
                this.returned.splice(index, 1);
                this.sumTotalReturned();
            },
            removeHalfReturned(parcel, index){
                this.parcels.unshift(parcel);
                this.half_returned.splice(index, 1);
                this.sumTotalHalfReturned();
            },
            removePending(parcel, index){
                this.parcels.unshift(parcel);
                this.pending.splice(index, 1);
                this.sumTotalPending();
            },
            async getRiderParcels() {
                try {
                    this.loading = true;
                    let { data } = await axios.get(`/api/rider/parcels/${this.$route.params.id}?page=edit`);
                    this.rider = data.data.rider;
                    this.parcels = data.data.parcels;
                    this.assigned_date = data.data.assigned_date;
                    this.total_parcel = data.data.total_parcel;
                    this.loading = false;
                } catch (error){
                    this.loading = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            },
            async submit(){
                try {
                    this.is_updating = true;
                    let { data } = await axios.post(`/api/rider/parcels/${this.$route.params.id}`, {
                        delivered: this.delivered, 
                        pending: this.pending, 
                        returned: this.returned, 
                        half_returned: this.half_returned,
                        total_delivered: this.delivered.length,
                        total_returned: this.returned.length,
                        total_half_returned: this.half_returned.length,
                        total_pending: this.pending.length,
                        delivered_amount: this.total_delivered,
                        returned_amount: this.total_returned,
                        half_returned_amount: this.total_half_returned,
                        pending_amount: this.total_pending,
                        status: 'Completed',
                    });
                    this.$notify({ text: data.message, type: data.success ? 'success' : 'error' });
                    this.$router.push({ name: 'rider.parcels.show', param: { id: this.$route.params.id } });
                } catch (error){
                    this.errors = error.response.data.errors;
                    this.loading = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            }
        }
    }
</script>