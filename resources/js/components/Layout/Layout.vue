<template>
    <div>

        <Sidebar></Sidebar>
        <div class="main-content" id="panel">
                <router-view></router-view>
         </div>
    </div>
</template>

<script>

import Sidebar from "./Sidebar";
import Footer from "./Footer";
export default {
    name: "Layout",
    components: {Footer, Sidebar},
    data(){
        return{
            name:'',
            email: '',
        }
    },
    methods:{

        getUserInfo(){
            this.axios.get("api/v1/get/user/info")
                .then(response => {
                    let item = response.data.data.original.data;
                    this.name = item.name;
                    this.email = item.email;
                })
                .catch(error => {
                    console.log(error.response.data)
                })
        }
    },
    beforeMount() {
        this.axios
        .get('api/v1/auth/check')
        .then(response => {
        })
        .catch(error => {
            if (error.response.data.status === false){
                window.location.href = '/login';
            }
        })
    },
    mounted() {
        this.getUserInfo();
    }
}
</script>

<style scoped>
 .fade {
     transition: opacity .15s linear;
 }
.alert-dismissible {
    padding-right: 3.85rem;
}
.alert {
    position: relative;
    padding: 0.75rem 1.25rem;
    margin-bottom: unset;
    border: unset;
    border-radius: unset;
    margin-left: 250px !important;
}
 @media (max-width: 1199.98px){
     .alert {
         margin-left: 0px !important;
     }
 }
 .spinner-border {
     width: 1rem;
     height: 1rem;
 }
</style>
