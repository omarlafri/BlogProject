<template>
    <div class="content"> 
        <h1> Im component C</h1>   
        <h1> The counter value is {{ getCount}} </h1>   
        
        
        <div>
            <comA></comA> 
        </div>

        <div>
            <comB></comB> 
        </div>

        <deleteModal></deleteModal>


        <Button type="info" @click="increment">Increment </Button>

     </div>
</template>

<script>
    import comB from './comB';
    import comA from './comA';
	import deleteModal from '../admin/components/deleteModal';
    import { mapGetters} from 'vuex';



export default {


    methods: {

        increment(){
            this.$store.commit('setShowDeleteModal',true)

        }

    },

    computed:{
        ...mapGetters(['getCount'])
    },
    

    components:{
        comA,comB,deleteModal
    }
    
}
</script>