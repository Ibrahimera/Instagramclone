<template>
	<div>
		<div class="container-sm">
        <div class="col-md-8 offset-2">
            <div class="card">
                <div class="card-header text-center">Login</div>

                <div class="card-body">
                  <div class="col-md-6 offset-3 error__container">
                    <div v-if="error" class=" alert alert-danger">{{error}}</div>
                   </div>
                    <form  @submit.prevent="submit">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input v-model="email" type="email" class="form-control" @focus="clearError" required autocomplete="email" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input  type="password" class="form-control" @focus="clearError" v-model="password" required autocomplete="current-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="checked">

                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button  class="btn btn-primary">
                                    Login
                                </button>

                                
                                    <router-link class="btn btn-link" to='/password/request'>
                                        Forgot Your Password?
                                    </router-link>
                                    <div class="mt-2">Dont have account <router-link to="/register" class="btn btn-sm btn-secondary ml-1">Signup</router-link></div>
                               
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
    import {mapActions,mapState} from 'vuex'
	export default{
		name:"Login",
		components:{
		},
		data(){
			return{
              email:'',
              password:'',
              checked:false,
              error:null,
			}
		},
		methods:{
            ...mapActions(['getUser']),
			submit(){
				let email=this.email
				let password=this.password
				let remember=this.checked
				axios.post('/login/all',{email,password,remember}).then(response=>{
                 this.getUser(response.data);
                 this.$router.push('/'+this.authuser[0]);
				}).catch(err=>{this.error=null;this.error=err.response.data.error})
			},//
            clearError(){this.error=null}
		},
        computed:{
            ...mapState(['authuser']),
            
        }

	}
</script>
<style  scoped >
	div.container-sm{
		margin-top:90px;
	}
</style>