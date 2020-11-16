import Home from './pages/Home.vue'
import Profile from './pages/Profile.vue'
import Login from './pages/Login.vue'
import Register from './pages/Register.vue'

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