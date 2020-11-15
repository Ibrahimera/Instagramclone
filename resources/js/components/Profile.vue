<template>
    <div class="all__contianer">
      <div class="container-sm d-flex justify-content-center align-items-center loading__container" v-if="error !='' || loading">
        <div class="p-5" v-if="error !=''">{{error}}</div>
        <div class="p-5" v-else><Spinner /> </div>
      </div>
      <div class="container-sm" v-else>
        <div class="body__cover" @click.self="showEditProfile =!showEditProfile" v-if="showEditProfile">
        <div class="profile__edit__modal">
         <h4 class="text-center">Edit profile</h4>
         <div class="form-group">
             <label>Name:</label>
             <input type="text" class="form-control" v-model="profile.name">
         </div>
         <div class="form-group">
             <label>Website:</label>
             <input type="text" class="form-control" v-model="profile.website">
         </div>
         <div class="form-group">
             <label>Description:</label>
             <textarea class="form-control" v-model="profile.description"></textarea>
         </div>
         <div class="form-group d-flex justify-content-between">
             <input type="file" class="form-control" id="profileImage">
             <img :src="profile.img" class="edit__profile__img" >
         </div>
         <div class="form-group">
             <button class="btn btn-sm btn-success" @click="saveProfile">Save</button>
             <button class="btn btn-sm btn-default ml-5" @click="showEditProfile =!showEditProfile">Cancel</button>
         </div>

        </div>
        </div>
        <!-- followers -->
        <div class="body__cover" @click.self="showFollow =!showFollow" v-if="showFollow">
        <div class="followers__modal">
            <div class="text-center">{{followTitle}}</div><span class="cancel cursor" @click="showFollow =!showFollow">x</span>

         <Avatar v-for="(foll,index) in follows" :key="index" :followText="foll.isFollow !=0?'Unfollow':'Follow'" :ausername="authuser[0]" v-on:follow="follow" :username="foll.username" :img="foll.img" />
        </div>
        </div>


        <!-- end followers -->

        <div class="body__cover" @click.self="createModal =!createModal" v-if="createModal">
        <div class="profile__edit__modal">
         <h4 class="text-center">Add new post</h4>

         <div class="form-group">
             <textarea placeholder="write a caption" class="form-control" v-model="caption"></textarea>
         </div>
         <div class="form-group">
             <input type="file" class="form-control" id="postImage">
         </div>
         <div class="form-group">
             <button class="btn btn-sm btn-success" @click="share">Share</button>
             <button class="btn btn-sm btn-default ml-5" @click="createModal =!createModal">Cancel</button>
         </div>

        </div>
        </div>


      <div class="post__container row col-md-10 offset-1 mb-4" v-if="showSinglePost">
        <div class="go__back" @click="showSinglePost = !showSinglePost" ><img class="w-100" src="/images/arrow-left.svg"></div>
          <div class="wide__post__image col-md-8">
              <img :src="posts[currentIndex].img" class="w-100 h-100">
          </div>
          <div class="side__post_container col-md-4">
            <Avatar :followText="followText" :ausername="authuser[0]" v-on:follow="follow" :username="username" :img="profile.img" />
           <hr>
           <div class="comments__container">
              <div class="d-flex align-items-center caption__container p-2 pb-3">
                <div class="mr-3">
                  <router-link class="nav-link text-dark" :to="'/'+username"> 
                    <img class="profile__image":src="profile.img">
                  </router-link>
                </div>
                <div>
                  <router-link class="nav-link text-dark" :to="'/'+username">
                    <strong>{{username}}</strong>
                  </router-link> {{posts[currentIndex].caption}}</div>
                <small class="post__time text-muted">{{posts[currentIndex]['time']}}</small>
              </div>
              <div v-for="(comment,index) in comments" class="d-flex align-items-center each__comment p-2">
                <div class="mr-3">
                  <router-link class="nav-link text-dark" :to="'/'+comment['username']"> 
                    <img class="profile__image" :src="comment['img']">
                  </router-link>
                </div>
                <div>
                  <router-link class="nav-link text-dark" :to="'/'+comment['username']">
                    <strong>{{comment['username']}}</strong>
                  </router-link>
                  <span>{{comment['comment']}}</span> 
                </div>
                <small class="comment__time text-muted">{{comment['time']}}</small>
                </div>
              </div>
              <div class="icon__container d-flex p-2">
                  <div class="mr-4">
                    <img v-if="authuser[0] !=''" :src="likeImage(currentIndex)" class="cursor" @click="toggleLike($event,posts[currentIndex].id)" >
                    <router-link class="text-dark" v-else to="/login"> <img :src="likeImage(currentIndex)" class="cursor"></router-link>
                  </div>
                  <div class="mr-4"><img src="/images/comment.svg"></div>
                  <div class="mr-4"><img src="/images/send.svg"></div>
              </div>
              <div class="like__count pl-2 cursor" @click="getlikes(posts[currentIndex].id)"><strong>{{posts[currentIndex].like}}</strong> {{posts[currentIndex].like <2 ?'like':'likes'}}</div>
                <div v-if="authuser[0] !=''" class="add__comment d-flex justify-content-between p-2">
                    <input class="py-2" @keyup.enter="addComment(posts[currentIndex].id)" type="text" placeholder="Add a comment..." v-model="newComment">
                    <button class="btn btn-sm btn-default" @click="addComment(posts[currentIndex].id)">Post</button>
                </div>
          </div>
      </div>








    <div class="row profile__container" v-if="!showSinglePost" >
        <div class="profile__image__container p-5 col-md-4">
            <img :src="profile.img" class="rounded-circle">
        </div>
        <div class="profile__details p-5 col-md-8">
            <div class="d-flex align-items-center mb-2">
               <div class="font-weight-bold mr-5">{{username}}</div> 
               <button v-if="username !=authuser[0] && authuser[0] !=''" class="btn btn-sm btn-primary" @click="follow(username,$event)">{{followText}}</button><button v-else-if="authuser[0] !=''" class="btn btn-sm btn-default" @click="showEditProfile=!showEditProfile" >Edit profile</button>
               <router-link v-else to="/login" class="btn btn-sm btn-primary">Follow</router-link>
            </div>
            
            <div class="d-flex  align-items-center ">
                <div class="mr-4" @click="test" v-html="postCount"></div>
                <div class="mr-4 follow" v-html="followerCount" @click="getFollow('Followers')"></div>
                <div class="mr-4 follow" v-html="followingCount" @click="getFollow('Following')"></div>
            </div>
            <div class="mt-3"><strong>{{profile.name}}</strong></div>
            <div>
               {{profile.description}}
            </div>
            <div>
                <a :href="profile.website">{{profile.website}}</a>
            </div>
        </div>
    </div>
    <!-- add create functionality -->

     <div v-if="!createModal && authuser[0] !=''&& authuser[0]==username" class="add__post text-center mt-2">
         <div v-if="!showSinglePost" class="add__post__btn" @click="createModal=!createModal">
             <img src="/images/plus.svg">
         </div>
     </div>


     <!-- end of create modal -->
        <div class="row mt-3" v-if="!showSinglePost && !showEditProfile && !createModal ">
        <div v-for="(post,index) in posts" :key="post.id" class="col-md-4 one__post my-2">
          
          <div class="post__img__container">
            <img :src='post.img_thumbnail' class="w-100">
            <div class="d-flex justify-content-center align-items-center post__overlay" @click="goToPost(post.id,index)">
            <div class="post__icon mr-4" ><img  :src="likeImage(index)"><strong class="ml-1">{{post.like}}</strong></div>
            <div class="post__icon ml-4"><img src="/images/comment.svg"><strong class="ml-1">{{post.comment}}</strong> </div>
        </div> 
        </div>
          
        </div>
        </div>
    </div>
  </div>
