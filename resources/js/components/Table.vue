<template>
    <div class="w-full mb-5 border border-gray-50 dark:border-gray-700 overflow-hidden rounded-md shadow-md">
        <div class="flex justify-between items-center px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-white sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
            <div class="flex justify-start flex-1">
                <div class="relative w-full max-w-xs mr-6 focus-within:text-purple-500">
                    <div class="absolute inset-y-0 flex items-center pl-2">
                        <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input
                        class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                        placeholder="Search"
                        @keyup="search"
                    >
                </div>
            </div>
            
            <div class="flex items-center space-x-2">
                <app-button @click="refresh">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </app-button>
                <app-button v-if="actionButton" @click="$emit('callToAction')">{{ actionButton }}</app-button>
            </div>
        </div>
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-white dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3" v-for="column in columns" :key="column.label">{{ column.label }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <template v-if="! loading">
                        <template v-if="rows.length">
                            <tr v-for="(row, index) in rows" :key="row.id" class="text-gray-700 dark:text-gray-400">
                                <template v-for="column in columns" :key="column.label">
                                    <td v-if="column.name == 'image'" class="px-4 py-3 text-sm">
                                        <div class="flex items-center text-sm">
                                            <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                                <img
                                                    class="object-cover w-full h-full rounded-full"
                                                    :src="row[column.name] ? row[column.name] : '/images/male-avater.png'"
                                                    loading="lazy"
                                                />
                                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td v-else-if="column.name == 'status'" class="px-4 py-3 text-xs">
                                        <span v-if="row[column.name] == 'Paid' || row[column.name] == 'Delivered'" class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                            {{ row[column.name] }}
                                        </span>
                                        <span v-else-if="row[column.name] == 'Assigned'" class="px-2 py-1 font-semibold leading-tight text-pink-700 bg-pink-100 rounded-full dark:bg-pink-700 dark:text-pink-100">
                                            {{ row[column.name] }}
                                        </span>
                                        <span v-else-if="row[column.name] == 'Processing'" class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-700 dark:text-blue-100">
                                            {{ row[column.name] }}
                                        </span>
                                        <span v-else-if="row[column.name] == 'Return'" class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                            {{ row[column.name] }}
                                        </span>
                                        <span v-else-if="row[column.name] == 'Half Return'" class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                                            {{ row[column.name] }}
                                        </span>
                                        <span v-else class="px-2 py-1 font-semibold leading-tight text-purple-700 bg-blue-100 rounded-full dark:bg-purple-700 dark:text-purple-100">
                                            {{ row[column.name] }}
                                        </span>
                                    </td>
                                    <td v-else-if="column.name == 'action'" class="px-4 py-3 text-sm space-x-3" width="20%">
                                        <template v-for="action in row[column.name]" :key="action.url">
                                            <router-link :to="{ name: `${actionUrl}.show`, params: { id: row.id } }" v-if="action == 'show'" title="View" class="font-normal text-xs px-3 rounded-sm py-2 leading-tight bg-purple-600 text-white">
                                                View
                                            </router-link>
                                            <router-link :to="{ name: `${actionUrl}.edit`, params: { id: row.id } }" v-if="action == 'edit'" title="Edit" class="font-normal text-xs px-3 rounded-sm py-2 leading-tight bg-purple-600 text-white">
                                                Edit
                                            </router-link>
                                            <router-link :to="{ name: `${actionUrl}.assign`, params: { id: row.id } }" v-if="action == 'assign'" class="font-normal text-xs py-2 px-3 rounded-sm bg-green-500 leading-tight text-white">
                                                Assign
                                            </router-link>
                                            <router-link :to="{ name: `${actionUrl}.create`, params: { id: row.id } }" v-if="action == 'add-parcel'" class="font-normal text-xs py-2 px-3 rounded-sm bg-green-500 leading-tight text-white">
                                                Add Parcel
                                            </router-link>
                                            <span @click="removeItem(row, index)" v-if="action == 'add'" class="font-normal text-xs py-2 px-3 rounded-sm bg-green-500 leading-tight text-white cursor-pointer">
                                                Add
                                            </span>
                                            <span @click="destroy(row.id)" v-if="action == 'destroy'" class="font-normal text-sm leading-tight  px-3 rounded-sm py-2 bg-red-500 text-white cursor-pointer">
                                                Delete
                                            </span>
                                        </template>
                                    </td>
                                    <td v-else class="px-4 py-3 text-sm" v-html="row[column.name]"></td>
                                </template>
                            </tr>
                        </template>
                        <tr v-else class="text-center text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm" :colspan="columns.length">No data found</td>
                        </tr>
                    </template>
                    <tr v-else class="text-center text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 text-sm" :colspan="columns.length"><app-loading></app-loading></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="meta.last_page > 1" class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-white sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
            <span class="flex items-center col-span-3">
                Showing {{ meta.from }} to {{ meta.to }} of {{ meta.total }}
            </span>
            <span class="col-span-2"></span>
            <!-- Pagination -->
            <span class="flex items-center col-span-4 mt-2 sm:mt-auto sm:justify-end">
                <app-select
                    :value="per_page"
                    @changeEvent="per_page = $event"
                >
                    <option v-for="length in [10, 25, 50, 100]" :key="length" :value="length">{{ length }}</option>
                </app-select>
                <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center">
                        <li>
                            <button :disabled="meta.current_page <= 1" @click="changePage(meta.current_page - 1)" class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple" aria-label="Previous">
                                <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                            </button>
                        </li>
                        <li v-for="page in pages" :key="page">
                            <button @click="changePage(page)" :class="{'text-white transition-colors duration-150 bg-purple-600' : isCurrentPage(page)}" class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                {{ page }}
                            </button>
                        </li>
                        <li>
                            <button :disabled="meta.current_page >= meta.last_page" @click="changePage(meta.current_page + 1)" class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple" aria-label="Next">
                                <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                    <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                            </button>
                        </li>
                    </ul>
                </nav>
            </span>
        </div>
    </div>
