<template>
    <div>
        <flat-pickr :config="config" v-model="date" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" name="trip_date"></flat-pickr>
    </div>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    const today = new Date();
    export default {
        props: ['classname', 'defaultDate'],
        data () {
            return {
                date: null,
                minTripStartDate: null,
                maxTripStartDate: null,
                config: {
                    altFormat: "Y-m-d",
                    altInput: true,
                    minDate: "today",
                    defaultDate: this.date || today,
                    dateFormat: "Y-m-d"
                }
            }
        },
        mounted() {
            this.setSelectedDate();
        },
        methods: {
            setSelectedDate: function () {
                try{
                    this.date = new Date(this.defaultDate).toISOString();
                }
                catch (err){
                }
            }
        },
        components: {
            flatPickr
        }
    }
</script>