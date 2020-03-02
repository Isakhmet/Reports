<template>
    <div class="card">
        <div class="card-body">
            <form @submit.prevent="selectedDateReporting">
                <label for="date_starting">Дата с</label>
                <input
                        id="date_starting"
                        class="form-control form-date input-cal"
                        type="date"
                        v-model="date_start"
                        placeholder="Дата с"
                        :max="maxMinDate"
                        required
                >
                <label for="date_ended">Дата по</label>
                <input
                        id="date_ended"
                        class="form-control form-date input-cal"
                        v-model="date_end"
                        placeholder="Дата по"
                        type="date"
                        :min="date_start"
                        required
                >

                <button class="get-report_button">Выгрузить</button>
            </form>

        </div>
    </div>
</template>

<script>
    const today = () => `${new Date().getFullYear()}-${((new Date().getMonth() + 1) < 10) ? '0' + (new Date().getMonth() + 1).toString() : (new Date().getMonth() + 1)}-${((new Date().getDate()) < 10) ? '0' + (new Date().getDate()).toString() : (new Date().getDate())}`
    export default {
        data:     () => ({
            'date_start': today(),
            'date_end':   today(),


        }),
        computed: {
            maxMinDate() {
                return `${new Date().getFullYear()}-${((new Date().getMonth() + 1) < 10) ? '0' + (new Date().getMonth() + 1).toString() : (new Date().getMonth() + 1)}-${((new Date().getDate()) < 10) ? '0' + (new Date().getDate()).toString() : (new Date().getDate())}`
            }
        },


        methods: {

            selectedDateReporting() {
                this.$emit('selectedDateReporting', {date_start: this.date_start, date_end: this.date_end})
            }
        }
    }
</script>

<style>
    .input-cal {
        margin: 0.5em 0 !important;
    }

    .get-report_button {
        border:        none;
        border-radius: 8px;
        padding:       .8rem 1rem;
        background:    darkgreen;
        color:         white;


    }
</style>
