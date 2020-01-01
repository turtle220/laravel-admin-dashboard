<template>
    <div id="LinksDashboard">
        <!-- show add form -->
        <div id="AddSettingsButton">
            <button class="btn btn-success" @click="addForm = !addForm">Toggle Add User</button>
        </div>

        <!-- add form -->
        <transition name="addform">
            <div id="addForm" v-if="addForm">
                <div class="row">
                    <div class="col-md-3" @click="hideAddComponent"></div>
                    <div class="col-md-6">
                        <add-component :show-details="showDetails" :form-details="formDetails" @storeData="store"></add-component>
                    </div>
                    <div class="col-md-3" @click="hideAddComponent"></div>
                </div>

                <div class="overlay" @click="hideAddComponent"></div>
            </div>
        </transition>

        <!-- edit form -->
        <transition name="addform">
            <div id="addForm" v-if="editForm">
                <div class="row">
                    <div class="col-md-3" @click="hideEditComponent"></div>
                    <div class="col-md-6">
                        <EditComponent :show-details="showDetails" :form-details="formDetails" @updateItem="update" :user="editUser"></EditComponent>
                    </div>
                    <div class="col-md-3" @click="hideEditComponent"></div>
                </div>

                <div class="overlay" @click="hideEditComponent"></div>
            </div>
        </transition>
        
        <!-- show Component -->
        <transition name="addform">
            <div id="addForm" v-if="showComponent">
                <div class="row">
                    <div class="col-md-3" @click="hideShowComponent"></div>
                    <div class="col-md-6">
                        <ShowComponent :show-details="showDetails" :columns="columns" :item="showUser"></ShowComponent>
                    </div>
                    <div class="col-md-3" @click="hideShowComponent"></div>
                </div>

                <div class="overlay" @click="hideShowComponent"></div>
            </div>
        </transition>

        <!-- search -->
        <div id="searchSection">
            <searchComponent :search="localData.search" @searchTableData="searchTable" :placeholder="'Search Users'" />
        </div>

        <!-- show data -->
        <div id="tableSection">
            <IndexComponent @orderIndex="orderIndex" :columns="indexColumns" :actions="actions" :users="localData.gw" @showData="show" @DeleteItem="DeleteItem" @editUser="getEditForm" />
        </div>

        <!-- pagination -->
        <div id="pagination">
            <paginationComponent :pagination="localData.pagination" @changePage="PaginationMove"></paginationComponent>
        </div>

        <!-- alerts -->
        <div id="alertsContainer">
            <alertsComponent :alerts="alerts"></alertsComponent>
        </div>
    </div>
</template>

