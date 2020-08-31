
const store = {
    state: {
        user: "",
        ready: false
    },
    mutations: {
        setAsReady(state) {
            state.ready = true
        },
        setAsNotReady(state) {
            state.ready = false
        },
        setCurrentUser(state, user) {
            state.user = user
        }
    }
}

export default store;
