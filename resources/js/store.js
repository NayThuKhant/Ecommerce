const store = {
    state: {
        user: "",
        order_ids : [],
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
        },
        setOrderIds(state, ids) {
            state.order_ids = ids
        }
    }
}

export default store;
