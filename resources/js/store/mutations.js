export default{
	getUser:(state,payload)=>{
      state['authuser']=payload;
	},
	resetAuth:(state)=>{
      state['authuser']=['',''];
	}
}