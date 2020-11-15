<template>
	<div>
		<Navbar :user="authuser" />
		<div class="container-sm">
        <div class="col-md-8 offset-2">
            <div class="card">
                <div class="card-header text-center">Register</div>

                <div class="card-body">
                    <div class="col-md-6 offset-3 error__container">
                    <ul v-if="errors" class=" alert alert-danger">
                        <li v-for="(error,name,index) in errors" :key="index">{{error[0]}}</li>
                    </ul>
                   </div>
                    <form  @submit.prevent="submit"> 

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input v-model="name" type="name" class="form-control" @focus="cleanError" required  autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

                            <div class="col-md-6">
                                <input v-model="username" type="username" class="form-control" @focus="cleanError" required  autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input v-model="email" type="email" class="form-control" @focus="cleanError" required  autofocus>
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input  type="password" class="form-control" @focus="cleanError" v-model="password" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="confirmPassword" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                            <div class="col-md-6">
                                <input  type="password" class="form-control" @focus="cleanError" v-model="confirmPassword" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button  class="btn btn-primary">
                                    Register
                                </button>
                               
                            </div>
                        </div>
                    </form>
                </div>
            </div>
		</div>
	</div>
</div>
</template>

<script>
	import Navbar from './Navbar.vue'
    import {mapState,mapActions} from 'vuex'
	export default{
		name:"Register",
		components:{
          Navbar
		},
		data(){
			return{
			  name:'',
			  username:'',
              email:'',
              password:'',
              confirmPassword:'',
              errors:null,
			}
		},
		methods:{
            ...mapActions(['getUser']),
			submit(){
				let name=this.name
				let username=this.username
                let email=this.email
                let password=this.password
                let confirmPassword=this.confirmPassword
				if(password !=confirmPassword){this.errors={password:['Confirm password do not match']};return false;}
				axios.post('/register',{name,email,password,username}).then(response=>{
                    let payload=[username,'/storage/uploads/profiles/user.svg'];
                   this.getUser(payload);
                   this.$router.push('/'+username);
				}).catch(err=>{this.errors=null;this.errors=err.response.data.errors})
			},
            cleanError(){this.errors=null},
			

		},
        computed:{
            ...mapState(['authuser'])
        }

	}
</script>
<style  scoped >
	div.container-sm{
		margin-top:90px;
	}
</style>