</template>

<script>

    import Avatar from './Avatar.vue'
    import {mapState,mapActions} from 'vuex'
    import Spinner from 'vue-simple-spinner'
    export default {
        name: 'profileContainer',
        components: {
         Avatar,
         Spinner
        },
        data(){
            return{
              profile:[],
              posts:[],
              user:[],
              likes:[],
              comments:[],
              createModal:false,
              likeModal:false,
              dataLikeModal:[],
              frcount:0,
              fgcount:0,
              isFollow:null,
              currentIndex:0,
              showSinglePost:false,
              liked:null,
              newComment:'',
              caption:'',
              showEditProfile:false,
              showFollow:'',
              showTitle:'',
              username:'',
              error:'',
              loading:true,
            }
        },
        methods:{
          ...mapActions(['getUser']),
           getlikes(pId){
            this.followTitle="Likes"
             axios.get(`/like/${pId}`).then(response=>{
                this.follows=response.data;
                this.showFollow=true;

               console.log(response.data);
             })
           },
            toggleLike(event,pId){
           let post=this.posts[this.currentIndex];
           let like=this.liked[this.currentIndex];
           axios.post(`/like/all`,{pId}).then(response=>{
            
              if(response.data !=0){
                 post['like']=post['like'] + 1;
                 like=1;
                }else{
                 like=0;
                 post['like']=post['like'] - 1;
                }
                this.posts=this.posts.map(p=>{
                    if(p.id==post.id){p= post}return p;
                });
                this.liked=this.liked.map((item,i)=>{
                    if(i==this.currentIndex){item=like} return item;
                })
                
           });
            },

            share(){
             this.createModal=false;
             let caption=this.caption,response;
             let file=document.getElementById('postImage').files[0];
             let post=new FormData();
             post.append('caption',caption);
             post.append('img',file);
             $.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}})
             $.ajax({url:"/post/all",
                type:"POST",
                data:post,
                contentType:!1,
                processData:!1,
                success:function(e){e.time="now";insert(e)},error:function(){}
            });
             
            const insert=(data)=>{this.posts=[data,...this.posts]}

            },
            openLikeModal(index){
              this.likeModal= !this.likeModal
              this.dataLikeModal=this.likes[index]
              console.log(this.dataLikeModal);

            },
            follow(username,event){
                 let el=event.target;
                 el.disabled=true;
                let btnText=el.innerText;
                el.innerText=btnText !="Follow" ? "Follow":"Unfollow";
                if(username==this.username){this.isFollow=!this.isFollow}
              axios.get(`/follow/all/${username}`).then(response=>{

                     if(this.authuser[0]==username){
                    // update following
                      this.fgcount= btnText !="Follow" ? this.fgcount - 1:this.fgcount + 1;
                    }else{
                     this.frcount= btnText !="Follow" ? this.frcount - 1:this.frcount + 1;
                    }el.disabled=false})
            },
            goToPost(pId,index){
                axios.get(`/comment/${pId}`).then(response=>{
                   this.comments=response.data;
                });
                this.currentIndex=index;
                this.showSinglePost=!this.showSinglePost;



            },
            addComment(pId){
              let msg=this.newComment;
              let post=this.posts[this.currentIndex];
              axios.post(`/comment/all`,{pId,msg}).then(response=>{
                this.newComment='';
                let comment=response.data;
                comment['img']=this.authuser[1];
                this.comments=[...this.comments,comment]
                post['comment']=post['comment'] + 1;
                this.posts=this.posts.map(p=>{
                    if(p.id==post.id){p=post}return p;
                })
                this.$nextTick(function(){let container=document.querySelector('.comments__container')
                 container.scrollTop=container.scrollHeight});

              });
            },
            likeImage(index){
             return this.liked[index] !=0 ?'/images/heartred.svg':'/images/heart.svg'

            },
            saveProfile(){
              let app=this;
              this.showEditProfile=false;
              let profile=this.profile;
              console.log(profile);
             let file=document.getElementById('profileImage').files[0];
             let data=new FormData();
             data.append('name',profile.name);
             data.append('website',profile.website);
             data.append('description',profile.description);
             data.append('id',profile.id);
             if(file){data.append('img',file);}
             $.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}})
             $.ajax({url:`/profile/${this.username}`,
                type:"POST",
                data:data,
                contentType:!1,
                processData:!1,
                success:function(data){if(data !=0){profile['img']=data;app.getUser([app.username,data]);}this.profile=profile},error:function(){}
            });
            },
            getFollow(text){
                this.followTitle=text
                let id=this.profile.id;
                let param={id,text}
                axios.post('/follow/all',{param}).then(response=>{
                let data=response.data;
                this.follows=data;
                this.showFollow=true;

                });



            },
            test(){
                axios.get(`/like/1`).then(response=>{
                  let data=response.data;
                  console.log(data);
                  
                });
            }
        },
        created() {
           let username=this.$route.params.username;
           this.username=username
           axios.get(`/${username}`).then(response=>{
            let data=response.data;
            this.loading=false;
            this.posts=data.posts;
            this.profile=data.profile;
            this.user=data.user;
            this.liked=data.liked;
            this.isFollow=data.isFollow;
            this.frcount=data.profile['follower'];
            this.fgcount=data.profile['following'];
           
           }).catch(error=>{if(error.response.status==404){this.error=`The user ${this.username} does not exist`}});
        },
        computed:{
          ...mapState(['authuser']),
            postCount(){
                 let len=this.posts.length,post=len < 2 ? 'post' : 'posts';
                 return `<strong>${len}</strong> ${post}`;
            },
            followerCount(){
                 let len=this.frcount || 0,follower=len < 2 ? 'follower' : 'followers';
                 return `<strong>${len}</strong> ${follower}`;
                 
                
            },
            followingCount(){
                 let len=this.fgcount || 0,follow=len < 2 ? 'following' : 'followings';
                 return `<strong>${len}</strong> ${follow}`;
                 

            },
            howManyLikes(){
                let len=this.likes.length,text='';
                if(len >0){text= len !=1 ? len+" likes":"1 like"}
                return text;
            },
            followText(){return this.isFollow !=1 ? "Follow" : "Unfollow";},
            
            
        }
    }
