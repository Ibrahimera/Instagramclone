import Home from './components/Home.vue'
import Profile from './components/Profile.vue'
import Login from './components/Login.vue'
import Register from './components/Register.vue'

export default[
   
      {
      	path:'/',
        component:Home,
        name:"home"
      },
      
      {
      	path:'/login',
        component:Login,
        name:"login"
      },
      {
      	path:'/register',
        component:Register,
        name:"register"
      },
      {
      	path:'/:username',
        component:Profile,
        name:"profile"
      },

];