import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)



export default new Vuex.Store({
    state: {
      count: 0,
      tags:[],
      categories:[],
      deleteModelObj:{
        data:null,
        deleteUrl:'',
        showDeleteModal:false,
        isDeleted:false,
        type:'',
        deleteIndex:-1,
      }
    },

    getters:{
      getCount(state){
        return state.count;
      },
      getDeleteModelObj(state){
        return state.deleteModelObj;
      },
      getShowDeleteModel(state){
        return state.deleteModelObj.showDeleteModal;
      },
      getTags(state){
        return state.tags;
      },
      getCategories(state){
        return state.categories;
      }

    },

    actions:{
      changeCount({commit},data){
        commit('increment',data)
      },
      
   


    },

    mutations: {
      increment (state , data) {
        state.count+=data;
      },
      setTags(state,data){
        state.tags=data
      },
      setCategories(state,data){
        state.categories=data
      },
      setShowDeleteModal(state,data){
        state.deleteModelObj.showDeleteModal=data
      },
      setDeleteModelObj(state,data){
        state.deleteModelObj=data
        state.deleteModelObj.showDeleteModal=true
      },
      splice(state){
        if(state.deleteModelObj.type='tag'){
          state.tags.splice(state.deleteModelObj.index,1)
        }
        if(state.deleteModelObj.type='category'){
          state.categories.splice(state.deleteModelObj.index,1)
        }
      },
      initDeleteObj(state){
        const deleteModelObj= {
          data:null,
          deleteUrl:'',
          showDeleteModal:false,
          isDeleted:false,
          type:'',
          deleteIndex:-1,
        }

        state.deleteModelObj=deleteModelObj
        console.log(state.deleteModelObj)

        
      }
    },
   
    
  })