</template>
<script>
    import AppInput from './Form/Input.vue';
    import AppButton from './Form/Button.vue';
    import AppSelect from './Form/Select.vue';
    import AppLoading from './Loading.vue';

    export default {
        props: ['endpoint', 'actionButton', 'actionUrl' ],
        emits: ['callToAction', 'removed'],
        components: {
            AppInput,
            AppButton,
            AppSelect,
            AppLoading
        },

        data() {
            return {
                meta: {},
                rows: [],
                columns: [],
                query: "",
                offset: 10,
                per_page: 10,
                current_page: 1,
                loading: false,
            }
        },

        beforeMount(){
	    	this.getRows();
	    },

        mounted(){
            emitter.on('removed', item => this.addItem(item));
        },

        computed: {
			pages() {
				let pages = [];
				let from = this.meta.current_page - Math.floor(this.offset / 2);
				if (from < 1) {
					from = 1;
				}
				let to = from + this.offset - 1;
				if (to > this.meta.last_page) {
					to = this.meta.last_page;
				}
				while (from <= to) {
					pages.push(from);
					from++;
				}
				return pages;
			},
		},
        
        methods: {
            async getRows(){
                try{
                    this.loading = true;
                    let res = await axios.get(`/api/${this.endpoint}?page=${this.current_page}&per_page=${this.per_page}&query=${this.query}`);
                    this.rows = res.data.data;
                    this.meta = res.data.meta;
                    this.columns = res.data.columns;
                    this.loading = false;
                }catch(error){
                    this.loading = false;
                    this.$notify({ text: error.response.data.message, type: 'error' });                    
                }
                
            },
			isCurrentPage(page) {
				return this.meta.current_page === page;
			},
			changePage(page) {
				if (page > this.meta.last_page) {
					page = this.meta.last_page;
				}
				this.current_page = page;
				this.meta.current_page = page;
			},
            destroy(id){
                alert(id);
            },
            refresh(){
                this.getRows();
            },
            search(e){
                let timer;
                clearTimeout(timer);

                timer = setTimeout(() => {
                    this.query = e.target.value;
                }, 1000);
            },

            removeItem(item, index){
                this.rows.splice(index, 1);
                this.$emit('removed', item);
            },

            addItem(item){
                this.rows.unshift(item);
            }
		},
        
        watch: {
            query() {
                this.getRows();
            },
            per_page() {
                this.getRows();
            },
            current_page() {
                this.getRows();
            }
        },
        
    }
</script>