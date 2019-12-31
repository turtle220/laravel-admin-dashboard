<template>
    <div id="addComponent">

        <div class="card text-white bg-dark">
            <div class="card-header">Edit {{form.name}} Account</div>

            <div class="card-body">
                <form @submit.prevent="update">
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
                                <input type="password" v-model="form.password" placeholder="Leave Empty To Not Edit" id="password" class="form-control">
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
                                Edit User <i class="fa fa-edit"></i>
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
    name : 'EditComponent' ,
    props : {
        'user' : {
            type:  Object ,
            require : true,
        }
    },
    data(){
        return{
            form : {}
        }
    },
    created(){
        this.init();
    },
    methods : {
        init(){
            this.form = this.user;
        },
        update(){
            this.$emit('updateItem' , this.form);
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