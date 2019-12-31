<template>
    <div id="addComponent">

        <div class="card text-white bg-dark">
            <div class="card-header">Add New User</div>

            <div class="card-body">
                <form @submit="store($event)">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="url">Name</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" required v-model="form.name" id="url" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="date">Email</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" required v-model="form.email" id="date" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="password">Password</label>
                            </div>
                            <div class="col-md-9">
                                <input type="password" v-model="form.password" required id="password" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="date">Role</label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-control" required v-model="form.role">
                                    <option value="1">Admin</option>
                                    <option value="2">User</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-3">
                            <button type="submit" class="btn btn-success btn-block">
                                Add User <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</template>
<script>
export default {
    name : 'add-component' ,
    data(){
        return {
            form : {}
        }
    },
    created(){
        this.init();
    },
    methods : {
        init(){
            this.form = {
                name : '', 
                password : '', 
                role : '', 
                email : '', 
            };
        },
        store(e){
            e.preventDefault();
            this.$emit('storeData' , this.form);
        }
    }
}
</script>

<style lang="scss" scoped>
#addComponent{
    z-index : 1000;
    max-height : 80vh;
    overflow : auto;
}
</style>