</script>

<style>
  div.loading__container{
     height: 70vh;
  }
  .container-sm{
    margin-top:40px;
   }
    a.nav-link{
      padding:0 !important;
      display: inline-block !important;
    }
    .cursor{
        cursor: pointer;
    }
    .cursor:hover{
      color:#6b6767;
    }
    div.follow{
        cursor: pointer;
    }
    div.first{
        width: 50%;
    }
     div.profile__edit__modal,div.followers__modal{
        width: 400px;
        position: absolute;
        top:50%;
        left:50%;
        transform: translate(-50%,-50%);
        background-color: #fff;
        padding:12px;
        z-index: 100;
     }
     div.followers__modal{
        width: 350px;
     }
     span.cancel{
      position: absolute;
      top: 0px;
      right: 12px;
      z-index: 20;
     }
     .edit__profile__img{
        width: 150px;
     }
     div.body__cover{
        position: absolute;
        width: 100vw;
        height: 100vh;
        top:0;
        left: 0;
        background: rgb(128 128 128 / 33%);
        z-index: 50;
     }
    .container{
        margin:0 auto;
    }
    div.add__comment{
        border-top:1px solid #c1bfbf;
    }
    div.add__comment input{
        border:none;
        outline:none;
        font-size: 12px;
        width: 75%;
    }
     div.icon__container img{
        width: 22px;
     }
     div.post__container{
        background-color: #fff;
        padding-left: 0;
        height: auto;
        font-size: 14px;
        box-shadow: 0px 0px 5px 1px #d4d4d4;
        margin-top:70px;

     }
     div.post__img__container{
        position: relative;
     }

     div.comments__container{
        overflow-y: auto;
        height: 70%;
        border-bottom: 1px solid #c1bfbf;
     }
     div.caption__container{
      border-bottom: 1px solid #c1bfbf;
     }
     div.each__comment,.caption__container{
      position: relative;
     }
     small.comment__time,small.post__time{
        position: absolute;
        bottom: -6px;
        left: 22%;
     }
     small.post__time{bottom: 1px}
     div.profile__container{
        border-bottom: 1px solid lightgray;
     }
     div.profile__image__container img{
        width: 150px;
     }
     
     div.post__overlay{
        background: rgb(121 119 119 / 41%);
        position: absolute;
        cursor: pointer;
        top:0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
     }

     div.post__icon{
    color:white;
    cursor:pointer;
    }
    div.post__icon img{
      width:35px;
    }

    div.one__post:hover div.post__overlay{
        opacity: 1;
     }

    .like__modal{
    background-color: #fff;
    position: fixed;
    width: 300px;
    box-shadow: 0px 0px 5px 1px #d4d4d4;
    top: 20%;
    left: 50%;
    transform: translate(-50%, 10px);
    z-index: 100;
    }

    .profile__image{
        width: 36px !important;
        height: 36px !important;
        border-radius: 100%;
    }
    .count__likes{
        cursor: pointer;
    }
    .close__create__modal{
    position: absolute;
    top: -15px;
    right: -15px;
    border: 1px solid gray;
    width: 23px;
    height: 23px;
    border-radius: 100%;
    cursor: pointer;
    text-align: center;
}
 div.go__back{
        position: absolute;
    top: 6px;
    left: 13px;
    width: 20px;
    height: 20px;
    z-index: 100;
    cursor: pointer;
    background: white;
    padding: 4px;
    line-height: 2px;
 }

 div.wide__post__image{
    padding:0;
    height: 630px;
    border-right: 1px solid lightgray;
 }

 @media(min-width: 600px){
    div.post__container{
    }
 }

</style>