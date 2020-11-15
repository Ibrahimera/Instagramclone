<template>
	        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
            <div class="light__body__cover" @click.self="showActivity=false;showSearchModal=false" v-if="showActivity || showSearchModal "></div>
            <div class="container">
                <div class="logo__container">
                     <router-link class="navbar-brand " to="/">NewApp</router-link>
                </div>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <div class="search__container">
                        <input ref="input" class="form-control"  v-model="query" type="text" >
                        <div :class="[!showSearchModal?'overlay':'d-none']" @click="focus">
                        	<img src="/images/search.svg" class="search__icon mr-2"><span>Search</span>
                        </div>
        <!-- followers -->

        <div class="search__modal" v-if="showSearchModal">
          <div v-for="(result,index) in results" :key="index" class="d-flex align-items-center mb-3 pl-2 pr-2">
              <div class="mr-4">
                <router-link class="nav-link" :to="'/'+result.username"><img  class="profile__image" :src="result.img"></router-link></div>
              <div><router-link class="nav-link" :to="'/'+result.username">{{result.username}}</router-link></div>
          </div>
          <div class="text-center alert alert-danger" v-if="notFound !=''">{{notFound}}</div>

        </div>



        <!-- end followers -->
                    </div>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto d-flex align-items-center">
                        <!-- Authentication Links -->
                        
                            <li class="nav-item mr-3">
                                <router-link to="/" class="nav-link" ><img class="home__icon" src="/images/home.svg"></router-link>
                            </li>
                            
                                <li class="nav-item mr-3">
                                    <!-- <router-link class="nav-link" to="/activity">Register</router-link> -->
                                    <div v-if="user[1] ==''" class="cursor activity__icon">
                                      <router-link to="/login"><img class="w-100" src="/images/heart.svg"></router-link>
                                       
                                    </div>
                                    <div v-else class="cursor activity__icon" @click="getActivity" >
                                      <img class="w-100" src="/images/heart.svg">
                                        <div class="activity__modal" v-if="showActivity">

                                          <div v-for="(activity,index) in activities" :key="index" class="d-flex align-items-center mb-3 pl-2 pr-2">
                                              <div class="mr-4">
                                                <router-link class="nav-link " :to="'/'+activity['username']">
                                                 <img class="profile__image" :src="activity['img']">
                                                </router-link>
                                              </div>
                                              <div>
                                                <router-link class="nav-link " :to="'/'+activity['username']">
                                                  <strong>{{activity['username']}}</strong> <span>{{activity['msg']}}</span>
                                                </router-link>
                                                
                                                
                                              </div>
                                          </div>
                                          <div class="text-center alert alert-danger" v-if="noActivity !=''">{{noActivity}}</div>

                                        </div>
                                    </div>
                                </li>
                           
                            <li class="nav-item" v-if="user[1]==''"><router-link to="/login">Login</router-link></li>
                            <li class="nav-item dropdown mr-3" v-else>
                                <a id="navbarDropdown" class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="profile__image mr-3" :src="user[1]">
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a  class="dropdown-item cursor" @click.prevent="$emit('logout')">
                                        logout
                                    </a>
                                    <a class="dropdown-item" href="#" @click.prevent="profile" >
                                        Profile
                                    </a>

                                    
                                </div>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>
</template>
<script>
	export default{
		name:'Navbar',
		props:['user'],
    components:{
    },

		data(){
			return{
              query:'',
              showSearchModal:false,
              results:[],
              notFound:'',
              noActivity:'',
              showActivity:false,
              activities:[],
			}
		},
		methods:{
           profile(){
            this.$router.push('/'+this.user[0]);
           },
           getActivity(){
            this.showActivity=true
              axios.get('/activity/all')
            .then(response=> {
              let data = response.data
              console.log(data);
              if(data.length !=0){this.activities=data;this.noActivity=""}else{this.noActivity="No activity"}
            })
           },
           searchAction(){
           	this.query=="" ? this.blur=false:''
           	console.log(this.query);
           },
           focus(){
            this.showSearchModal=true
            this.$refs.input.focus()

           },
           blurAction(){
           	this.blur=true
           },
           getResult(){
		      let query=this.query
		      this.results=[]
		      this.notFound=''
		      if(query ==""){return false}
		      axios.get(`/search/${query}`)
		        .then(response=> {
		          let data = response.data
		          if(data.length !=0){this.results=data;this.notFound=""}else{this.notFound="No result found"}
		        })
		     }
		},
		computed:{
             
		},
		mounted() {
            console.log(this.user);
        },
        watch: {
			// whenever question changes, this function will run
			query: function (newQuestion, oldQuestion) {
			this.debouncedGetAnswer()
			    }
          },

          created(){
          	this.debouncedGetAnswer = _.debounce(this.getResult, 500)
          }
	}
</script>

<style scoped>
  div.light__body__cover{
    position: absolute;
    height: 1139px;
    width: 100vw;
    background: #bfbebe00;
    z-index: 80;

  }
  .home__icon,.activity__icon{
  	width: 27px;
    position: relative;
  }
  div.search__modal,div.activity__modal{
		position: absolute;
		background: #fff;
		z-index: 120;
		top: 44px;
		width: 250px;
		box-shadow: 0px 0px 5px 1px #d4d4d4;
		min-height: 200px;
		max-height: 500px; 
		padding: 10px;
    overflow-y: auto;
		border-radius: 5px;
  }
  div.activity__modal{
    right: -120px;
  }
  div.activity__modal::before{
    content: "";
    position: absolute;
    top: -15px;
    right: 114px;
    display: inline-block;
    width: 20px;
    background: white;
    height: 17px;
    box-shadow: -1px -1px 3px 0px #d4d4d4;
    z-index: -1;
    border-radius: 4px 73px 0 0;

  }
	div.logo__container{
		width: 33%;
	}
	img.search__icon{
		width: 15px;
	}

	div.search__container{
		width: 250px;
		position: relative;
	}
	div.overlay{
		width: 100%;
	    height: 100%;
	    background-color: #e6e4e454;
	    border-radius: 5px;
	    position: absolute;
	    left: 0;
	    top: 0;
	    z-index: 100;
	    text-align: center;
	    line-height: 35px;
	    color: #848484;
	    cursor: pointer;
		
	}
</style>