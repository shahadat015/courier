<template>
    <main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <div v-if="! loading" class="p-8 my-6 bg-white rounded-lg shadow-sm dark:bg-gray-800 overflow-x-auto">
                <span class="text-white bg-purple-600 mb-2 inline-block px-4 py-2 rounded-sm hover:bg-purple-500 cursor-pointer" @click="print">Print</span>
                <div id="printable">
                    <div class="grid gap-x-28 grid-cols-3 pb-4">
                        <div class="space-y-0.5 text-gray-600 dark:text-gray-300">
                            <img class="w-32 h-10 object-cover" :src="settings.logo" alt="">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="ml-2"> {{ settings.address }} </span>
                            </div>
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span class="mx-2">{{ settings.phone }}</span>
                            </div>
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                                <span class="ml-2">{{ settings.website }}</span>
                            </div>
                        </div>
                        <div class="text-center space-y-2 text-sm  text-gray-600 dark:text-gray-300">
                            <div class="text-3xl font-normal"> INVOICE </div>
                            <div>ID#INV-{{ payment.id }}</div>
                            <div>Date: {{ payment.date }}</div>
                        </div>
                        <div class="text-gray-600 space-y-0.5 text-sm dark:text-gray-300">
                            <div class="text-md mb-2">Bill To</div>
                            <div class="font-semibold">{{ merchant.business_name }}</div>
                            <div>Name: {{ merchant.name }}</div>
                            <div>Address: {{ merchant.pickup_location }}</div>
                            <div>Phone: {{ merchant.phone }}</div>
                        </div>
                    </div>
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
                                            {{ payment.collection_amount }}
                                        </td>
                                    </tr>
                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            Total Delivery Charge
                                        </td>
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            {{ payment.total_delivery_charge }}
                                        </td>
                                    </tr>
                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            Subtotal
                                        </td>
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            {{ payment.subtotal  }}
                                        </td>
                                    </tr>
                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            Cash & Risk Handling Charge(1%)
                                        </td>
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            {{ payment.surcharge  }}
                                        </td>
                                    </tr>
                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            Total Payable
                                        </td>
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            {{ payment.total_payable  }}
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
                                            
                                        </td>
                                    </tr>
                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            Branch
                                        </td>
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            
                                        </td>
                                    </tr>
                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            Account Number
                                        </td>
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            
                                        </td>
                                    </tr>
                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            Account Name
                                        </td>
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            
                                        </td>
                                    </tr>
                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            Routing Number
                                        </td>
                                        <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <h3 class="text-2xl text-center text-gray-700 dark:text-gray-300 mt-6 mb-2">Cleared Consignment ({{ payment.total_parcel }})</h3>
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3 text-center border dark:border-gray-700 dark:bg-gray-800">Id</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Date</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Invoice</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Customer</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Collection</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Charge</th>
                                <th class="px-4 py-3 border dark:border-gray-700 dark:bg-gray-800">Note</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white border dark:border-gray-700 dark:bg-gray-800">
                            <tr v-for="parcel in parcels" :key="parcel.id" class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm text-center border dark:border-gray-700 dark:bg-gray-800">
                                    {{ parcel.id }}
                                </td>
                                <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                    {{ parcel.entry_date }}
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
                                <td class="px-4 py-3 text-sm border dark:border-gray-700 dark:bg-gray-800">
                                    {{ parcel.delivery_note }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <app-loading v-else></app-loading>
        </div>
    </main>
</template>
<script>
    import AppLoading from '../../components/Loading.vue';
    import { mapGetters } from 'vuex'

    export default {
        components: {
            AppLoading
        },

        data(){
            return {
                merchant: {},
                parcels: {},
                payment: {},
                parcels: [],
                loading: false,
            }
        },
        
        beforeMount(){
            this.getPayment();
        },

        computed: {
            ...mapGetters({
                settings: 'settings/settings'
            })
        },
        
        methods: {
            async getPayment() {
                try {
                    this.loading = true;
                    let { data } = await axios.get(`/api/payments/${this.$route.params.id}`);
                    this.parcels = data.data.parcels;
                    this.merchant = data.data.merchant;
                    this.payment = data.data.payment;
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