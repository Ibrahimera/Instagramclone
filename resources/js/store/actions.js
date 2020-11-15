export default{
	getUser:({commit},payload)=>{
		commit('getUser',payload);
	},
	resetAuth:({commit})=>{
		commit('resetAuth');
	}
}