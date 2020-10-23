<template>
    <div>
        <h1 ref="test">Im the hook</h1>
        <h1>My name is {{name}} </h1>


    </div>
</template>

<script>
export default {
    data(){
        return{
            name:'omar'
        }
    },
    beforeCreate(){
        console.log('69');
        console.log(this.name);

    },
    created(){
        console.log('70');
        console.log(this.name);
        console.log(this.$refs.test);
    },
    mounted(){
         console.log('71');
        console.log(this.name);
        console.log(this.$refs.test);
    }
}
</script>