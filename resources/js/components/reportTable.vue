<template>
    <div>
        <div class="reporting" >
            <div class="reporting-pagination">
                <paginate
                        :page-count="navigation"
                        :click-handler="paginate"
                        :prev-text="'Prev'"
                        :next-text="'Next'"
                        :container-class="'reporting-pagination__el'"
                        :page-class="'reporting-pagination__el-item'"
                        :prev-link-class="'reporting-pagination__el-prev'"
                >

                </paginate>

            </div>

            <div class="reporting-head-box" :style="{gridTemplateColumns: `40px repeat(${tableHead.length - 1}, 200px)`}">
                <p class="reporting-head" v-for="item in tableHead">{{item}}</p>
            </div>
            <div class="report-table" :style="{gridTemplateColumns: `40px repeat(${tableHead.length - 1}, 200px)`}">

                <template v-for="item in tableContent">
                    <p v-for="i in item" >{{i}}</p>
                </template>

            </div>


        </div>

    </div>
</template>

<script>
    import Paginate from 'vuejs-paginate'
    Vue.component('paginate', Paginate)
    export default {
        data: () => ({
            iteration_start: 0,
            iteration: 10
        }),
        props: {
            reports: {
                type: Object,
                required: true
            },
            tableWidth: {
                type: Number
            }
        },
        computed: {
            tableHead(){
                return ['#', ...Object.values(this.reports.excel.columns)]
            },
            tableContent(){
                return this.tableContentIndexations.slice(parseInt(this.iteration_start), this.iteration_end)
            },
            tableContentIndexations(){
              return this.reports.excel.data.map((item, index) => {
                  return [index + 1, ...Object.values(item)]
              })
            },
            navigation() {
                return Math.ceil(this.tableContentIndexations.length / this.iteration);
            },
            iteration_end(){
                return parseInt(this.iteration_start) + this.iteration
            }
        },
        methods: {
            paginate(a){
                console.log(a)
                this.iteration_start = ( (a - 1) * this.iteration )
            }
        }


    }
</script>

<style lang="scss">
    .reporting{
        overflow: auto;

        .reporting-head-box{
            display: grid;
            grid-gap: 2px;
            background: #3a526b;
            position: sticky;
            top: 0;
            width: max-content;
            padding: 1rem;
        }
        .report-table{
            display: grid;
            grid-gap: 2px;
            padding: 1rem;
            background: gray;
            width: max-content;
            p{
                background: white;
                margin: 0;
            }
        }
    }

    .reporting-pagination__el{
        display: flex;
        align-items: center;
        list-style-type: none;
        .reporting-pagination__el-item{
            /*list-style-type: none;*/
            padding: 1rem;
            &:hover{
                background: gray;
            }

        }
        .reporting-pagination__el-prev{
            /*list-style-type: none;*/
            padding: 1rem;
        }

    }


</style>