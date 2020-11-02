<template>
    <div class="container" >
        <div >
         <Card  class="container2" >
             <h1 >Sign in</h1>
             	<Input type="email" class="add-input-user" v-model="authData.email" prefix="ios-at-outline"   placeholder="Email"  />
			<Input type="password" class="add-input-user" v-model="authData.password" prefix="md-key"  placeholder="Password"  />
            <Button type="success" @click="login" :disabled="isLogin" :loading="isLogin">Login </Button>

        <div slot="footer">

        </div>
       
        
    </Card>
        </div>
    </div>
</template>

<style scoped>
.container2{
    margin:0 auto;
    margin-top:150px ;
    width:350px;
    text-align: center;
}
</style>

<script>
export default {

    data(){
        return{
            authData:{
                email:'',
                password:''
            },
            isLogin:false
        }
    },
    methods:{
      async  login(){
            // if(this.authData.email.trim()=='' || this.authData.password.trim()=='')
            // {
            //    return  this.error('Oups','Email and password are required')

            // }

                this.isLogin=true;

            	const res = await this.callApi('post','app/login',this.authData)
				
				if(res.status==200){
					// this.users.unshift(res.data)
                    this.success('Done','Logged  succefuly')
                    window.location='/home'
					// this.addModal=false
					// this.data.tagName=''
				}
				else{
					if(res.status==422){
					for(let i in res.data.errors){
						 this.error('Oops',res.data.errors[i]);
					}
					}
					if(res.status==500){
						 console.log(69)
						 this.error('Oops',res.data.errors[0]);
                    }
                    if(res.status==401){
						 console.log(69)
						 this.error('Oops',res.data.msg);
					}
		      
                }
                this.isLogin=false;
                

            
        }

    }
    
}

</script>