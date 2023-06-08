import { createStore } from 'vuex';
import theme from './theme.js';
import auth from './auth.js';
import settings from './settings.js';

const store = createStore({
    modules: {
        theme,
        auth,
        settings
    }
});

export default store;