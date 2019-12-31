<template>
    <div id="AppAlerts">
        <!-- success alerts -->
        <transition-group name="sucessalerts" tag="ul">
            <li v-for="(message , index) in successMessages" v-bind:key="message.text" class="alert_message">
                <div class="card text-white bg-success" @click="closeAlert(index , true)">
                    <div class="card-header" v-if="message.title.length > 1">
                        {{message.title}} <i class="fa fa-check fa-fw"></i>
                        <!-- <span class="float-right">
                            <i class="fa fa-times fa-fw"></i>
                        </span> -->
                    </div>
                    <div class="card-body">
                        {{timeOutCloseAlert(index , message.text , true)}}
                        <!-- <div class="card-title">{{message}}</div> -->
                        <div class="card-text">{{message.text}}</div>
                    </div>
                </div>
            </li>
        </transition-group>

        <!-- Wrong Alerts  -->
        <transition-group name="erroralerts" tag="ul">
            <li v-for="(message , index) in errorMessages" v-bind:key="message.text" class="alert_message">
                <div class="card text-white bg-danger" @click="closeAlert(index , false)">
                    <div class="card-header" v-if="message.title.length > 1">
                        {{message.title}} <i class="fa fa-times fa-fw"></i>
                        <!-- <span class="float-right">
                            <i class="fa fa-times fa-fw"></i>
                        </span> -->
                    </div>
                    <div class="card-body">
                        <!-- <div class="card-title">{{message}}</div> -->
                        {{timeOutCloseAlert(index , message.text , false)}}
                        <div class="card-text">{{message.text}}</div>
                    </div>
                </div>
            </li>
        </transition-group>
    </div>
</template>

<script>
export default {
    name : 'AppAlerts' ,
    props : {
        alerts : {
            required : true,
            type : Object
        }
    },
    data(){
        return{
            successMessages : [],
            errorMessages : [],
            hideMessageAfter : 2000,
        }
    },
    created(){
        this.init();
    },

    methods : {

        init(){
            this.successMessages = this.alerts.successMessages;
            this.errorMessages = this.alerts.errorMessages;
        },

        closeAlert(index , success){
            if(success){
                this.successMessages.splice(index, 1);
            }else{
                this.errorMessages.splice(index, 1);
            }
        },

        timeOutCloseAlert(index , message , success){
            setTimeout(() => {
                if(this.successMessages[index] !== undefined){
                    if(success){
                        this.successMessages[index].text == message ? this.successMessages.splice(index, 1) : null;
                    }else{
                        this.errorMessages[index].text == message ? this.errorMessages.splice(index, 1) : null;
                    }
                }

            } , this.hideMessageAfter);
        }
    },
    watch : {
        alerts(){
            this.init();
        }
    }
}
</script>

<style lang="scss" scoped>
#AppAlerts{
    ul{
        margin : 0px;
        padding : 0px;
        list-style : none;
    }

    // alerts animations
    .alert_message {
        transition: all 1s;
        display: block;
        width : 100%;
    }
    .sucessalerts-enter, .sucessalerts-leave-to , .erroralerts-enter, .erroralerts-leave-to
    /* .list-complete-leave-active below version 2.1.8 */ {
        opacity: 0;
        transform: translateY(30px);
    }
    .sucessalerts-leave-active , .erroralerts-leave-active {
        position: absolute;
    }
}

</style>
