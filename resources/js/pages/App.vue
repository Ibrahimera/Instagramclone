<template>
	<div>
		<Navbar :user="authuser" v-on:logout="logout" /> 
		<router-view />
	</div>
</template>
<script>
	 import Navbar from '../components/Navbar.vue'
	 import {mapActions,mapState} from 'vuex'
	export default{
		name:"app",
		components:{
			Navbar
		},
		data(){
			return{
              
			}
		},
		methods:{
			...mapActions(['getUser','resetAuth']),
          init(){
          	axios.get('login/all').then(response=>{
          		console.log(response.data);
            this.getUser(response.data);
          });
          },
          logout(){
             axios.get('/logout/all',{id:1})
            .then(response=> {
              this.resetAuth()
              this.$router.push('/');
            });
           },

		},
		mounted(){
          this.init();
          
		},
		computed:{
			...mapState(['authuser'])
		}

	}
</script>