<template>
	<main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid my-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4" v-if="can('merchant')">
                <app-profile :user="user"></app-profile>
                <div class="col-span-2 bg-white dark:bg-gray-800 shadow-md rounded-md p-4">
                    <app-tab :tabs="['Company', 'Owner', 'Shop', 'Bank-Account']">
                        <template v-slot:Company>
                            <h3 class="font-semibold text-1xl text-gray-700 dark:text-gray-300">Business Information</h3>
                            <form>
                                <div class="sm:flex space-y-4 sm:space-y-0 sm:space-x-6">
                                    <label class="block text-sm w-full sm:w-1/2">
                                        <app-input 
                                            :value="merchant.business_name"
                                            placeholder="Business Name"
                                        />
                                    </label>
                                    <label class="block text-sm w-full sm:w-1/2">
                                        <app-input 
                                            :value="merchant.phone"
                                            placeholder="Phone number"
                                        />
                                    </label>
                                </div>
                                <label class="block my-2 text-sm w-full">
                                    <app-textarea 
                                        :value="merchant.pickup_location"
                                        placeholder="Pickup Location"
                                        :rows="2"
                                    />
                                </label>
                                <app-button :disabled="true">Update</app-button>
                            </form>
                        </template>
                        <template v-slot:Owner>
                            <h3 class="font-semibold text-1xl text-gray-700 dark:text-gray-300">Owner Detail</h3>
                            <form>
                                <div class="sm:flex space-y-4 sm:space-y-0 sm:space-x-6">
                                    <label class="block text-sm w-full sm:w-1/2">
                                        <app-input 
                                            :value="merchant.name"
                                            placeholder="Business Name"
                                        />
                                    </label>
                                    <label class="block text-sm w-full sm:w-1/2">
                                        <app-input 
                                            :value="merchant.phone"
                                            placeholder="Phone number"
                                        />
                                    </label>
                                </div>
                                <label class="block my-2 text-sm w-full">
                                    <app-input 
                                        :value="merchant.email"
                                        placeholder="Business Name"
                                        :rows="2"
                                    />
                                </label>
                                <app-button :disabled="true">Update</app-button>
                            </form>
                        </template>
                        <template v-slot:Shop>
                            <h3 class="mb-8 font-semibold text-1xl text-gray-700 dark:text-gray-300">Shop List</h3>
                            <div class="text-gray-700 dark:text-gray-300 font-normal text-sm">
                                <template v-if="shops.length">
                                    <div v-for="shop in shops" :key="shop.business_name" class="mb-8 grid grid-cols-0 sm:grid-cols-2 gap-x-2 pb-2 border-b border-gray-100 dark:border-gray-700">
                                        <div>
                                            <div>{{ shop.business_name }}</div>
                                            <div>{{ shop.phone }}</div>
                                        </div>
                                        <div>{{ shop.pickup_location }}</div>
                                    </div>
                                </template>
                                <div v-else>No shop found</div>
                            </div>
                            <h3 class="font-semibold text-1xl text-gray-700 dark:text-gray-300 mt-8">Create a shop</h3>
                            <form @submit.prevent="addShop">
                                <div class="sm:flex space-y-4 sm:space-y-0 sm:space-x-6">
                                    <label class="block text-sm w-full sm:w-1/2">
                                        <app-input 
                                            :value="shop.business_name"
                                            @inputEvent="shop.business_name = $event"
                                            placeholder="Shop Name"
                                        />
                                        <app-error :errors="errors" field="business_name"></app-error>
                                    </label>
                                    <label class="block text-sm w-full sm:w-1/2">
                                        <app-input 
                                            :value="shop.phone"
                                            @inputEvent="shop.phone = $event"
                                            placeholder="Shop Contact"
                                        />
                                        <app-error :errors="errors" field="phone"></app-error>
                                    </label>
                                </div>
                                <label class="block my-2 text-sm w-full">
                                    <app-textarea 
                                        :value="shop.pickup_location"
                                        @inputEvent="shop.pickup_location = $event"
                                        placeholder="Pickup Address"
                                        :rows="2"
                                    />
                                    <app-error :errors="errors" field="pickup_location"></app-error>
                                </label>
                                <app-button :disabled="is_creating">Save</app-button>
                            </form>
                        </template>
                        <template v-slot:Bank-Account>
                            <h3 class="font-semibold text-1xl text-gray-700 dark:text-gray-300">Bank Account</h3>
                            <template v-if="bank_accounts.length">
                                <div v-for="account in bank_accounts" :key="account.account_number" class="space-y-8 text-gray-700 dark:text-gray-300 font-normal text-sm mt-8">
                                    <div v-if="account.bank_type == 'bank_account'" class="pb-2 border-b border-gray-100 dark:border-gray-700">
                                        <div>Bank Name: {{ account.bank_name }}</div>
                                        <div>Branch: {{ account.branch }}</div>
                                        <div>Account Number: {{ account.account_number }}</div>
                                        <div>Account Name: {{ account.account_name }}</div>
                                    </div>
                                    <div v-else class="pb-2 border-b border-gray-100 dark:border-gray-700">
                                        <div>{{ account.provider }}: {{ account.phone_number }} ({{ account.account_type }})</div>
                                    </div>
                                </div>
                            </template>
                            <div class="text-gray-700 dark:text-gray-300" v-else>No bank account found</div>
                                
                            <h3 class="font-semibold text-1xl text-gray-700 dark:text-gray-300 mt-8">Add Account</h3>
                            <form @submit.prevent="addAccount">
                                <label class="block text-sm w-full">
                                    <app-select 
                                        :value="bank.bank_type"
                                        @changeEvent="bank.bank_type = $event"
                                        classes="w-full block mt-2 border border-gray-100 dark:border-gray-700"
                                    >
                                        <option value="bank_account">Bank Account</option>
                                        <option value="mobile_banking">Mobile Banking</option>
                                    </app-select>
                                    <app-error :errors="errors" field="bank_type"></app-error>
                                </label>
                                <div v-if="bank.bank_type == 'bank_account'">
                                    <div class="sm:flex space-y-3 sm:space-y-0 sm:space-x-6">
                                        <label class="block text-sm w-full sm:w-1/2">
                                            <app-select 
                                                :value="bank.bank_name"
                                                @changeEvent="bank.bank_name = $event"
                                                classes="w-full block mt-1 border border-gray-100 dark:border-gray-700"
                                            >
                                                <option value="AB BANK LIMITED">AB BANK LIMITED</option>
                                                <option value="AGRANI BANK LIMITED">AGRANI BANK LIMITED</option>
                                                <option value="AL-ARAFAH ISLAMI BANK LTD">AL-ARAFAH ISLAMI BANK LTD</option>
                                                <option value="BANK ASIA LTD">BANK ASIA LTD</option>
                                                <option value="Brac Bank Ltd">Brac Bank Ltd</option>
                                                <option value="City Bank Ltd">City Bank Ltd</option>
                                                <option value="DHAKA BANK LIMITED">DHAKA BANK LIMITED</option>
                                                <option value="Dutch-Bangla Bank Ltd">Dutch-Bangla Bank Ltd</option>
                                                <option value="EASTERN BANK LTD">EASTERN BANK LTD</option>
                                                <option value="IFIC BANK LTD">IFIC BANK LTD</option>
                                                <option value="ISLAMI BANK BANGLADESH LTD">ISLAMI BANK BANGLADESH LTD</option>
                                                <option value="JAMUNA BANK LIMITED">JAMUNA BANK LIMITED</option>
                                                <option value="MERCANTILE BANK LIMITED">MERCANTILE BANK LIMITED</option>
                                                <option value="MUTUAL TRUST BANK LIMITED">MUTUAL TRUST BANK LIMITED</option>
                                                <option value="NATIONAL BANK LIMITED">NATIONAL BANK LIMITED</option>
                                                <option value="NRB BANK LIMITED">NRB BANK LIMITED</option>
                                                <option value="NRB COMMERCIAL BANK LIMITED">NRB COMMERCIAL BANK LIMITED</option>
                                                <option value="ONE BANK LIMITED">ONE BANK LIMITED</option>
                                                <option value="PRIME BANK LIMITED">PRIME BANK LIMITED</option>
                                                <option value="SOUTHEAST BANK LIMITED">SOUTHEAST BANK LIMITED</option>
                                                <option value="STANDARD BANK LIMITED">STANDARD BANK LIMITED</option>
                                                <option value="STANDARD CHARTERED BANK">STANDARD CHARTERED BANK</option>
                                                <option value="THE PREMIER BANK LIMITED">THE PREMIER BANK LIMITED</option>
                                                <option value="TRUST BANK LTD">TRUST BANK LTD</option>
                                                <option value="UNITED COMMERCIAL BANK LTD">UNITED COMMERCIAL BANK LTD</option>
                                                <option value="UTTARA BANK LIMITED">UTTARA BANK LIMITED</option>
                                            </app-select>
                                            <app-error :errors="errors" field="bank_name"></app-error>
                                        </label>
                                        <label class="block text-sm w-full sm:w-1/2">
                                            <app-input 
                                                :value="bank.branch"
                                                @inputEvent="bank.branch = $event"
                                                placeholder="Branch"
                                            />
                                            <app-error :errors="errors" field="branch"></app-error>
                                        </label>
                                    </div>
                                    <div class="sm:flex space-y-4 sm:space-y-0 sm:space-x-6">
                                        <label class="block text-sm w-full sm:w-1/2">
                                            <app-input 
                                                :value="bank.account_name"
                                                @inputEvent="bank.account_name = $event"
                                                placeholder="Account Name"
                                            />
                                            <app-error :errors="errors" field="account_name"></app-error>
                                        </label>
                                        <label class="block text-sm w-full sm:w-1/2">
                                            <app-input 
                                                :value="bank.account_number"
                                                @inputEvent="bank.account_number = $event"
                                                placeholder="Account Number"
                                                type="number"
                                            />
                                            <app-error :errors="errors" field="account_number"></app-error>
                                        </label>
                                    </div>
                                </div>
                                <div v-else>
                                    <div class="sm:flex space-y-3 sm:space-y-0 sm:space-x-6">
                                        <label class="block text-sm w-full sm:w-1/2">
                                            <app-select 
                                                :value="bank.provider"
                                                @changeEvent="bank.provider = $event"
                                                classes="w-full block mt-2  border border-gray-100 dark:border-gray-700"
                                            >
                                                <option value="Bkash">Bkash</option>
                                                <option value="Rocket">Rocket</option>
                                                <option value="Nogodh">Nogodh</option>
                                            </app-select>
                                            <app-error :errors="errors" field="provider"></app-error>
                                        </label>
                                        <label class="block text-sm w-full sm:w-1/2">
                                            <app-select 
                                                :value="bank.account_type"
                                                @changeEvent="bank.account_type = $event"
                                                classes="w-full block mt-2"
                                            >
                                                <option value="Personal">Personal</option>
                                                <option value="Merchant">Merchant</option>
                                            </app-select>
                                            <app-error :errors="errors" field="account_type"></app-error>
                                        </label>
                                    </div>
                                    <label class="block text-sm w-full">
                                        <app-input 
                                            :value="bank.phone_number"
                                            @inputEvent="bank.phone_number = $event"
                                            placeholder="Phone Number"
                                            type="tel"
                                        />
                                        <app-error :errors="errors" field="phone_number"></app-error>
                                    </label>
                                </div>
                                <app-button classes="mt-2" :disabled="is_creating">Save</app-button>
                            </form>
                        </template>
                    </app-tab>
                </div>
            </div>
            <div v-if="can('admin')" class="col-span-2 bg-white dark:bg-gray-800 shadow-md rounded-md p-4">
                <app-tab :tabs="['General']">
                    <template v-slot:General>
                        <h3 class="font-semibold text-1xl text-gray-700 dark:text-gray-300">General Setting</h3>
                        <form class="space-y-4" @submit.prevent="updateSettings">
                            <div class="sm:flex space-y-4 sm:space-y-0 sm:space-x-6">
                                <label class="block text-sm w-full sm:w-1/2">
                                    <app-input 
                                        @inputEvent="form.business_name = $event"
                                        :value="form.business_name"
                                        placeholder="Business Name"
                                    />
                                    <app-error :errors="errors" field="business_name"></app-error>
                                </label>
                                <label class="block text-sm w-full sm:w-1/2">
                                    <app-input
                                        @inputEvent="form.title = $event"
                                        :value="form.title"
                                        placeholder="Business Title"
                                    />
                                    <app-error :errors="errors" field="title"></app-error>
                                </label>
                            </div>
                            <div class="sm:flex space-y-4 sm:space-y-0 sm:space-x-6">
                                <label class="block text-sm w-full sm:w-1/2">
                                    <app-input 
                                        :value="form.email"
                                        @inputEvent="form.email = $event"
                                        placeholder="Business Email"
                                    />
                                    <app-error :errors="errors" field="email"></app-error>
                                </label>
                                <label class="block text-sm w-full sm:w-1/2">
                                    <app-input 
                                        :value="form.phone"
                                        @inputEvent="form.phone = $event"
                                        placeholder="Phone number"
                                    />
                                    <app-error :errors="errors" field="phone"></app-error>
                                </label>
                            </div>
                            <div class="sm:flex space-y-4 sm:space-y-0 sm:space-x-6">
                                <label class="block text-sm w-full">
                                    <app-textarea 
                                        :value="form.address"
                                        @inputEvent="form.address = $event"
                                        placeholder="Address"
                                        :rows="2"
                                    />
                                    <app-error :errors="errors" field="address"></app-error>
                                </label>
                                <label class="block my-2 text-sm w-full">
                                    <app-input 
                                        @change="selectLogo"
                                        type="file"
                                    />
                                    <app-error :errors="errors" field="logo"></app-error>
                                </label>
                            </div>
                            <app-button :disabled="is_creating">Update</app-button>
                        </form>
                    </template>
                </app-tab>
            </div>
        </div>
    </main>
