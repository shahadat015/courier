<template>
	<main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <!-- New Table -->
            <div class="p-6 my-6 bg-white rounded-lg shadow-sm dark:bg-gray-800 overflow-x-auto">
                <span class="text-white bg-purple-600 px-4 py-2 rounded-sm hover:bg-purple-500 cursor-pointer" @click="print">Print</span>
                <div v-if="! loading" id="printable">
                    <div class="space-y-4 pb-8 text-center text-gray-600 dark:text-gray-300">
                        <div class="flex justify-center">
                            <img class="w-32 h-10 object-cover" :src="settings.logo" alt="">
                        </div>
                        <div class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="ml-2"> {{ settings.address }} </span>
                        </div>
                        <div class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="mx-2">{{ settings.phone }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                            <span class="ml-2">{{ settings.website }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between text-sm font-normal text-gray-600 dark:text-gray-300">
                        <div class="space-y-6 mb-6 sm:mb-0">
                            <div>Delivery Person: <span class="font-semibold">{{ rider.name }} ({{ rider.phone }})</span></div>
                            <div>Date: <span class="font-semibold">{{ assigned_date }}</span></div>
                            <div>Total Parcel: <span class="font-semibold">{{ total_parcel }}</span></div>
                        </div>
                        <div class="space-y-6">
                            <div>Total Amount-Cash: ...................................</div>
                            <div>bKash: ........................ Other: .....................</div>
                            <div>NC: ................. EC: ................. Pick: ............</div>
                        </div>
                    </div>
                    <table class="w-full whitespace-no-wrap my-8">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3 text-center border dark:border-gray-700 dark:bg-gray-800">Id</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Merchant Details</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Invoice</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Customer Details</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">COD</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Note</th>
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
                            </tr>
                        </tbody>
                    </table>
                    <div class="flex justify-between pb-6 text-sm font-normal text-gray-600 dark:text-gray-300">
                        <div class="space-y-6 mb-6 sm:mb-0">
                            <div>Amount Delivered: ..........................................</div>
                            <div>Amount Due: .................................................</div>
                            <div>Amount Received: ........................................</div>
                        </div>
                        <div class="space-y-6">
                            <div>Signature</div>
                            <div>Consignment Receiver's: ...............................</div>
                            <div>Amount Depositor's: ......................................</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
</template>
<script>
    import AppTable from '../../components/Table.vue';
    import AppButton from '../../components/Form/Button.vue';
    import { mapGetters } from 'vuex'

    export default {
        components: {
            AppTable,
            AppButton
        },

        data(){
            return {
                parcels: [],
                loading: false,
            }
        },

        beforeMount(){
            this.getRiderParcels();
        },

        computed: {
            ...mapGetters({
                settings: 'settings/settings'
            })
        },

        methods: {
            async getRiderParcels() {
                try {
                    this.loading = true;
                    let { data } = await axios.get(`/api/rider/parcels/${this.$route.params.id}`);
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

            print(){
                window.print();
            }
        }
    }
</script>
<style>
@media print {
  body * {
    visibility: hidden;
  }
  #printable, #printable * {
    visibility: visible;
  }
  #printable {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>