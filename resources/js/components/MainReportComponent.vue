<template>
    <div>
        <div class="col-md-3">
            <div class="ui vertical menu">
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
                    <div class="header">Hosting</div>
                    <div class="menu">
                        <a class="item" @click="changeLink(item.name)" v-for="item in array">{{ item.name |
                            capitalize}}</a>
                    </div>
                </div>
                <div class="item">
                    <div class="header">Support</div>
                    <div class="menu">
                        <a class="item">E-mail Support</a>
                        <a class="item">FAQs</a>
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
                array:  [
                    {name: '# 001 - Входящие заявки(Детали)'},
                    {name: '# 002 - Входящие заявки(Итоги)'},                    {name: '# 003 - Входящие заявки'},
                ],
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