</template>
<script>
    import AppTab from '../components/Tab.vue';
    import AppError from '../components/ValidationError.vue';
    import AppProfile from '../components/Profile.vue';
    import AppInput from '../components/Form/Input.vue';
    import AppSelect from '../components/Form/Select.vue';
    import AppButton from '../components/Form/Button.vue';
    import AppTextarea from '../components/Form/Textarea.vue';
    import { mapGetters, mapActions } from 'vuex'

    export default {
        components: {
            AppTab,
            AppProfile,
            AppInput,
            AppButton,
            AppSelect,
            AppTextarea,
            AppError,
        },

        data(){
            return {
                merchant: {},
                shops: [],
                bank_accounts: [],
                is_creating: false,
                errors: {},
                shop: {
                    phone: '',
                    business_name: '',
                    pickup_location: '',
                },
                bank: {
                    bank_name: 'AB BANK LIMITED',
                    branch: '',
                    account_name: '',
                    account_number: '',
                    bank_type: 'bank_account',
                    provider: 'Bkash',
                    account_type:'Personal',
                    phone_number: ''
                },
                form: {
                    business_name: '',
                    title: '',
                    phone: '',
                    email: '',
                    address: '',
                    logo: ''
                },
                logo: '',
            }
        },

        beforeMount(){
            if(this.can('merchant')){
                this.getMerchant();
            }

            if(this.can('admin')){
                this.setSettings();
            }
        },

        computed: {
            ...mapGetters({
                user: 'auth/user',
            }),
        },

        methods: {
            ...mapActions({
                getSettings: 'settings/getSettings'
            }),

            async setSettings(){
                try {
                    this.loading = true;
                    this.form = await this.getSettings();
                    this.loading = false;
                } catch (error){
                    this.loading = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            },

            selectLogo(e){
                let file = e.target.files[0];
                this.logo = file;
                this.form.logo = URL.createObjectURL(file)
            },

            async updateSettings(){
                let formData = new FormData();
                formData.append('business_name', this.form.business_name);
                formData.append('title', this.form.title);
                if(this.form.email){
                    formData.append('email', this.form.email);
                }
                formData.append('phone', this.form.phone);
                formData.append('address', this.form.address);
                if(typeof this.logo == 'object'){
                    formData.append('logo', this.logo);
                }

                try {
                    this.is_creating = true;
                    let { data } = await axios.post(`/api/settings`, formData);
                    this.is_creating = false;
                    this.$notify({ text: data.message, type: data.success ? 'success' : 'error' });
                } catch (error){
                    this.errors = error.response.data.errors;
                    this.is_creating = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            },

            async getMerchant() {
                try {
                    this.loading = true;
                    let { data } = await axios.get(`/api/merchants/${this.user.id}`);
                    this.merchant = data.data;
                    this.bank_accounts = data.data.bank_accounts;
                    this.shops = data.data.shops;
                    this.loading = false;
                } catch (error){
                    this.loading = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            },

            async addShop(){
                try {
                    this.is_creating = true;
                    let { data } = await axios.post(`/api/shops/${this.user.id}/merchant`, this.shop);
                    this.shops.push({...this.shop});
                    this.shop.phone = '';
                    this.shop.business_name = '';
                    this.shop.pickup_location = '';
                    this.is_creating = false;
                    this.$notify({ text: data.message, type: data.success ? 'success' : 'error' });
                } catch (error){
                    this.errors = error.response.data.errors;
                    this.is_creating = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            },

            async addAccount(){
                try {
                    this.is_creating = true;
                    let { data } = await axios.post(`/api/bank-account/${this.user.id}/merchant`, this.bank);
                    this.bank_accounts.push({...this.bank});
                    this.bank.branch = '';
                    this.bank.account_name = '';
                    this.bank.account_number = '';
                    this.bank.phone_number = '';
                    this.is_creating = false;
                    this.$notify({ text: data.message, type: data.success ? 'success' : 'error' });
                } catch (error){
                    this.errors = error.response.data.errors;
                    this.is_creating = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });
                }
            },
        }
    }
</script>