<template>
    <div id="search">
        <form :action="search.searchUrl" method="get" @submit.prevent="searchTable()">
            <div class="row">
                <div class="col-md-3">
                    <date-picker
                        v-model="date"
                        format="YYYY-MM-DD"
                        type="date"
                        valueType="format"
                        placeholder="Select date"
                    ></date-picker>
                </div>
                <div class="col-md-7">
                    <input type="text" v-model="searchPhrase" name="search" :placeholder="placeholder" class="form-control">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success btn-block">Search <i class="fa fa-search fa-fw"></i></button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
    name : "searchComponent" ,
    props : {
        "search" : {
            require:  true,
            type : Object,
        },
        'placeholder' : {
            required : true,
        }
    },
    components : {
        'DatePicker' : DatePicker
    },
    data(){
        return {
            searchPhrase : '',
            date : '',
        }
    },
    created(){
        this.searchPhrase = this.search.searchPhrase ? this.search.searchPhrase : '';
    },

    methods : {
        searchTable(){
            if(this.date != undefined && this.date.length > 0){
                this.searchPhrase = this.date+'||filter_date'
            }
            this.$emit('searchTableData' , { url : this.search.searchUrl , search : this.searchPhrase});
        },
    }
}
</script>
