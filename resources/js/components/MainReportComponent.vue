<template>
    <div>
        <div class="col-md-3">
            <div class="ui vertical menu">
                <div class="item">
                    <div class="header">IVR</div>
                    <div class="menu">
                        <a class="item" @click="changeLink(ivr[item], 'ivr', item)"
                           v-for="item in Object.keys(ivr).sort((a,b) => b - a) " :key="item">{{
                            ivr[item] }}</a>
                    </div>
                </div>
                <div class="item">
                    <div class="header">CRM</div>
                    <div class="menu">
                        <a class="item" @click="changeLink(crm[item], 'crm', item)"
                           v-for="item in Object.keys(crm).sort((a,b) => b - a) " :key="item">{{
                            crm[item] }}</a>
                    </div>
                </div>
                <div class="item">
                    <div class="header">ORACLE</div>
                    <div class="menu">
                        <a class="item" @click="changeLink(oracle[item], 'oracle', item)"
                           v-for="item in Object.keys(oracle).sort((a,b) => b - a)" :key="item">{{
                            oracle[item] }}</a>
                    </div>
                </div>
                <div class="item">
                    <div class="header">Sms Campaign Manager</div>
                    <div class="menu">
                        <a class="item" @click="changeLink(sms[item], 'sms', item)"
                           v-for="item in Object.keys(sms).sort((a,b) => b - a) " :key="item">{{
                            sms[item] }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data: function () {
            return {
                link:   0,
                crm:    {
                    60: 'Задания на обзвон (Новый, 060)',
                    34: 'Отправленные заявки (Детали 034)',
                    35: 'LeadEffect',
                    36: 'Заявки EUBANK',
                    37: 'Отказной трафик EUBANK',
                    38: 'Отчет по СМС'
                },
                type:   '',
                oracle: {
                    score_points: 'Скоринг данные',
                    score_values: 'Баллы скоринга',
                    client:       'Данные по клиентам',
                    cluster:      'Кластер',
                    alfa_bank:    'AlfaBank',
                    hcb_long:     'ХКБ лиды длинные',
                    hcb_short:    'ХКБ лиды короткие',
                    agency:       '123Agency'
                },
                sms: {
                    outgoing: 'Исходящие СМС',
                    incoming: 'Входящие СМС'
                },
                ivr: {
                    ivr_send:    'IVR отправка заявки',
                },
            }
        },

        filters: {
            descSort:   function (value) {
                return value.slice().reverse();
            },
            capitalize: function (str) {
                return str.charAt(10).toUpperCase() + str.slice(1)
            }
        },
        methods: {
            changeLink: function (title, type, id) {
                this.$emit('submitClick', [title, type, id])
            },
        }
    }
</script>

<style scoped>

</style>
