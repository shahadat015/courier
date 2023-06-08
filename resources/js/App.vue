<template>
    <div :class="{'theme-dark': dark}">
        <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
            <!-- Desktop sidebar -->
            <app-sidebar v-if="notAuthRoutes"></app-sidebar>
            <div class="flex flex-col flex-1 w-full">
                <app-header v-if="notAuthRoutes"></app-header>
                <router-view></router-view>
            </div>
        </div>
        <notifications position="bottom right" />
    </div>
</template>

<script>
    import AppHeader from './components/Header.vue'
    import AppSidebar from './components/Sidebar.vue'
    import { mapGetters, mapActions } from "vuex";

    export default {
        components: {
            AppHeader,
            AppSidebar
        },
        beforeMount(){
            this.initTheme();
            this.getSettings();
        },
        computed: {
            ...mapGetters({ 
                dark: "theme/getTheme", 
                isSideMenuOpen: "theme/getSideMenu" 
            }),
            notAuthRoutes(){
                let routes = ['login', 'register'];
                return ! routes.includes(this.$route.name);
            }
        },
        methods: {
            ...mapActions({ 
                initTheme: 'theme/initTheme',
                getSettings: 'settings/getSettings',
            }),
        }
    }
</script>