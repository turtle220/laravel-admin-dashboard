<template>
    <div id="Index">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped table-dark">
                <thead>
                    <tr>
                        <th v-for="c in columns" v-bind:key="c.name" @click="order(c.column , c.order.length > 0 ? c.order : 'ASC')">
                            {{c.name}} 
                            
                            <span class="order" v-if="c.order.length == 0">
                                <i class="fa fa-sort"></i>
                            </span>

                            <span class="order_up" v-if="c.order == 'ASC'">
                                <i class="fa fa-arrow-up"></i>
                            </span>

                            <span class="order_down" v-if="c.order == 'DESC'">
                                <i class="fa fa-arrow-down"></i>
                            </span>

                        </th>
                        <th v-if="actions.length > 0">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user , index) in users" v-bind:key="user.id">
                        <td v-for="c in columns" v-bind:key="c.column">
                            <span class="text-white" :href="user.showUrl" @click="show(index)">
                                {{c.if ? user[c.column] == 1 ? 'Yes' : 'No' : user[c.column]}}
                            </span>
                        </td>

                        <td>
                            <div>
                                <a @click.prevent="$emit('DeleteItem' , index)" v-if="actions.includes('DeleteItem')" :href="user.deleteUrl" class="btn btn-danger">Delete <i class="fa fa-times fa-fw"></i></a>
                                <a :href="user.editUrl" @click.prevent="editUser(user.editUrl)" v-if="actions.includes('EditItem')" class="btn btn-info">Edit <i class="fa fa-edit fa-fw"></i></a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>

<script>
export default {
    props:  {
        "users" : {
            required : true,
            type : Array
        },
        "actions" : {
            require : true , 
            type : Array,
        },
        "columns" : {
            require : true , 
            type : Array,
        }
    },
    name : 'IndexComponent' ,
    data(){
        return {
            
        }
    },
    created(){
        window.setInterval(() => {
            this.$forceUpdate();
        } , 1000);
    },
    methods : {
        show(id){
            this.$emit('showData' , id);
        },
        editUser(url){
            axios.get(url+'?api=1')
            .then(r => {
                this.$emit('editUser' , r.data);
            }).catch(e => {
                console.log(e);
            });
        },
        order(column , type){
            this.$emit('orderIndex' , {
                column : column , 
                type : type
            });
        }
    },
    watch : {
        users(){
            console.log('changed');
            this.$forceUpdate();
        }
    }
}
</script>

<style lang="scss" scoped>
th{
    cursor: pointer;
}
.hide{
    display : none;
}
</style>
