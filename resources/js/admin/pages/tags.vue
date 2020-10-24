<template>
    <div class="content">
			<div class="container-fluid">
				
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tags  <Button @click="addModal=true"><Icon type="md-add" /> Add tag</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr >
								<th>ID</th>
								<th>Tag name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
									<tr v-for="(tag,i) in tags " :key="i" :v-if="tags.length">
								<td>{{tag.id}}</td>
								<td><strong> {{tag.tagName}}</strong></td>
								<td>{{tag.created_at}}</td>
								<td>
									<Button type="info" @click="showEditModal(tag,i)">Edit</Button>
   
   									 <Button type="error" @click="showDeleteModal(tag,i)" >Delete</Button>
									
								</td>
							</tr>
						</table>
							
								<!-- add tag Modal -->
				<Modal
				v-model="addModal"
				title="Add tag"
				:mask-closable="false"
				:closable="false"
			>
			<Input v-model="data.tagName" placeholder="Enter the tag name" style="width: 300px" />
				<div slot="footer">
					<Button type="default" @click="addModal=false">Close </Button>
					<Button type="primary"   @click="addTag" :disabled="isAding" :loading="isAding">{{isAding?'Adding ...' :' Add tag'}}  </Button>

				</div>
			</Modal>

						<!-- edit tag Modal -->
		<Modal
        v-model="editModal"
        title="Edit tag"
		:mask-closable="false"
		:closable="false"
       >
	   <Input v-model="editData.tagName"  style="width: 300px" />
		  <div slot="footer">
            <Button type="default" @click="editModal=false">Close </Button>
            <Button type="primary"   @click="editTag()" :disabled="isEditing" :loading="isEditing">{{isEditing?'Editing ...' :' Edit tag'}}  </Button>

        </div>
    </Modal>

		<!-- Delete tag Modal -->
<!-- 
	   <Modal v-model="deleteModal" width="360">
        <p slot="header" style="color:#f60;text-align:center">
            <Icon type="ios-information-circle"></Icon>
            <span>Delete confirmation</span>
        </p>
        <div style="text-align:center">
            <p>Do u wanna delete the tag called {{deleteData.tagName}} </p>
           
        </div>
        <div slot="footer">
            <Button type="error" size="large" long :disabled="isDeleting" :loading="isDeleting" @click="deleteTag">Delete</Button>
        </div>
    </Modal> -->
	<deleteModal></deleteModal>


	
						
							


					</div>
				</div>
		

			</div>
		</div>
</template>

<script>
	import deleteModal from '../components/deleteModal';
    import { mapGetters} from 'vuex';


export default {

	data(){
		return{
			data:{
				tagName:''
			},
			addModal:false,
			editModal:false,
			isAding:false,
			isEditing:false,
			isDeleting:false,
			editData:{
				
				tagName:''
			},

			index:-1,

			tags:[],
			deleteData:{
				tagName:''
			},
			deleteModal:false

		}
	},

	methods:{
	async	addTag(){
		this.isAding=true
			if(this.data.tagName.trim()==''){

				return this.error('Oops','Tag name is required');

			}
				const res = await this.callApi('post','app/create_tag',this.data)
				if(res.status==201){
					this.tags.unshift(res.data)
					this.success('Done','Tag added succefuly')
					this.addModal=false
					this.data.tagName=''
				}
		this.isAding=false

			
		},
		async	editTag(){
			this.isEditing=true;
			if(this.editData.tagName.trim()==''){

				return this.error('Oops','Tag name is required');

			}
				const res = await this.callApi('post','app/edit_tag',this.editData)
				if(res.status==200){
					this.success('','Tag edited succefuly')
					this.tags[this.index].tagName=this.editData.tagName;
					this.editData.tagName='';
					this.editData.id=0;


				}
				this.editModal=false;
			this.isEditing=false;

				
			
		},
		
		// async	deleteTag(){
		// 		this.isDeleting=true;
			
		// 		const res = await this.callApi('post','app/delete_tag',this.deleteData)
		// 		if(res.status==200){
		// 			this.success('','Tag deleted succefuly')
		// 			this.tags.splice(this.deleteData.index,1)
		// 			this.deleteData.tagName='';
		// 			this.deleteData.id=0;
		// 			this.deleteData.index=-1;

		// 		}
		// 		this.deleteModal=false;
		// 		this.isDeleting=false;
			
		// },

		showEditModal(tag,i){

			let obj={
				'id':tag.id,
				'tagName':tag.tagName
			}
			this.editData=obj;
			this.index=i;
			this.editModal=true;
		},
		
		showDeleteModal(tag,i){

			const deleteModelObj= {
					data:tag,
					deleteUrl:'app/delete_tag',
					showDeleteModal:true,
					isDeleted:false,
					type:'tag',
					deleteIndex:i,
				}

           	 this.$store.commit('setDeleteModelObj',deleteModelObj)

				

				// this.deleteModal=true
				// this.$set(tag,'isDeleting',true)
				// let obj={
				// 	'tagName':tag.tagName,
				// 	'id':tag.id,
				// 	'index':i
				// }
				// this.deleteData=obj



		}

	},

	 computed:{
        ...mapGetters(['getDeleteModelObj','getTags'])
    },


	async created(){
				const res = await this.callApi('get','app/get_tags')
				if(res.status==200){
					this.tags=res.data;
					this.$store.commit('setTags',res.data)
					
				}

	},

	watch:{

		getTags(){
			this.tags=this.getTags
			
		}

		
	},
	components:{
		deleteModal
	}

}
</script>