<template>
	<div class="d-flex align-items-center justify-content-between p-2">
	  <div class="d-flex align-items-center">
	  	<div class="mr-4">
	      <router-link class="nav-link text-dark"  :to="'/'+username"> 
	        <img class="profile__image" :src="img">
	      </router-link>
	    </div>
	      <router-link class="nav-link text-dark" :to="'/'+username" ><strong>{{username}}</strong></router-link>
	  </div >
	  
	  <div class="ml-4">
	      <div class="pl-2">
	      	<button v-if="username !=ausername && ausername !=''" class="btn btn-sm btn-primary" @click="$emit('follow',username,$event)">{{followText}}</button>
	      	<router-link v-if="ausername==''" class="btn btn-sm btn-primary" to="/login">Follow</router-link>
	      </div>
	  </div>
	</div>
</template>
<script>
	
	export default{
		name:"Avatar",
		props:{
          ausername:String,
          username:String,
          followText:String,
          img:String,
		},
	}
</script>