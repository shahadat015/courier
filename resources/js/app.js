require("./bootstrap");

import { createApp } from "vue";
import App from "./App.vue";
import router from './router';
import store from './store';
import Notifications from '@kyvg/vue3-notification';
import mitt from 'mitt';
window.emitter = mitt()

store.dispatch('auth/me').then(()=>{
    let app = createApp(App);
    const user = store.getters['auth/user'];
    
    app.mixin({
        methods: {
            can(role){
                if(! user ) return;
                if(Array.isArray(role)) return role.includes(user.role);
                return role == user.role;
            }
        }
    });      
    
    app.use(store);
    app.use(router);
    app.use(Notifications);
    app.mount("#app");
});
