<template>
    <div class="card">
        <div class="card-body">
            <form @submit.prevent="selectedDateReporting">
                <input
                        class="form-control form-date input-cal"
                        type="date"
                        v-model="date_start"
                        placeholder="Дата с"
                        :max="maxMinDate"
                        required
                >

                <input class="form-control form-date input-cal"
                       v-model="date_end"
                       placeholder="Дата по"
                       type="date"
                       :min="date_start"
                       required
                >

                <button >Выгрузить</button>
            </form>

        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            'date_start': '',
            'date_end':   '',


        }),
        computed: {
          maxMinDate() {
              return `${new Date().getFullYear()}-${((new Date().getMonth() + 1) < 10) ? '0' + (new Date().getMonth() + 1).toString()  : (new Date().getMonth() + 1)}-${((new Date().getDate()) < 10) ? '0' + (new Date().getDate()).toString()  : (new Date().getDate())}`
          }
        },


        methods:  {

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
</style>