<script>
import AddComponent from './global/AddComponent';
import ShowComponent from './global/ShowComponent';
import EditComponent from './global/EditComponent';
import alertsComponent from './global/alertsComponent';
import searchComponent from './global/searchComponent';
import IndexComponent from './global/IndexComponent';
import paginationComponent from './global/paginationComponent';
export default {
    name : "GatewaysDashboard" , 
    props : {
        "gw" : {
            type : Array ,
            required : true,
        },
        "search" : {
            type : Object,
            required : true,
        },
        'urls' : {
            type : Object,
            required : true,
        },
        "pagination" : {
            required : true,
            type : Object,
        }
    },
    components : {
        'add-component' : AddComponent,
        'ShowComponent' : ShowComponent,
        'alertsComponent' : alertsComponent,
        'searchComponent' : searchComponent,
        'IndexComponent' : IndexComponent,
        'paginationComponent' : paginationComponent,
        'EditComponent'     : EditComponent,
    },
    data(){
        return { 
            alerts : {
                successMessages : [],
                errorMessages : [],
            },
            addForm : false,
            editForm : false,
            showComponent : false,
            editUser : {},
            showUser : {},
            localData : {},
            columns : [
                {
                    name : 'Name' , 
                    column : 'name',
                },
                {
                    name : 'Email' , 
                    column : 'email',
                },
                {
                    name : 'Role' , 
                    column : 'role',
                },
                {
                    name : 'Last Update' , 
                    column : 'updated_at',
                },
                {
                    name : 'Creation Date' , 
                    column : 'created_at',
                },
            ],
            indexColumns : [
                {
                    name : 'ID' ,
                    column : 'id',
                    order : '',
                    if : false,
                },
                {
                    name : 'Name' ,
                    column : 'name',
                    order : '',
                    if : false,
                },
                {
                    name : 'Email' ,
                    column : 'email',
                    order : '',
                    if : false,
                },
                {
                    name : 'Is Admin ?!' ,
                    column : 'role',
                    order : '',
                    if : true,
                },
                {
                    name : 'Last Update',
                    column : 'updated_at' , 
                    order : '',
                    if : false,
                }
            ],
            actions : [
                'DeleteItem' , 'EditItem'
            ],
            showDetails : {
                name : 'User',
                column : 'name'
            },
            formDetails : [
                {
                    name : 'Name' , 
                    placeholder : 'Write User Name' , 
                    type : 'text' , 
                    required : true,
                    class : 'form-control',
                    column : 'name'
                },
                {
                    name : 'Email' , 
                    placeholder : 'Write User email' , 
                    type : 'email' , 
                    required : true,
                    class : 'form-control',
                    column : 'email'
                },
                {
                    name : 'Password' , 
                    placeholder : 'Write User Password' , 
                    type : 'password' , 
                    required : false,
                    class : 'form-control',
                    column : 'password'
                },
                {
                    name : 'Role' , 
                    placeholder : 'Select User Role' , 
                    type : 'selectbox' , 
                    required : true,
                    class : 'form-control',
                    column : 'role',
                    items : [1,2]
                },
            ],
        }
    },
    created(){
        this.init();
    },
    methods : {
        init(){
            this.localData.gw = this.gw;
            this.localData.pagination = this.pagination;
            this.localData.search = this.search;
            this.localData.urls = this.urls;
        },

        orderIndex(data){
            this.indexColumns = this.indexColumns.map(item => {
                if(item.column == data.column){
                    if(data.type == 'DESC'){
                        item.order = 'ASC';
                    }else{
                        item.order = 'DESC';
                    }
                }
                return item;
            });

            axios.get(`${this.search.searchUrl}?order=${data.column}&orderBy=${data.type}&api=1`)
            .then(r => {
                let data = r.data;
                this.localData.gw = data.gw;
                this.localData.pagination = data.pagination;
                this.localData.search = data.search;
                this.localData.urls = data.urls;
                this.$forceUpdate();
            }).catch(e => {
                console.log(e);
            });
        },
        
        store(data){
            axios.post(this.urls.addUrl , data)
            .then(r => {
                this.localData.gw.unshift(r.data);
                this.newAlert('New Gateway Added' , `Gateway ${r.data.name} Was Added Successfully` , true);
                this.hideAddComponent();
                this.$forceUpdate();
            }).catch(e => {
                let error = e.response.data;
                this.newAlert('Gateway Issue' , error.error , false);
            });
            
        },
        DeleteItem(id){
            let gw = this.localData.gw[id];

            axios.post(gw.deleteUrl).then((r) => {
                this.localData.gw.splice(id , 1);
                this.newAlert("Remove Gateway" , r.data.success , true);
            }).catch(e => {
                // let date = new Date().toDateString;
                // this.newAlert("Remove Gateway Error" ,`Unexpected Error ${e.response.data}` , false);
                console.log(e);
            });
        },
        /**
         * show
         */
        show(index){
            this.showUser = this.localData.gw[index];
            this.showShowComponent();
        },
        /**
         * this function add new alert
         */
        newAlert(title , message , success){
            if(success){
                this.alerts.successMessages.push({title:title , text : message});
            }else{
                this.alerts.errorMessages.push({title:title , text : message});
            }
        },

        /**
         * show add Form Component
         */
        showAddComponent(){
            this.addForm = true;
        },
        /**
         * hide add Form Component
         */
        showEditComponent(){
            this.editForm = true;
        },
        /**
         * show add Form Component
         */
        showShowComponent(){
            this.showComponent = true;
        },
        /**
         * hide add Form Component
         */
        hideAddComponent(){
            this.addForm = false;
        },
        /**
         * hide add Form Component
         */
        hideEditComponent(){
            this.editForm = false;
        },
        /**
         * show add Form Component
         */
        hideShowComponent(){
            this.showComponent = false;
        },


        /**
         * pagination move
         */
        PaginationMove(data){
            axios.get(`${data.url}?offset=${data.offset}&perpage=${data.perpage}&search=${this.localData.search.searchPhrase == false ? '' : this.localData.search.searchPhrase}&api=1`)
            .then(r =>{
                let data = r.data;
                this.localData.gw = data.gw;
                this.localData.pagination = data.pagination;
                this.localData.search = data.search;
                this.localData.urls = data.urls;
                this.$forceUpdate();
            }).catch(e =>{
                console.log(e);
            });
        },


        /**
         * search
         */
        searchTable(data){
            axios.get(`${data.url}?perpage=${this.localData.pagination.perpage}&offset=${this.localData.pagination.offset}&search=${data.search}&api=1`)
            .then(r => {
                let data = r.data;
                this.localData.gw = data.gw;
                this.localData.pagination = data.pagination;
                this.localData.search = data.search;
                this.localData.urls = data.urls;
                this.$forceUpdate();
            }).catch(e => {
                console.log(e);
            });
        },


        /**
         * edit form
         */
        getEditForm(data){
            this.editUser = data;
            this.editForm = true;
        },

        /**
         * update form data
         */
        update(data){
            axios.post(data.updateUrl , data)
            .then((r) => {
                this.localData.gw = this.localData.gw.map(item => {
                    if(item.id == r.data.id){
                        return r.data;
                    }
                    return item;
                });
                this.newAlert("Update Gateway" ,`${r.data.name} Updated Successfully` , true);
                this.hideEditComponent();
                this.$forceUpdate();
            }).catch(e => {
                let errors = e.response.data;
                if(errors.error){
                    this.newAlert('Update Gateway Error', errors.error , false);
                }
            });
        },

    }
}
</script>

<style lang="scss" scoped>
#LinksDashboard{
    .overlay{
        position: fixed;
        top : 0px;
        left : 0px;
        z-index : -1;
        width : 100%;
        height : 100%;
        background-color : rgba(0, 0, 0, 0.418);
    }
    #addForm{
        position: fixed;
        top : 0px;
        left : 0px;
        width : 100%;
        height : 100%;
        z-index : 100000;
        display : flex;
        transition: all 0.5s;
        align-items: center;
        .row{
            flex : 1;
        }
    }
    .addform-enter, .addform-leave-to
    /* .list-complete-leave-active below version 2.1.8 */ {
        opacity: 0;
        transform: translateY(30px);
    }
    .addform-leave-active{
        position: absolute;
    }

    /******************alerts section */
    #alertsContainer{
        position: fixed;
        z-index : 10000000000;
        left : 10px;
        bottom : 10px;
        width : 300px;
    }


    // pagination and add button
    #addButton , #pagination{
        display : inline-block;
    }
    #pagination{
        float : right;
    }
}
</style>