<template>
    <div id="addButton">
        <button class="btn btn-success" @click="addNew">Add <i class="fa fa-plug fa-fw"></i></button>
    </div>
</template>

<script>
export default {
    name : 'addComponentButton' ,
    data(){
        return{

        }
    },

    methods : {
        addNew(){
            this.$emit('addNew');
        }
    }

}
</script>
