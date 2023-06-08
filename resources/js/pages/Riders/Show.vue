<template>
	<main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid my-6" v-if="! loading">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <app-profile :user="rider"></app-profile>
                <app-performance :data="rider.performance"></app-performance>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-md px-5 py-6 my-4">
                <app-tab :tabs="['Parcels', 'Settings']">
                    <template v-slot:Parcels>
                        <app-table :endpoint="`parcels/${$route.params.id}/rider`" actionUrl="rider.parcels" actionButton="Assign" @callToAction="$router.push({ name: 'riders.assign', params: { id: $route.params.id }})"></app-table>
                    </template>
                    <template v-slot:Settings>
                        <form @submit.prevent="updateRider" class="space-y-2">
                            <div class="sm:flex space-y-4 sm:space-y-0 sm:space-x-6">
                                <label class="block text-sm w-full sm:w-1/2">
                                    <app-input
                                        @inputEvent="rider.name = $event"
                                        :value="rider.name"
                                        placeholder="Rider Name"
                                    />
                                    <app-error :errors="errors" field="name"></app-error>
                                </label>
                                <label class="block text-sm w-full sm:w-1/2">
                                    <app-input
                                        @inputEvent="rider.phone = $event"
                                        :value="rider.phone"
                                        placeholder="Rider Phone"
                                    />
                                    <app-error :errors="errors" field="name"></app-error>
                                </label>
                            </div>
                            <div class="sm:flex space-y-4 sm:space-y-0 sm:space-x-6">
                                <label class="block text-sm w-full sm:w-1/2">
                                    <app-textarea
                                    @inputEvent="rider.present_address = $event"
                                        :value="rider.present_address"
                                        placeholder="Present Address"
                                        :rows="2"
                                    />
                                    <app-error :errors="errors" field="present_address"></app-error>
                                </label>
                                <label class="block text-sm w-full sm:w-1/2">
                                    <app-textarea
                                        @inputEvent="rider.permanent_address = $event"
                                        :value="rider.permanent_address"
                                        placeholder="Permanent Address"
                                        :rows="2"
                                    />
                                    <app-error :errors="errors" field="permanent_address"></app-error>
                                </label>
                            </div>
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
                rider: {},
                errors: {},
                is_updating: false,
                loading: false
            }
        },

        beforeMount(){
            this.getRider();
        },

        methods: {
            async getRider() {
                try {
                    this.loading = true;
                    let { data } = await axios.get(`/api/riders/${this.$route.params.id}`);
                    this.rider = data.data;
                    this.loading = false;
                } catch (error){
                    this.loading = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            },

            async updateRider(){
                try {
                    this.is_updating = true;
                    let { data } = await axios.put(`/api/riders/${this.$route.params.id}`, this.rider);
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