<template>
    <modal name="example">
        <div class="parent">
            <div class="data-table" v-if="empty" >
                <div class="main-table">
                    <table class="ui single line table">
                        <tr v-for="(month, index) in amounts" :key="index">
                            <td
                                class="table-head">
                                {{ index }}
                            </td>
                            <td>{{ month }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </modal>
</template>

<script>

    export default {
        name: 'ExampleModal',
        props: {
            months: {type: Object, required: false}
        },
        data () {
            return {
                amounts: Object,
                empty: true
            }
        },
        watch:    {
            months: {
                deep: true,
                handler:   function (months) {
                    this.amounts = months
                },
                immediate: true
            }
        },
        methods: {
            hide: function () {
                this.$modal.pop();
            }
        }
    }
</script>
