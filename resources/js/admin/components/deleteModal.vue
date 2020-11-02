<template>
    <div>
        		<!-- Delete tag Modal -->

	   <Modal :value="getDeleteModelObj.showDeleteModal" width="360" >
        <p slot="header" 
        yle="color:#f60;text-align:center">
            <Icon type="ios-information-circle"></Icon>
            <span>Delete confirmation</span>
        </p>
        <div style="text-align:center">
            <p>Do u wanna delete this  {{getDeleteModelObj.type}}  </p>
           
        </div>
        <div slot="footer">
            <Button type="error" size="large" long :disabled="isDeleting" :loading="isDeleting" @click="deleteComp">Delete</Button>
        </div>
    </Modal>

    <!-- test
    {{getDeleteModelObj}} -->


    </div>
</template>

<script>
   
    import { mapGetters} from 'vuex';



export default {
    

    data(){
        return{
           isDeleting:false 
        }
    },


    methods: {

      async  deleteComp(){

            		this.isDeleting=true;
			
                const res = await this.callApi('post',this.getDeleteModelObj.deleteUrl,this.getDeleteModelObj.data)
                console.log(res.status)
                
				if(res.status==200){
                    this.success('',this.getDeleteModelObj.type+' deleted succefuly')
                    this.$store.commit('setShowDeleteModal',false)
                    this.$store.commit('splice')
                    this.$store.commit('initDeleteObj')
            		this.isDeleting=false;

                }
                  else{
                      if(res.status==422){
					for(let i in res.data.errors){
						 this.error('Oops',res.data.errors[i]);
					}}
        
                   this.error('','Tag  not deletet succefuly')
            		this.isDeleting=false;

                        
                        }

				

        }

    },

    computed:{
        ...mapGetters(['getDeleteModelObj','getCount','getTags'])
    },
    

   
    
}
</script>