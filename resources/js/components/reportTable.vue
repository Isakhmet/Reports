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
                        :next-link-class="'reporting-pagination__el-next'"
                >

                </paginate>
                <div class="select-iteration">
                    <p>Показать <span>
                        <select v-model="iteration">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="150">150</option>
                            <option value="200">200</option>

                        </select>
                    </span> записей на странице</p>
                </div>
                <div class="report-table-info">
                    <p>показано с {{iteration_start + 1}} по {{iteration_end}} из {{reports.excel.data.length}}</p>
                </div>


                <div>

                </div>
                <div class="download-box">

                    <button class="download_button" @click="downloadSelect">скачать</button>
                    <div class="download-box__select" v-if="downloadSelectState">
<!--                        <export-excel-->
<!--                                :data="reports.excel.data"-->
<!--                                :fields="reports.excel.columns"-->
<!--                                worksheet="My Worksheet"-->
<!--                                :name="formName.xls">-->
<!--                            <button class="download_button">xls</button>-->
<!--                        </export-excel>-->

                        <button @click="onexport" class="download_button">xlsx</button>

                        <export-excel
                                :data="reports.excel.data"
                                :fields="reports.excel.columns"
                                type    = "csv"
                                :name    = "formName.csv">
                            <button class="download_button">CSV</button>
                        </export-excel>
                    </div>
                </div>


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
    import XLSX from 'xlsx'
    Vue.component('paginate', Paginate)
    export default {
        data: () => ({

            iteration_start: 0,
            iteration: 10,
            downloadSelectState: false
        }),
        props: {
            reports: {
                type: Object,
                required: true
            },
            tableWidth: {
                type: Number
            },
            formName: {
                type: Object,
                required: true
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
                return parseInt(this.iteration_start) + parseInt(this.iteration)
            }
        },
        methods: {
            paginate(a){
                this.iteration_start = ( (a - 1) * this.iteration )
            },
            downloadSelect(){
                this.downloadSelectState = !this.downloadSelectState
            },

            onexport () { // On Click Excel download button

                var animalWS = XLSX.utils.json_to_sheet(this.reports.excel.data)

                var wb = XLSX.utils.book_new() // make Workbook of Excel

                XLSX.utils.book_append_sheet(wb, animalWS, 'animals') // sheetAName is name of Worksheet

                // export Excel file
                XLSX.writeFile(wb, this.formName.xlsx) // name of the file is 'book.xlsx'
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
            .reporting-head{
                color: white;
                font-size: 1.2rem
            }
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
                padding: .4rem;
            }
        }
    }

    .reporting-pagination{
        .select-iteration{
            padding: 1rem;
        }
    }

    .reporting-pagination__el{
        display: flex;
        align-items: center;
        list-style-type: none;
        margin: 1rem;
        .reporting-pagination__el-item{
            /*list-style-type: none;*/
            a{
                padding: 1rem;
                &:hover{
                    background: #d2d2d2;
                }
            }
            &.active{
                background: #00AA46;
                border-radius: 8px;
                a{
                    color: white;
                }
            }



        }
        .reporting-pagination__el-prev{
            /*list-style-type: none;*/
            padding: 1rem;
            &:hover{
                background: #d2d2d2;
            }
        }
        .reporting-pagination__el-next{
            /*list-style-type: none;*/
            padding: 1rem;
            &:hover{
                background: #d2d2d2;
            }
        }

    }


    .download-box{
        position: relative;
        padding: 0 1rem;
        .download-box__select{
            position: absolute;
            top: 45px;
            left: 0;
            z-index: 2;
            background: #e8e8e8;
            padding: 1rem;
            border-radius: 8px;
        }
    }

    .download_button{
        border: none;
        border-radius: 8px;
        background: #00AA46;
        color: white;
        width: 164px;
        height: 24px;
        font-size: 13px;
        font-weight: 700;
        margin: 0.2rem 0;
    }
    .report-table-info{
        padding: 1rem ;
    }

</style>