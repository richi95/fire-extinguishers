<template>
    <transition name="nested" :duration="550">
        <div class="modal-mask" v-if="showUpdateModal" >
            <div class="modal-container col-6">
                <div class="form-group">
                    <div class="title title-modal">
                        <h2 class="text-danger">Tűzoltó készülék módosítása </h2>
                        <v-icon name="io-close-sharp" class="close-icon" scale="1.25" @click="$emit('close')"/>
                    </div>
                    <div>
                        <label>Telephely</label>
                        <select class="form-select" v-model="feData.place" >
                            <option value="PRÓBAFELADAT1">PRÓBAFELADAT1</option>
                            <option value="PRÓBAFELADAT2">PRÓBAFELADAT2</option>
                            <option value="PRÓBAFELADAT3">PRÓBAFELADAT3</option>
                        </select>
                    </div>
                    <div >
                        <label>Belső azonosító</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            v-model="feData.internal_identifier" 
                            placeholder="belső azonosító">
                    </div>
                    <div>
                        <label>Készenléti helye</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            v-model="feData.standby_location"
                            placeholder="készenléti helye">
                    </div>
                    <div>
                        <label>Készüléktípus</label>
                        <select 
                            class="form-select" 
                            v-model="feData.device_type"
                            >
                            <option value="" disabled selected hidden>készüléktípus</option>
                            <option value="Készülék1">Készülék1</option>
                            <option value="Készülék2">Készülék2</option>
                            <option value="Készülék3">Készülék3</option>
                        </select>
                    </div>
                    <div>
                        <label>Gyári száma</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            v-model="feData.serial_number" 
                            placeholder="gyári száma">
                    </div>
                    <div class="production-date">
                        <label>Gyártás</label>
                        <div>
                            <select id="year" class="form-select" :value="feData.date_of_manufacture.split('-')[0]" 
                                @input="feData.year = $event.target.value">
                                <option disabled selected hidden value="">év</option>
                                <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                            </select>
                            <select id="month" class="form-select" :value="feData.date_of_manufacture.split('-')[1]"
                                @input="feData.month = $event.target.value">
                                <option disabled selected hidden value="">hónap</option>
                                <option v-for="month in months" :key="month" :value="month.toLocaleString('en-US', { minimumIntegerDigits: 2 })">{{ month.toLocaleString('en-US', { minimumIntegerDigits: 2 }) }}</option>
                            </select>
                            <select id="day" class="form-select" :value="feData.date_of_manufacture.split('-')[2]" 
                                @input="feData.day = $event.target.value">
                                <option disabled selected hidden value="">nap</option>
                                <option v-for="day in days" :key="day" :value="day.toLocaleString('en-US', { minimumIntegerDigits: 2 })">{{ day.toLocaleString('en-US', { minimumIntegerDigits: 2 }) }}</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label>Megjegyzés</label>
                        <textarea
                            class="form-control"
                            v-model="feData.comment"
                            placeholder="megjegyzés"
                            ></textarea>
                    </div>
                    <div>
                        <label>Töbszörösítés</label>
                        <select class="form-select" value="1"
                        @input="feData.multiplication = $event.target.value">
                            <option value="1" disabled selected> - </option>
                            <option v-for="piece in pieces" :value="piece">{{ piece }} db</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="button-green" :class="{'button-loading': loading}" @click="updateData()">
                        <div v-if="loading" class="spinner-border spinner-border-sm" role="status"></div>
                        <div v-else>
                            <v-icon name="fa-check" scale="0.75"/> Mentés
                        </div>
                    </button>    
                    <button class="button-red" :class="{'button-loading': loading}" @click="deleteData()">
                        <div v-if="loading" class="spinner-border spinner-border-sm" role="status"></div>
                        <div v-else>
                            <v-icon name="io-close-sharp" /> Törlés
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
            showUpdateModal: Boolean,
            feData: {
                type: Object,
                default: {}
            },
        },
        data() {
            return{
                years: [],
                months: [],
                days: [],
                pieces: [2,3,4,5,6,7,8,9,10],
                loading: false,
            }
        },
        mounted(){
            const currentYear = new Date().getFullYear();
            this.years = Array.from({ length: 50 }, (_, i) => currentYear - i);
            this.months = Array.from({ length: 12 }, (_, i) => 1 + i);
            this.days = Array.from({ length: 31 }, (_, i) => 1 + i);
        },
        methods:{
            async updateData() {
                this.loading = true;
                if(!this.feData.year || !this.feData.month || !this.feData.day){
                    this.feData.year = this.feData.date_of_manufacture.split('-')[0];
                    this.feData.month = this.feData.date_of_manufacture.split('-')[1];
                    this.feData.day = this.feData.date_of_manufacture.split('-')[2];
                }
                if(!this.feData.multiplication) this.feData.multiplication = 1;
                
                try {
                    await axios.put('/fire-extinguishers/'+this.feData.id, this.feData );
                } catch (error) {
                console.error(error);
                }

                this.loading = false;
                this.$emit('refetch');
                this.$emit('close');
            },
            async deleteData() {
                this.loading = true;
                try {
                    await axios.delete('/fire-extinguishers/'+this.feData.id);
                } catch (error) {
                console.error(error);
                }
                this.loading = false;
                this.$emit('refetch');
                this.$emit('close');
            },
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