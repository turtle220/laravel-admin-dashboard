<template>
    <div id="Pagination">
        <div class="float-right">
            <nav aria-label="...">
                <ul class="pagination">
                    <li 
                        :class="`page-item ${currentPage == 1 ? 'active' : ''}`" 
                    >
                        <!-- first page -->
                        <a class="page-link" href="#" @click.prevent="changePage({
                            url : pagination.url ,
                            perpage : pagination.perpage ,
                            offset : (0 * pagination.perpage)
                        })">{{1}}</a>
                    </li>

                    <li 
                        v-if="allPages >= 2"
                        :class="`page-item ${currentPage == 2 ? 'active' : ''}`" 
                    >
                        <!-- first page -->
                        <a class="page-link" href="#" @click.prevent="changePage({
                            url : pagination.url ,
                            perpage : pagination.perpage ,
                            offset : (1 * pagination.perpage)
                        })">{{2}}</a>
                    </li>

                    <li 
                        v-if="allPages >= 3"
                        :class="`page-item ${currentPage == 3 ? 'active' : ''}`" 
                    >
                        <!-- first page -->
                        <a class="page-link" href="#" @click.prevent="changePage({
                            url : pagination.url ,
                            perpage : pagination.perpage ,
                            offset : (2 * pagination.perpage)
                        })">{{3}}</a>
                    </li>

                    <!-- First Seperate -->
                    <li 
                        v-if="allPages > 4 && currentPage > 4"
                        :class="`page-item`" 
                    >
                        <a class="page-link" href="#">---</a>
                    </li>



                    <!-- two pages before current page -->

                    <li 
                        v-if="allPages >= currentPage - 2 && currentPage > 6"
                        class="page-item" 
                    >
                        <!-- first page -->
                        <a class="page-link" href="#" @click.prevent="changePage({
                            url : pagination.url ,
                            perpage : pagination.perpage ,
                            offset : ((currentPage - 3) * pagination.perpage)
                        })">{{currentPage - 2}}</a>
                    </li>


                    <li 
                        v-if="allPages >= currentPage - 1 && currentPage > 5"
                        class="page-item" 
                    >
                        <!-- first page -->
                        <a class="page-link" href="#" @click.prevent="changePage({
                            url : pagination.url ,
                            perpage : pagination.perpage ,
                            offset : ((currentPage - 2) * pagination.perpage)
                        })">{{currentPage - 1}}</a>
                    </li>


                    <!-- current page -->
                    <li 
                        v-if="allPages >= 4 && currentPage >=4"
                        class="page-item active" 
                    >
                        <!-- first page -->
                        <a class="page-link" href="#" @click.prevent="changePage({
                            url : pagination.url ,
                            perpage : pagination.perpage ,
                            offset : ((currentPage - 1) * pagination.perpage)
                        })">{{currentPage}}</a>
                    </li>



                    <!-- two pages after current page -->
                    <li 
                        v-if="allPages >= currentPage + 1 && currentPage >=3"
                        class="page-item" 
                    >
                        <!-- first page -->
                        <a class="page-link" href="#" @click.prevent="changePage({
                            url : pagination.url ,
                            perpage : pagination.perpage ,
                            offset : ((currentPage) * pagination.perpage)
                        })">{{currentPage + 1}}</a>
                    </li>

                    <li 
                        v-if="allPages >= currentPage + 2 && currentPage >=3 && currentPage < allPages - 2"
                        class="page-item" 
                    >
                        <!-- first page -->
                        <a class="page-link" href="#" @click.prevent="changePage({
                            url : pagination.url ,
                            perpage : pagination.perpage ,
                            offset : ((currentPage + 1) * pagination.perpage)
                        })">{{currentPage + 2}}</a>
                    </li>




                    <!-- second Seperate -->
                    <li 
                        v-if="allPages > currentPage + 4"
                        :class="`page-item`" 
                    >
                        <a class="page-link" href="#">---</a>
                    </li>



                    <!-- current page -->
                    <li 
                        v-if="allPages > currentPage + 3"
                        class="page-item" 
                    >
                        <!-- first page -->
                        <a class="page-link" href="#" @click.prevent="changePage({
                            url : pagination.url ,
                            perpage : pagination.perpage ,
                            offset : ((allPages - 3) * pagination.perpage)
                        })">{{allPages - 2}}</a>
                    </li>

                    <!-- current page -->
                    <li 
                        v-if="allPages > currentPage + 2"
                        class="page-item" 
                    >
                        <!-- first page -->
                        <a class="page-link" href="#" @click.prevent="changePage({
                            url : pagination.url ,
                            perpage : pagination.perpage ,
                            offset : ((allPages - 2) * pagination.perpage)
                        })">{{allPages - 1}}</a>
                    </li>

                    <!-- current page -->
                    <li 
                        v-if="allPages > currentPage + 1"
                        class="page-item" 
                    >
                        <!-- first page -->
                        <a class="page-link" href="#" @click.prevent="changePage({
                            url : pagination.url ,
                            perpage : pagination.perpage ,
                            offset : ((allPages - 1) * pagination.perpage)
                        })">{{allPages}}</a>
                    </li>

                </ul>
            </nav>
        </div>
        <div class="float-left">
            <div>
                <span>
                    <span>Showed <i class="fa fa-eye"></i> {{shownEntries}}</span> From <span>{{allEntries}} Entries</span>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name : 'paginationComponent' ,
    props : {
        'pagination' : {
            type : Object
        },
    },
    data(){
        return{
            allPages : null , 
            currentPage : 0,
            allEntries : 0,
            shownEntries : 0,
            maxPages : 10,
        }
    },
    created(){
        this.init();
    },
    methods : {
        init(){
            let num = (parseInt(this.pagination.total) / parseInt(this.pagination.perpage));
            this.allPages = Math.ceil(num);
            this.currentPage = Math.ceil(parseInt(this.pagination.offset) / parseInt(this.pagination.perpage)) + 1;
            this.allEntries = this.pagination.total;
            if(this.pagination.offset == (this.pagination.perpage * (this.allPages - 1))){
                this.shownEntries = this.pagination.total;
            }else{
                this.shownEntries = parseInt(this.pagination.offset) + parseInt(this.pagination.perpage);
            }
        },

        changeToLast(){

        },

        changePage(data){
            this.$emit('changePage' , data);
        }
    },
    watch : {
        pagination(){
            this.init();
        }
    }
}
</script>
