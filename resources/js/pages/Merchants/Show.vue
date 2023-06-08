<template>
	<main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid my-6" v-if="! loading">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <app-profile :user="merchant"></app-profile>
                <app-performance :data="merchant.performance"></app-performance>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-md px-5 py-6 my-4">
                <app-tab :tabs="['Parcels', 'Payments', 'Settings']">
                    <template v-slot:Parcels>
                        <app-table :endpoint="`parcels/${$route.params.id}/merchant`" actionUrl="parcels" actionButton="Add Parcel" @callToAction="$router.push({ name: 'parcels.create', params: { id: $route.params.id }})"></app-table>
                    </template>
                    <template v-slot:Payments>
                        <app-table :endpoint="`payments/${$route.params.id}/merchant`" actionUrl="payments" actionButton="Create" @callToAction="$router.push({ name: 'payments.create', params: { id: $route.params.id }})"></app-table>
                    </template>
                    <template v-slot:Settings>
                        <form @submit.prevent="updateMerchant">
                            <div class="sm:flex space-y-4 sm:space-y-0 sm:space-x-6">
                                <label class="block text-sm w-full sm:w-1/2">
                                    <app-input
                                        @inputEvent="merchant.business_name = $event"
                                        :value="merchant.business_name"
                                        placeholder="Business Name"
                                    />
                                    <app-error :errors="errors" field="business_name"></app-error>
                                </label>
                                <label class="block text-sm w-full sm:w-1/2">
                                    <app-input
                                        @inputEvent="merchant.name = $event"
                                        :value="merchant.name"
                                        placeholder="Merchant name"
                                    />
                                    <app-error :errors="errors" field="name"></app-error>
                                </label>
                            </div>
                            <div class="sm:flex space-y-4 sm:space-y-0 sm:space-x-6">
                                <label class="block text-sm w-full sm:w-1/2">
                                    <app-input
                                        @inputEvent="merchant.phone = $event"
                                        :value="merchant.phone"
                                        placeholder="Phone Number"
                                    />
                                    <app-error :errors="errors" field="phone"></app-error>
                                </label>
                                <label class="block text-sm w-full sm:w-1/2">
                                    <app-input
                                        @inputEvent="merchant.eamil = $event"
                                        :value="merchant.email"
                                        placeholder="Email Arress"
                                        :rows="2"
                                    />
                                    <app-error :errors="errors" field="email"></app-error>
                                </label>
                            </div>
                            <label class="block my-2 text-sm w-full">
                                <app-textarea
                                        @inputEvent="merchant.pickup_location = $event"
                                    :value="merchant.pickup_location"
                                    placeholder="Pickup Location"
                                    :rows="2"
                                />
                                    <app-error :errors="errors" field="pickup_location"></app-error>
                            </label>
                            <app-button :disabled="is_updating">Update</app-button>
                        </form>
                    </template>
                </app-tab>
            </div>
        </div>
        <div class="container px-6 mx-auto my-6" v-else>
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-md px-5 py-6 my-4">
                <app-loading></app-loading>
            </div>
        </div>
    </main>
</template>
<script>
    import AppTab from '../../components/Tab.vue';
    import AppTable from '../../components/Table.vue';
    import AppProfile from '../../components/Profile.vue';
    import AppPerformance from '../../components/Performance.vue';
    import AppInput from '../../components/Form/Input.vue';
    import AppTextarea from '../../components/Form/Textarea.vue';
    import AppButton from '../../components/Form/Button.vue';
    import AppError from '../../components/ValidationError.vue';
    import AppLoading from '../../components/Loading.vue';

    export default {
        components: {
            AppTab,
            AppTable,
            AppProfile,
            AppPerformance,
            AppInput,
            AppTextarea,
            AppButton,
            AppError,
            AppLoading
        },

        data(){
            return {
                merchant: {
                    business_name: '',
                    name: '',
                    phone: '',
                    email: '',
                    pickup_location: '',
                },
                loading: false,
                is_updating: false,
                errors: {}
            }
        },

        beforeMount(){
            this.getMerchant();
        },

        methods: {
            async getMerchant() {
                try {
                    this.loading = true;
                    let { data } = await axios.get(`/api/merchants/${this.$route.params.id}`);
                    this.merchant = data.data;
                    this.loading = false;
                } catch (error){
                    this.loading = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            },

            async updateMerchant(){
                try {
                    this.is_updating = true;
                    let { data } = await axios.put(`/api/merchants/${this.$route.params.id}`, this.merchant);
                    this.is_updating = false;
                    this.$notify({ text: data.message, type: data.success ? 'success' : 'error' });
                } catch (error){
                    this.errors = error.response.data.errors;
                    this.is_updating = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            },
        }
    }
</script>