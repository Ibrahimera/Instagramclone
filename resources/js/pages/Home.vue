<template>
  <div class="home__container">
    
    <div class="container-sm py-4">
      
        <div class="row">
        <div class="suggested__post col-md-8">
            <div v-for="(user,index) in usersPost" :key="index" class="row__suggested__post"> 
             <Avatar followText="" :ausername="user.username" v-on:follow="follow" :username="user.username" :img="user.img" />
             <div>
              <img class="row__post__img w-100" :src="posts[index].img">
              <div class="p-2">{{posts[index].caption}}</div>
            </div>
            </div>
              
        </div>
        <div class="suggested__profile col-md-4">
            <Avatar v-for="(user,index) in users" :key="index" :followText="followText(user.isFollow)" :ausername="authuser[0]" v-on:follow="follow" :username="user.username" :img="user.img" />  
        </div>
       </div>
    </div>
  </div>
</template>

<script>
    import Avatar from '../components/Avatar'
    import {mapState} from 'vuex'
   
    export default {
        name:"Home",
        components:{
         Avatar,
        },
        data(){
           return{
                users:[],
                posts:[],
                usersPost:[],
           }
        },
        methods:{
          follow(username,event){
                 let el=event.target;
                 el.disabled=true;
                let btnText=el.innerText;
                el.innerText=btnText !="Follow" ? "Follow":"Unfollow";
              axios.post('/follow/all',{username}).then(response=>{
              el.disabled=false})
            },

            followText(isFollow){let text= isFollow !=1 ? "Follow" : "Unfollow"; return text;},
        },
        mounted() {
            axios.post('/',{name:1}).then(response=>{
                let data=response.data;
                console.log(data);
                this.users=data.users
                this.posts=data.posts
                this.usersPost=data.usersPost
            });
        },
       computed:{
         ...mapState(['authuser'])
       }
    }
</script>

<style scoped>
   .container-sm{
    margin-top:40px;
   }
    div.suggested__post{
        padding:0 !important;
    }
    div.row__suggested__post{
      box-shadow: -1px 0px 2px 1px #d4d4d4;
      margin-bottom: 30px;
    }
    div.suggested__profile{
            box-shadow: 1px 0px 1px 1px #dcdcdc;
    }
</style>
