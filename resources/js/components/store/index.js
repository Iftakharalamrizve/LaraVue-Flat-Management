export const storage = {
    state:{
        millrate:[]
    },
    getters:{
        getMillRate(state){
            return state.millrate
        }
    },
    mutations :{
        addMillRate(state,payload){
            state.millrate.push(payload)
        }
    }
}