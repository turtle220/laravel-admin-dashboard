<template>
    <div id="addComponent">
        <div class="card text-white bg-dark">
            <div class="card-header">Category {{item.name}}</div>

            <div class="card-body">

                <table class="table table-dark table-bordered">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td>{{item.name}}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{item.email}}</td>
                        </tr>
                        <tr>
                            <th>Is Admin ?!</th>
                            <td>{{item.role == 1 ? 'Yes' : 'No'}}</td>
                        </tr>
                        <tr>
                            <th>Update Date</th>
                            <td>{{item.updated_at}}</td>
                        </tr>
                        <tr>
                            <th>Creation Date</th>
                            <td>{{item.created_at}}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</template>

<script>
export default {
    name : 'ShowComponent' ,
    props : {
        'item' : {
            type : Object ,
            required : true, 
        }
    },
    data(){
        return{
  
        }
    },
    created(){
        this.init();
    },
    methods : {
        init(){

        }
    }
}
</script>


<style lang="scss">
#addComponent{
    z-index : 1000;
    max-height : 80vh;
    overflow : auto;
}
</style>
