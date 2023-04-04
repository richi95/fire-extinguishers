<template>
    <transition name="nested" :duration="550">
        <div class="modal-mask" v-if="showNewService">
            <div class="modal-container col-6 new-service-modal">
                <div class="form-group">
                    <div class="title title-modal">
                        <h2 class="text-danger">Új karbantartás</h2>
                        <v-icon name="io-close-sharp" class="close-icon" scale="1.25" @click="$emit('close')"/>
                    </div>
                    <div>
                        <label for="">Karbantartás</label>
                        <select class="form-select" v-model="data.service">
                            <option value="basic_service">Alapkarbantartás</option>
                            <option value="operator_control">Üzemeltetői ellenőrzés</option>
                        </select>
                    </div>
                    <div >
                        <label for="">Karbantartás dátuma</label>
                        <input type="text" class="form-control" v-model="data.service_date">
                    </div>               
                    <div>
                        <label for="">Megjegyzés</label>
                        <textarea class="form-control" v-model="data.comment"></textarea>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <button class="button-green" :class="{'button-loading': loading}" @click="postData()">
                        <div v-if="loading" class="spinner-border spinner-border-sm" role="status"></div>
                        <div v-else>
                            <v-icon name="fa-check" scale="0.75"/> Mentés
                        </div>
                    </button>    
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import axios from 'axios';
    export default{
        props:{
            showNewService: Boolean,
            newServiceId: Number || String
        },
        data() {
            return{
                data:{
                    service:'basic_service',
                    service_date: this.getNow(),
                    comment:'',
                },
                loading: false
            }
        },
        methods:{
            getNow() {
                const today = new Date();
                return today.getFullYear()+'-'+((today.getMonth()+1).toLocaleString('en-US', { minimumIntegerDigits: 2 }))+'-'+(today.getDate().toLocaleString('en-US', { minimumIntegerDigits: 2 }));
            },
            async postData(){
                this.loading = true
                try{
                    await axios.post('fire-extinguishers/update', {
                        id: this.newServiceId,
                        service: this.data.service,
                        service_date: this.data.service_date,
                        comment: this.data.comment,
                    })
                }catch(error){
                    console.log(error)
                }
                this.loading = false
                this.$emit('refetch')
                this.$emit('close')
            }
        },

    }
</script>
<style scoped>
.nested-enter-active,.nested-leave-active{
    transition: all 0.3s ease;
}
.nested-enter-active .modal-container,.nested-leave-active .modal-container{
    transition: all 0.3s ease;
}


.nested-enter-from ,
.nested-leave-to {
    opacity: 0;
}
.nested-enter-from .modal-container,
.nested-leave-to .modal-container{
    transform: scaleX(0.5);
    opacity: 0;
}
.nested-enter-active .modal-container {
  transition-delay: 0.25s;
}

</style>