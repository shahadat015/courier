export default {
    namespaced: true,
    
    state: {
        theme: {},
    },

    getters: {
        getTheme: (state) => {
            return state.theme == 'dark' ? true : false;
        },
        
        getSideMenu: (state) => {
            return state.isSideMenuOpen;
        },
    },

    mutations: {
        SET_THEME(state, theme) {
            state.theme = theme;
            localStorage.theme = theme;
        },

        SET_SIDE_MENU(state, value){
            state.isSideMenuOpen = value;
        },
    },

    actions: {
        initTheme({ commit }) {
            const cachedTheme = localStorage.theme ? localStorage.theme : false;
            //  `true` if the user has set theme to `dark` on browser/OS
            const userPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (cachedTheme) {
                commit('SET_THEME', cachedTheme);
            } else if (userPrefersDark) {
                commit('SET_THEME', 'dark');
            } else {
                commit('SET_THEME', 'light');
            }
        },

        toggleTheme({ commit }) {
            switch (localStorage.theme) {
                case 'light':
                    commit('SET_THEME', 'dark');
                    break;

                default:
                    commit('SET_THEME', 'light');
                    break;
            }
        },

        toggleSideMenu({ commit, state }) {
            commit('SET_SIDE_MENU', ! state.isSideMenuOpen);
        },

        closeSideMenu({ commit }){
            commit('SET_SIDE_MENU', false);
        }
    }
}