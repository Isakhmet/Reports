<template>
    <div class="card">
        <div class="card-body">
            <input
                class="form-control form-date input-cal"
                v-model="date_start"
                @click="show_start = true"
                placeholder="Дата с"

            >
            <datepicker @close="show_start = false"
                        v-if="show_start"
                        v-model="date_start"></datepicker>
            <input class="form-control form-date input-cal"
                   v-model="date_end"
                   @click="show_end = true"
                   placeholder="Дата по"

            >
            <datepicker @close="show_end = false"
                        v-if="show_end"
                        v-model="date_end"></datepicker>
            <button @click="goToScoreController()" :class="isLoading">Выгрузить</button>
            <modal v-if="showModal" @close="showModal = false">
                <h4 class="required" slot="header">Заполните обе даты</h4>
            </modal>
        </div>
    </div>
</template>

<script>
    export default {
        data:     function () {
            return {
                'date_start': '',
                'date_end':   '',
                'show_start': false,
                'show_end':   false,
                'showModal': false
            }
        },
        props:    ['path', 'name', 'loading'],
        mounted() {

        },
        computed: {
            isLoading: function () {
                if (this.loading) {
                    return 'btn btn-primary m-progress';
                } else {
                    return 'btn btn-primary';
                }
            },
        },
        methods:  {

            goToScoreController: function () {
                var self = this;

                if (self.date_start == '' || self.date_end == '') {
                    self.showModal = true;
                    console.log(self.showModal);
                } else {
                    let start = self.date_start.replace('T00:00:00.000Z', '');
                    let end   = self.date_end.replace('T00:00:00.000Z', '');

                    this.$emit('sendDate', [self.date_start, self.date_end])
                }
            }
        }
    }
</script>

<style>
    .input-cal {
        margin: 0.5em 0 !important;
    }
</style>
