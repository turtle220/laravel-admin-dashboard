<template>
    <div id="Index">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped table-dark">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Is Admin ?!</th>
                        <th>Last Update</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user , index) in users" v-bind:key="user.id">
                        <td>
                            <span class="text-white" :href="user.showUrl" @click="show(index)">
                                {{user.id}}
                            </span>
                        </td>

                        <td>
                            <span class="text-white" :href="user.showUrl" @click="show(index)">
                                {{user.name}}
                            </span>
                        </td>
                        
                        <td>
                            <span class="text-white" :href="user.showUrl" @click="show(index)">
                                {{user.email}}
                            </span>
                        </td>

                        <td>
                            <span class="text-white" :href="user.showUrl" @click="show(index)">
                                {{user.role == 1 ? 'Yes' : 'No'}}
                            </span>
                        </td>

                        <td>{{user.updated_at}}</td>

                        <td>
                            <div>
                                <a @click.prevent="$emit('DeleteItem' , index)" :href="user.deleteUrl" class="btn btn-danger">Delete <i class="fa fa-times fa-fw"></i></a>
                                <a :href="user.editUrl" @click.prevent="editUser(user.editUrl)" class="btn btn-info">Edit <i class="fa fa-edit fa-fw"></i></a>
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

<style lang="scss">

</style>
