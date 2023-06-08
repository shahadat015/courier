<template>
    <aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
        <div class="py-4 text-gray-500 dark:text-gray-400">
            <router-link class="flex justify-center" :to="{ name: 'dashboard' }">
                <img class="w-32 h-10 object-cover" :src="settings.logo" alt="">
            </router-link>
            <ul class="mt-6">
                <template v-for="menu in menus" :key="menu.title">
                    <li class="relative px-6 py-3" v-if="! menu.submenus && can(menu.role)" @click="isPagesMenuOpen = false">
                        <span v-if="isActiveMenu(menu.name)" class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                        <router-link :to="{ name: menu.name }" class="inline-flex items-center w-full text-sm font-semibold text-gray-600 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" :class="isActiveMenu(menu.name) ? 'dark:text-gray-100 text-gray-800' : 'dark:text-gray-400'">
                            <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" v-html="menu.icon"></svg>
                            <span class="ml-4">{{ menu.title }}</span>
                        </router-link>
                    </li>
                    <li class="relative px-6 py-3" v-else-if="can(menu.role)">
                        <button class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" :class="{'dark:text-gray-100 text-gray-800': isPagesMenuOpen == menu.name}" @click="togglePagesMenu(menu.name)" aria-haspopup="true">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" v-html="menu.icon"></svg>
                                <span class="ml-4">{{ menu.title }}</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path v-if="isPagesMenuOpen == menu.name" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                <path v-else fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <template v-if="isPagesMenuOpen == menu.name">
                            <ul
                                class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                aria-label="submenu"
                            >
                                
                                <li v-for="submenu in menu.submenus" :key="submenu.title" class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                    <span v-if="isActiveMenu(submenu.name)" class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                                    <router-link :to="{ name: submenu.name }" class="w-full">{{ submenu.title }}</router-link>
                                </li>
                            </ul>
                        </template>
                    </li>
                </template>
                
                <li class="relative px-6 py-3">
                    <button @click="logout" class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="ml-4">Logout</span>
                    </button>
                </li>
            </ul>
        </div>
    </aside>
    <!-- Mobile sidebar -->
    <!-- Backdrop -->
    <transition
        enter-active-class="transition ease-in-out duration-150"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition ease-in-out duration-150"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-show="isSideMenuOpen"
            @click.self="closeSideMenu"
            class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
        ></div>
        
    </transition>
    <transition
        enter-active-class="transition ease-in-out duration-150"
        enter-from-class="opacity-0 transform -translate-x-20"
        enter-to-class="opacity-100"
        leave-active-class="transition ease-in-out duration-150"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0 transform -translate-x-20"
    >

        <aside
            class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
            v-show="isSideMenuOpen"
        >
            <div class="py-4 text-gray-500 dark:text-gray-400">
                <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
                    eCourier
                </a>
                <ul class="mt-6">
                    <template v-for="menu in menus" :key="menu.name">
                        <li class="relative px-6 py-3" v-if="! menu.submenus && can(menu.role)">
                            <span v-if="isActiveMenu(menu.name)" class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                            <router-link :to="{ name: menu.name }" class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100">
                                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" v-html="menu.icon"></svg>
                                <span class="ml-4">{{ menu.title }}</span>
                            </router-link>
                        </li>
                        <li class="relative px-6 py-3" v-else-if="can(menu.role)">
                            <button class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" :class="{'dark:text-gray-100 text-gray-800': isPagesMenuOpen == menu.name}" @click="togglePagesMenu(menu.name)" aria-haspopup="true">
                                <span class="inline-flex items-center">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" v-html="menu.icon"></svg>
                                    <span class="ml-4">{{ menu.title }}</span>
                                </span>
                                <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path v-if="isPagesMenuOpen == menu.name" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    <path v-else fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <template v-if="isPagesMenuOpen == menu.name">
                                <ul
                                    class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                    aria-label="submenu"
                                >
                                    <li v-for="submenu in menu.submenus" :key="submenu.name" class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                        <span v-if="isActiveMenu(submenu.name)" class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                                        <router-link :to="{ name: submenu.name }" class="w-full">{{ submenu.title }}</router-link>
                                    </li>
                                </ul>
                            </template>
                        </li>
                    </template>
                    <li class="relative px-6 py-3">
                        <button @click="logout" class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400">
                            <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="ml-4">Logout</span>
                        </button>
                    </li>
                </ul>
            </div>
        </aside>
    
    </transition>
</template>
<script>
    import { mapGetters, mapActions } from "vuex";

    export default {
        data(){
            return {
                isPagesMenuOpen: false,
                menus: [
                    {
                        title: 'Dashboard',
                        name: 'dashboard',
                        submenus: false,
                        icon: '<path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>',
                        role: ['admin', 'merchant'],
                    },
                    {
                        title: 'Parcel',
                        icon: '<path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />',
                        name: 'parcel',
                        role: 'admin',
                        submenus: [
                            {
                                title: 'Entry Parcel',
                                name: 'parcels.entry'
                            },
                            {
                                title: 'All Parcels',
                                name: 'parcels'
                            }
                        ]
                    },
                    {
                        title: 'Merchant',
                        icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />',
                        name: 'merchant',
                        role: 'admin',
                        submenus: [
                            {
                                title: 'All Merchants',
                                name: 'merchants'
                            }
                        ]
                    },
                    {
                        title: 'Rider',
                        name: 'rider',
                        role: 'admin',
                        icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />',
                        submenus: [
                            {
                                title: 'All Riders',
                                name: 'riders'
                            },
                            {
                                title: 'Rider Registration',
                                name: 'riders.create'
                            }
                        ]
                    },
                    {
                        title: 'Create Parcel',
                        name: 'parcels.create',
                        submenus: false,
                        icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />',
                        role: 'merchant',
                    },
                    {
                        title: 'All Parcels',
                        name: 'parcels',
                        submenus: false,
                        icon: '<path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />',
                        role: 'merchant',
                    },
                    {
                        title: 'Payments',
                        name: 'payments',
                        submenus: false,
                        icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />',
                        role: 'merchant',
                    },
                    {
                        title: 'Settings',
                        name: 'settings',
                        submenus: false,
                        icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />',
                        role: ['merchant', 'admin'],
                    },
                ]
            }
        },

        computed: {
            ...mapGetters({
                isSideMenuOpen: "theme/getSideMenu",
                user: 'auth/user',
                settings: 'settings/settings'
            })
        },
        
        methods: {
            ...mapActions({
                signOut: 'auth/signOut',
                closeSideMenu: 'theme/closeSideMenu'
            }),
            async logout(){
                try {
                    await this.signOut();
                    this.$router.replace({ name: 'login' });
                } catch(error) {
                    console.log(error);
                }
            },
            isActiveMenu(menu){
                return this.$route.name == menu;
            },
            togglePagesMenu(name){
                if(this.isPagesMenuOpen == name){
                    this.isPagesMenuOpen = false;
                }else{
                    this.isPagesMenuOpen = name;
                }
            }
        }

    }
</script>