<template>
    <div style="margin:20%;"> <H1>La valeur est   : {{count}} </H1> 
    <button @click="incrementer(1)">Incrementer</button>
    <button @click="incrementer(-1)">Décrementer</button>

    <br/>
    <br/>
    <br/>
    <div v-for="(blog,i) in blogs" :key="i" v-if="show">
        <H2>Id  :{{i}}</H2>

        <H2>Title  :{{blog.title}}</H2>
        <H2>Post  :{{blog.post}}</H2>

    </div>
    <br/>
    <button @click="show=!show">Change Show</button>

    </div>
</template>

<script>
export default {
    data(){
        return{
            count :0 ,
            blogs:[],
            show:false
        }
    },
    methods:{
        incrementer(number){
            this.count+=number;
        }
    },
    created(){
        let posts=[
            {title:'this is the title' , post:'this is the  post'},
            {title:'this is the title' , post:'this is the  post'},
            {title:'this is the title' , post:'this is the  post'},
            {title:'this is the title' , post:'this is the  post'},
            {title:'this is the title' , post:'this is the  post'},
            ]

            this.blogs=posts;
    }
}
</script>