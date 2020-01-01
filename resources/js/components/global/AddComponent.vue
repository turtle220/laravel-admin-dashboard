<template>
    <div id="addComponent">

        <div class="card text-white bg-dark">
            <div class="card-header">Add New {{showDetails.name}}</div>

            <div class="card-body">
                <form @submit="store($event)">

                    <div class="form-group" v-for="f in formDetails" v-bind:key="f.name">
                        <div class="row">
                            <div class="col-md-3">
                                <label :for="f.column">{{f.name}}</label>
                            </div>
                            <div class="col-md-9">
                                <input v-if="f.type != 'selectbox'" :type="f.type" :required="f.required ? '' : false" :placeholder="f.placeholder" v-model="form[f.column]" :id="f.column" :class="f.class">
                                <select v-else :type="f.type" :required="f.required ? '' : false" v-model="form[f.column]" :id="f.column" :class="f.class">
                                    <option v-for="v in f.items" v-bind:key="v">
                                        {{v}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-3">
                            <button type="submit" class="btn btn-success btn-block">
                                Add {{showDetails.name}} <i class="fa fa-plus"></i>
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
    props : {
        "formDetails" : {
            require : true,
            type : Array,
        },
        "showDetails" : {
            require : true,
            type : Object
        }
    },
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