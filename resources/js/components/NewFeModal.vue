<template>
    <transition name="nested" :duration="550">
        <div class="modal-mask" v-if="showModal" >
            <div class="modal-container col-6">
                <div class="form-group">
                    <div class="title title-modal">
                        <h2 class="text-danger">Tűzoltó készülék hozzáadása </h2>
                        <v-icon name="io-close-sharp" class="close-icon" scale="1.25" @click="$emit('close')"/>
                    </div>
                    <div>
                        <label for="">Telephely</label>
                        <select class="form-select" v-model="data.place" >
                            <option value="PRÓBAFELADAT1">PRÓBAFELADAT1</option>
                            <option value="PRÓBAFELADAT2">PRÓBAFELADAT2</option>
                            <option value="PRÓBAFELADAT3">PRÓBAFELADAT3</option>
                        </select>
                    </div>
                    <div >
                        <label for="">Belső azonosító</label>
                        <input type="text" class="form-control" v-model="data.internal_identifier" placeholder="belső azonosító">
                    </div>
                    <div>
                        <label for="">Készenléti helye</label>
                        <input type="text" class="form-control" v-model="data.standby_location" placeholder="készenléti helye">
                    </div>
                    <div>
                        <label for="">Készüléktípus</label>
                        <select class="form-select" v-model="data.device_type">
                            <option value="" disabled selected hidden>készüléktípus</option>
                            <option value="Készülék1">Készülék1</option>
                            <option value="Készülék2">Készülék2</option>
                            <option value="Készülék3">Készülék3</option>
                        </select>
                    </div>
                    <div>
                        <label for="">Gyári száma</label>
                        <input type="text" class="form-control" v-model="data.serial_number" placeholder="gyári száma">
                    </div>
                    <div class="production-date">
                        <label for="">Gyártás</label>
                        <div>
                            <select id="year" class="form-select" v-model="data.year">
                                <option disabled selected hidden value="">év</option>
                                <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                            </select>
                            <select id="month" class="form-select" v-model="data.month">
                                <option disabled selected hidden value="">hónap</option>
                                <option v-for="month in months" :key="month" :value="month.toLocaleString('en-US', { minimumIntegerDigits: 2 })">{{ month.toLocaleString('en-US', { minimumIntegerDigits: 2 }) }}</option>
                            </select>
                            <select id="day" class="form-select" v-model="data.day">
                                <option disabled selected hidden value="">nap</option>
                                <option v-for="day in days" :key="day" :value="day.toLocaleString('en-US', { minimumIntegerDigits: 2 })">{{ day.toLocaleString('en-US', { minimumIntegerDigits: 2 }) }}</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="">Megjegyzés</label>
                        <textarea class="form-control" v-model="data.comment" placeholder="megjegyzés"></textarea>
                    </div>
                    <div>
                        <label for="">Töbszörösítés</label>
                        <select class="form-select" v-model="data.multiplication">
                            <option value="" disabled selected> - </option>
                            <option v-for="piece in pieces" :value="piece">{{ piece }} db</option>
                        </select>
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
            showModal: Boolean,
        },
        data() {
            return{
                data:{
                    place: 'PRÓBAFELADAT1',
                    internal_identifier: '',
                    standby_location:'',
                    device_type:'',
                    serial_number:'',
                    year:'',
                    month: '',
                    day: '',
                    comment:'',
                    multiplication:'',
                },
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
            async postData() {
                this.loading = true;
                try {
                    await axios.post('/fire-extinguishers', this.data );
                } catch (error) {
                console.error(error);
                }
                this.loading = true;
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