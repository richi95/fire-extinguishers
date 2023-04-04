<template>

<table class="fire-table">
    <thead>
        <tr>
            <th></th>
            <th colspan="4">Tűzoltó készülék</th>
            <th>Gyártás</th>
            <th colspan="4">Ellenőrzések időpontja</th>
            <th>Karbantartás időpontja</th>
            <th>Eszköz megj.</th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th>Gyári szám</th>
            <th>Készenléti helye</th>
            <th>Típusa</th>
            <th></th>
            <th>I.<br>n.év</th>
            <th>II.<br>n.év</th>
            <th>III.<br>n.év</th>
            <th>IV.<br>n.év</th>
            <th></th>
            <th></th>

        </tr>
    </thead>
    <tbody>
        <tr v-for="p in data" :class="{'list_success': p?.maintenance}">
            <td>{{ p.id }}</td>
            <td class="d-flex flex-column justify-content-around">
                <div class="icon-button" @click="$emit('fe-data', p)">
                    <v-icon name="fa-fire-extinguisher" class="custom-icon" :inverse="true" />
                </div>
                <div class="icon-button" @click="$emit('new-service', p.id)">
                    <v-icon name="fa-wrench" class="custom-icon" :inverse="true" />
                </div>
            </td>
            <td>{{ p.serial_number }}</td>
            <td>{{ p.internal_identifier }}</td>
            <td><span class="d-flex align-items-center justify-content-around"><v-icon name="fa-fire-extinguisher" class="custom-icon" scale="0.8" fill="#dc3545" /> {{ p.device_type }}</span></td>
            <td>{{ p.date_of_manufacture.replace(/-/g, '.') }}</td>
            <td><span :class="{'bordered-date': p?.maintenance?.first_qt}">{{p?.maintenance?.first_qt }}</span></td>
            <td><span :class="{'bordered-date': p?.maintenance?.second_qt}">{{ p?.maintenance?.second_qt }}</span></td>
            <td><span :class="{'bordered-date': p?.maintenance?.third_qt}">{{  p?.maintenance?.third_qt }}</span></td>
            <td><span :class="{'bordered-date': p?.maintenance?.fourth_qt}">{{ p?.maintenance?.fourth_qt }}</span></td>
            <td><span :class="{'bordered-date': p?.maintenance?.service_date}">{{ handleServiceDate(p?.maintenance?.service_date) }}</span></td>
            <td></td>
        </tr>
    </tbody>
</table>
</template>
<script>
export default{
    props:{
      data: Array
    },
    methods:{
        handleServiceDate(service_date){
            if(service_date){
                return service_date?.split(' ')[1]+' '+service_date.split(' ')[2]
            }else{
                return ""
            }
        },
        handleData(data){
            this.$emit('fe-data', data)
            this.$emit('show-update-modal')
        }
    }
}

</script>