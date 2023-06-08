import { createRouter, createWebHistory } from 'vue-router';
import store from './store';
import Dashboard from './pages/Dashboard.vue';
import Login from './pages/Auth/Login.vue';
import Register from './pages/Auth/Register.vue';
import UserProfile from './pages/User/Profile.vue';

import Parcels from './pages/Parcels/Index.vue';
import CreateParcel from './pages/Parcels/Create.vue';
import EditParcel from './pages/Parcels/Edit.vue';
import EntryParcel from './pages/Parcels/EntryParcel.vue';

import Riders from './pages/Riders/Index.vue';
import ShowRider from './pages/Riders/Show.vue';
import CreateRider from './pages/Riders/Create.vue';
import AssignParcels from './pages/Riders/AssignParcels.vue';
import EditRiderParcels from './pages/Riders/EditParcels.vue';
import ShowRiderParcels from './pages/Riders/ShowParcels.vue';

import Merchants from './pages/Merchants/Index.vue';
import ShowMerchant from './pages/Merchants/Show.vue';
import CreatePayment from './pages/Merchants/CreatePayment.vue';
import ShowPayment from './pages/Merchants/ShowPayment.vue';
import Payments from './pages/Merchants/Payments.vue';

import EditPickupRequest from './pages/Merchants/EditPickup.vue';
import EditWithdrowRequest from './pages/Merchants/EditWithdrow.vue';

import Settings from './pages/Settings.vue';

import Unauthorize from './pages/Errors/403.vue';
import NotFound from './pages/Errors/404.vue';

const routes = [
    { path: '/', name: 'dashboard', component: Dashboard, meta: { roles: ['admin', 'merchant'] } },
    { path: '/login', name: 'login', component: Login },
    { path: '/register', name: 'register', component: Register },
    { path: '/profile', name: 'profile', component: UserProfile },
    
    { path: '/parcels', name: 'parcels', component: Parcels, meta: { roles: ['admin', 'merchant'] } },
    { path: '/parcels/create/:id?', name: 'parcels.create', component: CreateParcel, meta: { roles: ['admin', 'merchant'] } },
    { path: '/parcels/:id/edit', name: 'parcels.edit', component: EditParcel, meta: { roles: ['admin'] } },
    { path: '/parcels/:id', name: 'parcels.show', component: EditParcel, meta: { roles: ['merchant'] } },
    { path: '/parcels/entry-parcel', name: 'parcels.entry', component: EntryParcel, meta: { roles: 'admin' } },
    
    { path: '/rider/parcels/:id', name: 'rider.parcels.show', component: ShowRiderParcels, meta: { roles: 'admin' } },
    { path: '/riders', name: 'riders', component: Riders, meta: { roles: 'admin' } },
    { path: '/riders/create', name: 'riders.create', component: CreateRider, meta: { roles: 'admin' } },
    { path: '/riders/:id', name: 'riders.show', component: ShowRider, meta: { roles: 'admin' } },
    { path: '/riders/:id/assign', name: 'riders.assign', component: AssignParcels, meta: { roles: 'admin' } },
    { path: '/rider/parcels/:id/edit', name: 'rider.parcels.edit', component: EditRiderParcels, meta: { roles: 'admin' } },
    
    { path: '/merchants', name: 'merchants', component: Merchants, meta: { roles: 'admin' } },
    { path: '/merchants/:id', name: 'merchants.show', component: ShowMerchant, meta: { roles: 'admin' } },
    { path: '/payments/:id/create', name: 'payments.create', component: CreatePayment, meta: { roles: 'admin' } },
    { path: '/payments/:id', name: 'payments.show', component: ShowPayment, meta: { roles: ['admin', 'merchant'] } },
    { path: '/payments', name: 'payments', component: Payments, meta: { roles: 'merchant' } },
    { path: '/settings', name: 'settings', component: Settings, meta: { roles: ['merchant', 'admin'] } },

    { path: '/pickup-requests/:id/edit', name: 'pickup.edit', component: EditPickupRequest, meta: { roles: ['admin'] } },
    { path: '/withdrow-request/:id/edit', name: 'withdrow.edit', component: EditWithdrowRequest, meta: { roles: ['admin'] } },    

    { path: '/unauthorize', name: 'unauthorize', component: Unauthorize },
    { path: '/:catchAll(.*)', name: 'not-found', component: NotFound },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const user = store.getters['auth/user'];
    const isAuthenticated = store.getters['auth/authenticated'];
    if (to.name == 'register' && isAuthenticated) next({ name: 'dashboard' })
    else if (to.name == 'login' && isAuthenticated) next({ name: 'dashboard' })
    else if (to.name !== 'login' && to.name !== 'register' && !isAuthenticated) next({ name: 'login' })
    else if (to.name !== 'unauthorize' && isAuthenticated && to.meta.roles && ! to.meta.roles.includes(user.role)) next({ name: 'unauthorize' })
    else next()
})

export default router;