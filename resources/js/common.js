import Axios from "axios"

export default {
	data(){
        return{

        }
    },
    methods:{
        callApi(methode,url,dataO){

            try {
                return axios({
                    method: methode,
                    url: url,
                    data: dataO
                  }).catch(error => {

                    return error.response
                    
                  })
            } catch (error) {
                console.error(error.response.data.errors);
                return error.response ;
            }
           
        },
        info (title,desc) {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        success (title,desc) {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        warning (title,desc) {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        error (title,desc) {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },

        errorDefault (title='Oops',desc='Something went wrong , Please try again .. ') {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        }
    }
    
}