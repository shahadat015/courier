<template>
	<main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Assign Parcel
            </h2>

            <!-- New Table -->
            <app-table endpoint="get-parcels" actionUrl="parcels" @removed="addParcel"></app-table>

            <div v-show="parcels.length" class="p-6 my-6 bg-white rounded-lg shadow-sm dark:bg-gray-800 overflow-x-auto">
                <h2 class="pb-4 border-b border-gray-200 dark:border-gray-700 text-2xl text-center font-normal text-gray-700 dark:text-gray-200">
                    Added Parcel
                </h2>
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Id</th>
                            <th class="px-4 py-3">Invoice</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Collection</th>
                            <th class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="(parcel, index) in parcels" :key="parcel.id" class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                {{ parcel.id }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ parcel.invoice_no }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ parcel.name }} <br>
                                {{ parcel.phone }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ parcel.collection }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span @click="removeParcel(parcel, index)" class="font-normal text-sm leading-tight  px-3 rounded-sm py-2 bg-red-500 text-white cursor-pointer">Remove</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <app-button :disabled="loading" classes="mt-4" @click="assignParcels">Assign Parcels</app-button>
            </div>
        </div>
    </main>
</template>
<script>
    import AppTable from '../../components/Table.vue';
    import AppButton from '../../components/Form/Button.vue';

    export default {
        components: {
            AppTable,
            AppButton
        },

        data(){
            return {
                parcels: [],
                loading: false,
                collection_amount: 0,
            }
        },

        methods: {
            sumCollectionAmount(){
                let total = this.parcels.reduce((initial, parcel) => {
                    return initial + parcel.collection;
                }, 0);

                this.collection_amount = total;
            },

            addParcel(parcel){
                this.parcels.unshift(parcel);
                this.sumCollectionAmount();
            },
            removeParcel(parcel, index){
                this.parcels.splice(index, 1);
                this.sumCollectionAmount();
                emitter.emit('removed', parcel);
            },
            async assignParcels(){

                try {
                    this.loading = true;
                    let { data } = await axios.post(`/api/parcels/${this.$route.params.id}/assign`, {
                        parcels: this.parcels, 
                        collection_amount: this.collection_amount, 
                        total_parcel: this.parcels.length,
                    });
                    this.loading = false;
                    this.$notify({ text: data.message, type: data.success ? 'success' : 'error' });
                    this.$router.push({ name: 'riders.show', param: { id: this.$route.params.id } });
                } catch (error){
                    this.errors = error.response.data.errors;
                    this.loading = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            }
        }
    }
</script>