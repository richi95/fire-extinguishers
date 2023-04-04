<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 content">
                <div class="title">
                    <h2 class="text-danger">Tűzoltó készülék üzemeltetési napló </h2>
                </div>
                <button @click="showModal = true" class="add-button"><v-icon name="fa-plus" scale="0.75"/> Új tüzoltó készülék</button>

                <table-component :data="data" @fe-data="handleData($event)" @new-service="newService($event)"/>
                <new-fe-modal 
                    :show-modal="showModal" 
                    @close="showModal =false" 
                    @refetch="getFireExtinguishers()"
                    />
                <update-fe-modal 
                    :show-update-modal="showUpdateModal" 
                    @close="showUpdateModal =false" 
                    @refetch="getFireExtinguishers()"
                    :fe-data="feData"
                    />
                <new-service-modal 
                    :show-new-service="showNewService" 
                    :new-service-id="newServiceId" 
                    @close="showNewService =false" 
                    @refetch="getFireExtinguishers()" />

                <div class="pdf-generate">
                    <a href="/fire-extinguishers/generate-pdf" target="_blank" class="pdf-generate-button"><v-icon name="fa-print" scale="0.75"/> Dokumentum készítése</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NewFeModal from './NewFeModal.vue'
import NewServiceModal from './NewServiceModal.vue'
import UpdateFeModal from './UpdateFeModal.vue'
import TableComponent from './Table.vue'
import axios from 'axios'

    export default {
        components:{
            NewFeModal,
            UpdateFeModal,
            NewServiceModal,
            TableComponent,
        },
        data(){
            return{
                feData: {},
                newServiceId: "",
                showModal: false,
                showUpdateModal: false,
                showNewService: false,
                triggerFetch: false,
                data: [],
            }
        },
        methods:{
            handleData(data){
                this.feData = data;
                this.showUpdateModal=true;
            },
            newService(id){
                this.showNewService=true
                this.newServiceId = id;
            },
            async getFireExtinguishers(){
                try{
                    const response = await axios.get('fire-extinguishers');
                    this.data = response.data;
                }catch(error){
                    console.log(error)
                }
            },
        },

 
    }
</script>