<template>
    <div class="content">
			<div class="container-fluid">
				
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Users  <Button @click="addModal=true"><Icon type="md-add" /> Add User</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr >
								<th>ID</th>
								<th>Full name</th>
								<th>Email</th>
								<th>Role </th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
									<tr v-for="(user,i) in users " :key="i" :v-if="users.length">
								<td>{{user.id}}</td>
								<td><strong> {{user.fullName}}</strong></td>
								<td>{{user.email}}</td>
								<td>{{user.userType}}</td>
								<td>{{user.created_at}}</td>
								<td>
									<Button type="info" @click="showEditModal(user,i)">Edit</Button>
   
   									 <Button type="error" @click="showDeleteModal(user,i)" >Delete</Button>
									
								</td>
							</tr>
						</table>
							
								<!-- add user Modal -->
				<Modal
				v-model="addModal"
				title="Add User"
				:mask-closable="false"
				:closable="false"
				style="width: 400px;"
			
			>
			<div class="space" >
			<Input type="text" class="add-input-user" prefix="md-person" v-model="data.fullName" placeholder="Full name" />
			<Input type="email" class="add-input-user" prefix="ios-at-outline"  v-model="data.email" placeholder="Email"  />
			<Input type="password" class="add-input-user" prefix="md-key" v-model="data.password" placeholder="Password"  />
			<Select class="add-input-user" placeholder="Role"  prefix="logo-steam" v-model="data.userType" >
            <Option  value="Admin" default >Admin</Option>
            <Option  value="Editor" >Editor</Option>
            </Select>
			
		</div>
			
				<div slot="footer">
					<Button type="default" @click="addModal=false">Close </Button>
					<Button type="primary"   @click="addUser" :disabled="isAding" :loading="isAding">{{isAding?'Adding ...' :' Add User'}}  </Button>

				</div>
			</Modal>

						<!-- edit user Modal -->
		<Modal
        v-model="editModal"
        title="Edit User"
		:mask-closable="false"
		:closable="false"
       >
	  <div class="space" >
			<Input type="text" class="add-input-user" prefix="md-person" v-model="editData.fullName" placeholder="Full name" />
			<Input type="email" class="add-input-user" prefix="ios-at-outline"  v-model="editData.email" placeholder="Email"  />
			<Input type="password" class="add-input-user" prefix="md-key" v-model="editData.password" placeholder="Password"  />
			<Select class="add-input-user" placeholder="Role"  prefix="logo-steam" v-model="editData.userType" >
            <Option  value="Admin" default >Admin</Option>
            <Option  value="Editor" >Editor</Option>
            </Select>
	  </div>
		  <div slot="footer">
            <Button type="default" @click="editModal=false">Close </Button>
            <Button type="primary"   @click="editUser()" :disabled="isEditing" :loading="isEditing">{{isEditing?'Editing ...' :' Edit user'}}  </Button>

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
				fullName:'',
				email:'',
				password:'',
				userType:'',
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

			users:[],
			deleteData:{
				fullName:'',
				email:'',
				password:'',
				userType:'',
			},
			deleteModal:false

		}
	},

	methods:{
	async	addUser(){
		this.isAding=true
			if(this.data.fullName.trim()=='' || this.data.email.trim()=='' || this.data.password.trim()=='' || this.data.userType.trim()==''){

				console.log(this.data.userType)
				this.isAding=false
				return this.error('Oops',' All data are  required');

			}
				const res = await this.callApi('post','app/create_user',this.data)
				
							

				if(res.status==201){
					this.users.unshift(res.data)
					this.success('Done','User added succefuly')
					this.addModal=false
					this.data.tagName=''
				}
				else{
					if(res.status==422){
					for(let i in res.data.errors){
						 this.error('Oops',res.data.errors[i]);
					}
					}
					if(res.status==500){
						 console.log(69)
						 this.error('Oops','Email already used');
					}
		        this.isAding=false
				}
				
				
				
		this.isAding=false

			
		},

		async	editUser(){
			this.isEditing=true;
			if(this.editData.fullName.trim()=='' || this.editData.email.trim()=='' ){
			this.isEditing=false;

				return this.error('Oops','Email or name is missing');

			}
				const res = await this.callApi('post','app/edit_user',this.editData)
				
				if(res.status==200){
					this.success('','User edited succefuly')
					this.users[this.index].fullName=this.editData.fullName;
					this.users[this.index].email=this.editData.email;
					let obj={
					fullName:'',
						email:'',
						password:'',
						userType:'',
					}

					this.editData.tagName=obj;
					this.index=-1;
				}
				else{
					if(res.status==422){
					for(let i in res.data.errors){
						 this.error('Oops',res.data.errors[i]);
					}
			this.isEditing=false;

					return true
				}
				if(res.status==500){
						 console.log(69)
						 this.error('Oops','Email already used');
						 this.isEditing=false;

					return true
					}
				 }

				this.editModal=false;
			this.isEditing=false;

				
			
		},
		

		showEditModal(user,i){

			let obj={
				id:user.id,
				fullName:user.fullName,
				email:user.email,
				password:'',
				userType:user.userType,
			}
			this.editData=obj;
			this.index=i;
			this.editModal=true;
		},
		
		showDeleteModal(user,i){

			const deleteModelObj= {
					data:user,
					deleteUrl:'app/delete_user',
					showDeleteModal:true,
					isDeleted:false,
					type:'user',
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
        ...mapGetters(['getDeleteModelObj','getUsers'])
    },


	async created(){
				const res = await this.callApi('get','app/get_users')
				if(res.status==200){
					this.users=res.data;
					this.$store.commit('setUsers',res.data)
				}

	},

	watch:{

		getUsers(){
			this.users=this.getUsers
			
		}
	},

	components:{
		deleteModal
	}

}
</script>